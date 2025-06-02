<?php

namespace App\Models;

use CodeIgniter\Model;

class RoomMaintenanceLogModel extends Model
{
    protected $table      = 'room_maintenance_logs';
    protected $primaryKey = 'id';
    
    protected $returnType     = 'array';
    protected $useSoftDeletes = false;
    
    protected $allowedFields = [
        'room_id', 'maintenance_date', 'maintenance_type', 
        'maintenance_notes', 'performed_by'
    ];
    
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    
    // Validation rules
    protected $validationRules = [
        'room_id' => 'required|integer',
        'maintenance_date' => 'required|valid_date',
        'maintenance_type' => 'required|max_length[50]'
    ];
    
    /**
     * Log a maintenance event and update room status
     */
    public function logMaintenance($data)
    {
        // Set maintenance date to today if not provided
        if (!isset($data['maintenance_date']) || empty($data['maintenance_date'])) {
            $data['maintenance_date'] = date('Y-m-d');
        }
        
        // Insert maintenance log
        $success = $this->insert($data);
        
        if ($success) {
            // Update room last maintenance date
            $roomModel = model('RoomModel');
            $roomModel->update($data['room_id'], [
                'last_maintenance_date' => date('Y-m-d H:i:s')
            ]);
            
            return [
                'success' => true,
                'message' => 'Maintenance logged successfully',
                'id' => $success
            ];
        }
        
        return [
            'success' => false,
            'message' => 'Failed to log maintenance'
        ];
    }
    
    /**
     * Schedule maintenance for a room
     */
    public function scheduleMaintenance($roomId, $maintenanceDate, $maintenanceType, $notes = '')
    {
        // First, update the room status to maintenance
        $roomModel = model('RoomModel');
        $room = $roomModel->find($roomId);
        
        if (!$room) {
            return [
                'success' => false,
                'message' => 'Room not found'
            ];
        }
        
        // Only change status if maintenance is scheduled for today
        $today = date('Y-m-d');
        if ($maintenanceDate == $today) {
            $roomModel->update($roomId, [
                'status' => 'maintenance',
                'maintenance_note' => $notes,
                'next_maintenance_date' => $maintenanceDate . ' 00:00:00'
            ]);
        } else {
            $roomModel->update($roomId, [
                'next_maintenance_date' => $maintenanceDate . ' 00:00:00'
            ]);
        }
        
        // Log the scheduled maintenance
        return $this->logMaintenance([
            'room_id' => $roomId,
            'maintenance_date' => $maintenanceDate,
            'maintenance_type' => $maintenanceType,
            'maintenance_notes' => $notes . ' (Scheduled)',
        ]);
    }
    
    /**
     * Get maintenance history for a room
     */
    public function getMaintenanceHistory($roomId, $limit = 10)
    {
        return $this->where('room_id', $roomId)
                    ->orderBy('maintenance_date', 'DESC')
                    ->limit($limit)
                    ->findAll();
    }
    
    /**
     * Get upcoming maintenance schedules
     */
    public function getUpcomingMaintenance($limit = 5)
    {
        $db = db_connect();
        $today = date('Y-m-d');
        
        return $db->table('rooms')
                ->where('next_maintenance_date >=', $today)
                ->orderBy('next_maintenance_date', 'ASC')
                ->select('id, room_number, next_maintenance_date, maintenance_note')
                ->limit($limit)
                ->get()
                ->getResultArray();
    }
}
