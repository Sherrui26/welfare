<?php

namespace App\Models;

use CodeIgniter\Model;

class RoomModel extends Model
{
    protected $table      = 'rooms';
    protected $primaryKey = 'id';
    
    protected $returnType     = 'array';
    protected $useSoftDeletes = false;
    
    protected $allowedFields = [
        'room_number', 'floor', 'room_type', 'capacity', 'status', 'block_reason', 'maintenance_note',
        'last_maintenance_date', 'next_maintenance_date'
    ];
    
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';
    
    // Room statuses
    const STATUS_AVAILABLE = 'available';
    const STATUS_OCCUPIED = 'occupied';
    const STATUS_MAINTENANCE = 'maintenance';
    const STATUS_BLOCKED = 'blocked';
    
    // Validation rules
    protected $validationRules = [
        'room_number' => 'required|is_unique[rooms.room_number,id,{id}]|max_length[20]',
        'floor' => 'required|integer',
        'capacity' => 'required|integer|greater_than[0]',
        'status' => 'required|in_list[available,occupied,maintenance,blocked]'
    ];
    
    protected $validationMessages = [
        'room_number' => [
            'required' => 'Room number is required',
            'is_unique' => 'A room with this number already exists',
        ],
        'capacity' => [
            'greater_than' => 'Capacity must be greater than 0',
        ]
    ];
    
    
    /**
     * Count available rooms
     */
    public function countAvailable()
    {
        return $this->where('status', self::STATUS_AVAILABLE)->countAllResults();
    }
    
    /**
     * Count occupied rooms
     */
    public function countOccupied()
    {
        return $this->where('status', self::STATUS_OCCUPIED)->countAllResults();
    }
    
    /**
     * Count rooms under maintenance
     */
    public function countMaintenance()
    {
        return $this->where('status', self::STATUS_MAINTENANCE)->countAllResults();
    }
    
    /**
     * Count blocked rooms
     */
    public function countBlocked()
    {
        return $this->where('status', self::STATUS_BLOCKED)->countAllResults();
    }
    
    /**
     * Get available bedspaces
     */
    public function getAvailableBedspaces()
    {
        // Get all available rooms with their capacities
        $rooms = $this->where('status', self::STATUS_AVAILABLE)->findAll();
        
        // Initialize counters
        $total = 0;
        $byType = [
            '1-bed' => ['rooms' => 0, 'beds' => 0],
            '2-bed' => ['rooms' => 0, 'beds' => 0],
            '3-bed' => ['rooms' => 0, 'beds' => 0],
            '4-bed' => ['rooms' => 0, 'beds' => 0]
        ];
        
        // Count rooms by capacity
        foreach ($rooms as $room) {
            $capacity = $room['capacity'];
            $key = $capacity . '-bed';
            
            // Make sure key exists in byType array
            if (!isset($byType[$key])) {
                $byType[$key] = ['rooms' => 0, 'beds' => 0];
            }
            
            // Increment counters
            $byType[$key]['rooms']++;
            $byType[$key]['beds'] += $capacity;
            $total += $capacity;
        }
        
        return [
            'total' => $total,
            'byType' => $byType
        ];
    }
    
    /**
     * Get blocked rooms details
     */
    public function getBlockedDetails()
    {
        $blockedRooms = $this->where('status', self::STATUS_BLOCKED)
                            ->select('room_number as room, block_reason as reason')
                            ->findAll();
        
        return $blockedRooms;
    }
    
