<?php

namespace App\Controllers;

class Room extends BaseController
{
    protected $roomModel;
    protected $occupantModel;
    protected $maintenanceModel;
    protected $activityModel;
    
    /**
     * Helper method to get icon for room status
     */
    private function getStatusIcon($status)
    {
        switch($status) {
            case 'available':
                return 'fa-check-circle';
            case 'maintenance':
                return 'fa-tools';
            case 'blocked':
                return 'fa-ban';
            default:
                return 'fa-door-open';
        }
    }
    
    /**
     * Helper method to get color for room status
     */
    private function getStatusColor($status)
    {
        switch($status) {
            case 'available':
                return 'green';
            case 'maintenance':
                return 'yellow';
            case 'blocked':
                return 'red';
            default:
                return 'blue';
        }
    }
    
    public function __construct()
    {
        $this->roomModel = model('RoomModel');
        $this->occupantModel = model('RoomOccupantModel');
        $this->maintenanceModel = model('RoomMaintenanceLogModel');
        $this->activityModel = model('ActivityModel');
    }
    
    public function index()
    {
        // Get search query from request
        $search = $this->request->getGet('search');
        
        // Get filter values from request
        $filters = [
            'search' => $search,
            'floor' => $this->request->getGet('floor'),
            'room_type' => $this->request->getGet('room_type'),
            'status' => $this->request->getGet('status'),
            'page' => $this->request->getGet('page') ?? 1,
            'per_page' => $this->request->getGet('per_page') ?? 10
        ];
        
        // Get rooms with pagination
        $roomData = $this->roomModel->getRooms($filters);
        
        // Get room stats for quick stats cards
        $roomStats = [
            'total_capacity' => 0,
            'total_occupied' => 0,
            'available_count' => $this->roomModel->countAvailable(),
            'maintenance_count' => $this->roomModel->countMaintenance(),
            'blocked_count' => $this->roomModel->countBlocked()
        ];
        
        // Calculate total capacity and occupied beds
        foreach ($roomData['rooms'] as $room) {
            $roomStats['total_capacity'] += $room['capacity'];
            $occupiedBeds = $this->occupantModel->getOccupancyCount($room['id']);
            $roomStats['total_occupied'] += $occupiedBeds;
            
            // Add available bedspaces to each room
            $room['available_bedspaces'] = $room['capacity'] - $occupiedBeds;
        }
        
        // Get room types for dropdown
        $roomTypes = ['standard', 'deluxe', 'suite'];
        
        // Calculate pagination values
        $pager = service('pager');
        $page = $filters['page'];
        $perPage = $filters['per_page'];
        $total = $roomData['total'];
        $pagerLinks = $pager->makeLinks($page, $perPage, $total, 'default_full');
        
        // Prepare data for view
        $data = [
            'rooms' => $roomData['rooms'],
            'total' => $total,
            'pager' => $pager,
            'pagerLinks' => $pagerLinks,
            'roomTypes' => $roomTypes,
            'filters' => $filters,
            'currentPage' => $page,
            'perPage' => $perPage,
            'roomStats' => $roomStats
        ];
        
        return view('manage-room', $data);
    }
    
    public function view($id = null)
    {
        if ($id === null) {
            return redirect()->to('/room')->with('error', 'Room ID is required');
        }
        
        $roomDetails = $this->roomModel->getRoomDetails($id);
        
        if (!$roomDetails) {
            return redirect()->to('/room')->with('error', 'Room not found');
        }
        
        $data = [
            'roomDetails' => $roomDetails
        ];
        
        return view('room/view', $data);
    }
    
