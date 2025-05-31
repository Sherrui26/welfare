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
        'room_number', 'floor', 'capacity', 'status', 'block_reason', 'maintenance_note',
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
}