    /**
     * Get maintenance schedule
     */
    public function getMaintenanceSchedule()
    {
        $now = new \DateTime();
        $lastMaintenance = null;
        $nextScheduled = null;
        
        // Find last maintained room
        $lastRoom = $this->where('last_maintenance_date IS NOT NULL')
                        ->orderBy('last_maintenance_date', 'DESC')
                        ->select('room_number, last_maintenance_date')
                        ->first();
                        
        if ($lastRoom) {
            $lastDate = new \DateTime($lastRoom['last_maintenance_date']);
            $interval = $now->diff($lastDate);
            $lastMaintenance = [
                'room' => $lastRoom['room_number'],
                'daysAgo' => $interval->days
            ];
        }
        
        // Find next scheduled maintenance
        $nextRoom = $this->where('next_maintenance_date IS NOT NULL')
                      ->where('next_maintenance_date >', date('Y-m-d H:i:s'))
                      ->orderBy('next_maintenance_date', 'ASC')
                      ->select('room_number, next_maintenance_date')
                      ->first();
                      
        if ($nextRoom) {
            $nextDate = new \DateTime($nextRoom['next_maintenance_date']);
            $interval = $now->diff($nextDate);
            $nextScheduled = [
                'room' => $nextRoom['room_number'],
                'daysAhead' => $interval->days
            ];
        }
        
        return [
            'lastMaintenance' => $lastMaintenance,
            'nextScheduled' => $nextScheduled
        ];
    }
    
    /**
     * Get all rooms with filters
     */
    public function getRooms($filters = [])
    {
        $builder = $this->builder();
        
        // Apply filters if they exist
        if (isset($filters['room_number']) && !empty($filters['room_number'])) {
            $builder->like('room_number', $filters['room_number']);
        }
        
        if (isset($filters['floor']) && !empty($filters['floor'])) {
            $builder->where('floor', $filters['floor']);
        }
        
        if (isset($filters['room_type']) && !empty($filters['room_type'])) {
            $builder->where('room_type', $filters['room_type']);
        }
        
        if (isset($filters['status']) && !empty($filters['status'])) {
            $builder->where('status', $filters['status']);
        }
        
        if (isset($filters['capacity']) && !empty($filters['capacity'])) {
            $builder->where('capacity', $filters['capacity']);
        }
        
        // Get total count before pagination
        $totalCount = $builder->countAllResults(false);
        
        // Apply pagination if needed
        if (isset($filters['page']) && isset($filters['per_page'])) {
            $page = $filters['page'];
            $perPage = $filters['per_page'];
            $offset = ($page - 1) * $perPage;
            
            $builder->limit($perPage, $offset);
        }
        
        // Order by room number by default
        $builder->orderBy('room_number', 'ASC');
        
        // Get results
        $rooms = $builder->get()->getResultArray();
        
        return [
            'rooms' => $rooms,
            'total' => $totalCount
        ];
    }
    
    /**
     * Get room details with occupants
     */
    public function getRoomDetails($roomId)
    {
        // Get room details
        $room = $this->find($roomId);
        
        if (!$room) {
            return null;
        }
        
        // Get occupants if any
        $occupantsModel = model('RoomOccupantModel');
        $occupants = $occupantsModel->where('room_id', $roomId)->where('status', 'active')->findAll();
        
        // Get amenities if any
        $db = db_connect();
        $amenities = $db->table('room_has_amenities')
            ->join('room_amenities', 'room_amenities.id = room_has_amenities.amenity_id')
            ->where('room_has_amenities.room_id', $roomId)
            ->select('room_amenities.name, room_amenities.icon')
            ->get()->getResultArray();
        
        // Get maintenance logs
        $maintenanceModel = model('RoomMaintenanceLogModel');
        $maintenanceLogs = $maintenanceModel->where('room_id', $roomId)
            ->orderBy('maintenance_date', 'DESC')
            ->limit(5)
            ->findAll();
        
        // Return complete room details
        return [
            'room' => $room,
            'occupants' => $occupants,
            'amenities' => $amenities,
            'maintenanceLogs' => $maintenanceLogs,
            'occupiedBedspaces' => count($occupants),
            'availableBedspaces' => $room['capacity'] - count($occupants)
        ];
    }
    
    /**
     * Get rooms stats for dashboard
     */
    public function getRoomStats()
    {
        return [
            'total' => $this->countAllResults(),
            'available' => $this->countAvailable(),
            'occupied' => $this->countOccupied(),
            'maintenance' => $this->countMaintenance(),
            'blocked' => $this->countBlocked(),
        ];
    }
}