    public function create()
    {
        // If form is submitted
        if ($this->request->getMethod() === 'post') {
            $roomData = [
                'room_number' => $this->request->getPost('room_number'),
                'floor' => $this->request->getPost('floor'),
                'room_type' => $this->request->getPost('room_type'),
                'capacity' => $this->request->getPost('capacity'),
                'status' => $this->request->getPost('status') ?? 'available',
            ];
            
            // Add maintenance_note if status is maintenance
            if ($roomData['status'] === 'maintenance') {
                $roomData['maintenance_note'] = $this->request->getPost('maintenance_note');
                $roomData['next_maintenance_date'] = $this->request->getPost('next_maintenance_date') ?? null;
            }
            
            // Add block_reason if status is blocked
            if ($roomData['status'] === 'blocked') {
                $roomData['block_reason'] = $this->request->getPost('block_reason');
            }
            
            // Attempt to create room
            if ($this->roomModel->insert($roomData)) {
                $roomId = $this->roomModel->getInsertID();
                
                // Log activity
                $activityData = [
                    'activity_type' => 'room-created',
                    'room_number' => $roomData['room_number'],
                    'description' => "New room {$roomData['room_number']} created on floor {$roomData['floor']} with {$roomData['capacity']} beds",
                    'icon' => 'fa-door-open',
                    'color' => 'blue',
                    'timestamp' => date('Y-m-d H:i:s'),
                    'user_id' => session()->get('user_id') ?? 1
                ];
                $this->activityModel->insert($activityData);
                
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Room created successfully',
                    'room_id' => $roomId
                ]);
            } else {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Failed to create room',
                    'errors' => $this->roomModel->errors()
                ]);
            }
        }
        
        // If not POST, return error
        return $this->response->setJSON([
            'success' => false,
            'message' => 'Invalid request method'
        ]);
    }
    
    public function update($id = null)
    {
        if ($id === null) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Room ID is required'
            ]);
        }
        
        // Check if room exists
        $room = $this->roomModel->find($id);
        if (!$room) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Room not found'
            ]);
        }
        
        // If form is submitted
        if ($this->request->getMethod() === 'post') {
            $roomData = [
                'room_number' => $this->request->getPost('room_number'),
                'floor' => $this->request->getPost('floor'),
                'room_type' => $this->request->getPost('room_type'),
                'capacity' => $this->request->getPost('capacity'),
                'status' => $this->request->getPost('status'),
            ];
            
            // Handle status-specific fields
            if ($roomData['status'] === 'blocked') {
                $roomData['block_reason'] = $this->request->getPost('block_reason');
                // Clear maintenance fields if previously in maintenance
                $roomData['maintenance_note'] = null;
                $roomData['next_maintenance_date'] = null;
            } else if ($roomData['status'] === 'maintenance') {
                $roomData['maintenance_note'] = $this->request->getPost('maintenance_note');
                $roomData['next_maintenance_date'] = $this->request->getPost('next_maintenance_date') ?? null;
                // Clear block reason if previously blocked
                $roomData['block_reason'] = null;
            } else {
                // For available or occupied status, clear both maintenance and block fields
                $roomData['maintenance_note'] = null;
                $roomData['next_maintenance_date'] = null;
                $roomData['block_reason'] = null;
            }
            
            // Attempt to update room
            if ($this->roomModel->update($id, $roomData)) {
                // Log activity for status change
                if ($room['status'] !== $roomData['status']) {
                    $activityData = [
                        'activity_type' => 'room-status-updated',
                        'room_number' => $roomData['room_number'],
                        'description' => "Room {$roomData['room_number']} status changed from {$room['status']} to {$roomData['status']}",
                        'icon' => $this->getStatusIcon($roomData['status']),
                        'color' => $this->getStatusColor($roomData['status']),
                        'timestamp' => date('Y-m-d H:i:s'),
                        'user_id' => session()->get('user_id') ?? 1
                    ];
                    $this->activityModel->insert($activityData);
                }
                
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Room updated successfully'
                ]);
            } else {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Failed to update room',
                    'errors' => $this->roomModel->errors()
                ]);
            }
        }
        
        // If GET request, return room data for form
        return $this->response->setJSON([
            'success' => true,
            'room' => $room
        ]);
    }
    
    public function delete($id = null)
    {
        if ($id === null) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Room ID is required'
            ]);
        }
        
        // Check if room exists
        $room = $this->roomModel->find($id);
        if (!$room) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Room not found'
            ]);
        }
        
        // Check if room has active occupants
        $activeOccupants = $this->occupantModel->getOccupancyCount($id);
        if ($activeOccupants > 0) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Cannot delete room with active occupants'
            ]);
        }
        
        // Delete room
        if ($this->roomModel->delete($id)) {
            // Log activity
            $activityData = [
                'activity_type' => 'room-deleted',
                'room_number' => $room['room_number'],
                'description' => "Room {$room['room_number']} on floor {$room['floor']} has been deleted",
                'icon' => 'fa-trash',
                'color' => 'red',
                'timestamp' => date('Y-m-d H:i:s'),
                'user_id' => session()->get('user_id') ?? 1
            ];
            $this->activityModel->insert($activityData);
            
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Room deleted successfully'
            ]);
        } else {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Failed to delete room'
            ]);
        }
    }
    
    public function assignOccupant()
    {
        if ($this->request->getMethod() !== 'post') {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Invalid request method'
            ]);
        }
        
        $occupantData = [
            'room_id' => $this->request->getPost('room_id'),
            'occupant_name' => $this->request->getPost('occupant_name'),
            'occupant_id' => $this->request->getPost('occupant_id'),
            'occupant_type' => $this->request->getPost('occupant_type'),
            'check_in_date' => $this->request->getPost('check_in_date') ?? date('Y-m-d'),
        ];
        
        $result = $this->occupantModel->assignOccupant($occupantData);
        
        // If occupant was successfully assigned, log the activity
        if (isset($result['success']) && $result['success']) {
            // Get room details for the activity log
            $room = $this->roomModel->find($occupantData['room_id']);
            
            $activityData = [
                'activity_type' => 'check-in',
                'room_number' => $room['room_number'] ?? 'Unknown',
                'tenant_id' => $occupantData['occupant_id'],
                'description' => "{$occupantData['occupant_name']} ({$occupantData['occupant_type']}) assigned to Room {$room['room_number']}",
                'icon' => 'fa-user-plus',
                'color' => 'green',
                'timestamp' => date('Y-m-d H:i:s'),
                'user_id' => session()->get('user_id') ?? 1
            ];
            $this->activityModel->insert($activityData);
        }
        
        return $this->response->setJSON($result);
    }
    
    public function removeOccupant($occupantId = null)
    {
        if ($occupantId === null) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Occupant ID is required'
            ]);
        }
        
        // Get occupant details before removal for the activity log
        $occupant = $this->occupantModel->find($occupantId);
        $result = $this->occupantModel->removeOccupant($occupantId);
        
        // If occupant was successfully removed, log the activity
        if (isset($result['success']) && $result['success'] && $occupant) {
            // Get room details
            $room = $this->roomModel->find($occupant['room_id']);
            
            $activityData = [
                'activity_type' => 'check-out',
                'room_number' => $room['room_number'] ?? 'Unknown',
                'tenant_id' => $occupant['occupant_id'],
                'description' => "{$occupant['occupant_name']} checked out from Room {$room['room_number']}",
                'icon' => 'fa-user-minus',
                'color' => 'red',
                'timestamp' => date('Y-m-d H:i:s'),
                'user_id' => session()->get('user_id') ?? 1
            ];
            $this->activityModel->insert($activityData);
        }
        
        return $this->response->setJSON($result);
    }
    
    public function scheduleMaintenance()
    {
        if ($this->request->getMethod() !== 'post') {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Invalid request method'
            ]);
        }
        
        $roomId = $this->request->getPost('room_id');
        $maintenanceDate = $this->request->getPost('maintenance_date');
        $maintenanceType = $this->request->getPost('maintenance_type');
        $notes = $this->request->getPost('notes') ?? '';
        
        $result = $this->maintenanceModel->scheduleMaintenance(
            $roomId, $maintenanceDate, $maintenanceType, $notes
        );
        
        // If maintenance was successfully scheduled, log the activity
        if (isset($result['success']) && $result['success']) {
            // Get room details
            $room = $this->roomModel->find($roomId);
            
            $activityData = [
                'activity_type' => 'maintenance',
                'room_number' => $room['room_number'] ?? 'Unknown',
                'description' => "Maintenance scheduled for Room {$room['room_number']} on " . date('M j, Y', strtotime($maintenanceDate)) . " ({$maintenanceType})",
                'icon' => 'fa-tools',
                'color' => 'yellow',
                'timestamp' => date('Y-m-d H:i:s'),
                'user_id' => session()->get('user_id') ?? 1
            ];
            $this->activityModel->insert($activityData);
        }
        
        return $this->response->setJSON($result);
    }
    
    public function getStats()
    {
        $stats = $this->roomModel->getRoomStats();
        return $this->response->setJSON($stats);
    }
    
    public function getRoomOccupants($roomId = null)
    {
        if ($roomId === null) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Room ID is required'
            ]);
        }
        
        $occupants = $this->occupantModel->getActiveOccupants($roomId);
        return $this->response->setJSON([
            'success' => true,
            'occupants' => $occupants
        ]);
    }
    
    public function getRoomDetails($roomId = null)
    {
        if ($roomId === null) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Room ID is required'
            ]);
        }
        
        $roomDetails = $this->roomModel->getRoomDetails($roomId);
        
        if (!$roomDetails) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Room not found'
            ]);
        }
        
        return $this->response->setJSON([
            'success' => true,
            'roomDetails' => $roomDetails
        ]);
    }
    
    /**
     * Get room data for edit modal
     */
    public function get($id = null)
    {
        if ($id === null) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Room ID is required'
            ]);
        }
        
        $room = $this->roomModel->find($id);
        
        if (!$room) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Room not found'
            ]);
        }
        
        // Get current occupancy count
        $occupancy = $this->occupantModel->getOccupancyCount($id);
        $room['occupied_beds'] = $occupancy;
        $room['available_beds'] = $room['capacity'] - $occupancy;
        
        return $this->response->setJSON([
            'success' => true,
            'room' => $room
        ]);
    }
}
