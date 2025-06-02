<?php

namespace App\Models;

use CodeIgniter\Model;

class RoomOccupantModel extends Model
{
    protected $table      = 'room_occupants';
    protected $primaryKey = 'id';
    
    protected $returnType     = 'array';
    protected $useSoftDeletes = false;
    
    protected $allowedFields = [
        'room_id', 'occupant_name', 'occupant_id', 'occupant_type', 
        'check_in_date', 'check_out_date', 'status'
    ];
    
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    
    // Validation rules
    protected $validationRules = [
        'room_id' => 'required|integer',
        'occupant_name' => 'required|max_length[100]',
        'occupant_id' => 'permit_empty|max_length[50]',
        'check_in_date' => 'required|valid_date',
    ];
    
    /**
     * Get active occupants for a specific room
     */
    public function getActiveOccupants($roomId)
    {
        return $this->where('room_id', $roomId)
                    ->where('status', 'active')
                    ->findAll();
    }
    
    /**
     * Get occupancy count for a specific room
     */
    public function getOccupancyCount($roomId)
    {
        return $this->where('room_id', $roomId)
                    ->where('status', 'active')
                    ->countAllResults();
    }
    
    /**
     * Assign occupant to a room
     */
    public function assignOccupant($data)
    {
        // Make sure the room is not already full
        $roomModel = model('RoomModel');
        $room = $roomModel->find($data['room_id']);
        
        if (!$room) {
            return [
                'success' => false,
                'message' => 'Room not found'
            ];
        }
        
        $currentOccupants = $this->getOccupancyCount($data['room_id']);
        
        if ($currentOccupants >= $room['capacity']) {
            return [
                'success' => false,
                'message' => 'Room is already at full capacity'
            ];
        }
        
        // Set check-in date if not provided
        if (!isset($data['check_in_date']) || empty($data['check_in_date'])) {
            $data['check_in_date'] = date('Y-m-d');
        }
        
        // Set status to active
        $data['status'] = 'active';
        
        // Insert the occupant
        $success = $this->insert($data);
        
        if ($success) {
            // Update room status if needed
            $newOccupants = $currentOccupants + 1;
            if ($newOccupants == $room['capacity']) {
                $roomModel->update($data['room_id'], ['status' => 'occupied']);
            } else if ($room['status'] == 'available') {
                // No status change needed
            } else {
                $roomModel->update($data['room_id'], ['status' => 'occupied']);
            }
            
            return [
                'success' => true,
                'message' => 'Occupant assigned successfully',
                'id' => $success
            ];
        }
        
        return [
            'success' => false,
            'message' => 'Failed to assign occupant'
        ];
    }
    
    /**
     * Remove occupant from a room
     */
    public function removeOccupant($occupantId)
    {
        $occupant = $this->find($occupantId);
        
        if (!$occupant) {
            return [
                'success' => false,
                'message' => 'Occupant not found'
            ];
        }
        
        $roomId = $occupant['room_id'];
        
        // Update occupant status and check-out date
        $success = $this->update($occupantId, [
            'status' => 'inactive',
            'check_out_date' => date('Y-m-d')
        ]);
        
        if ($success) {
            // Update room status if needed
            $roomModel = model('RoomModel');
            $room = $roomModel->find($roomId);
            
            $currentOccupants = $this->getOccupancyCount($roomId);
            
            if ($currentOccupants == 0 && $room['status'] == 'occupied') {
                $roomModel->update($roomId, ['status' => 'available']);
            }
            
            return [
                'success' => true,
                'message' => 'Occupant removed successfully'
            ];
        }
        
        return [
            'success' => false,
            'message' => 'Failed to remove occupant'
        ];
    }
}
