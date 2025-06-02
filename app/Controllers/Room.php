<?php

namespace App\Controllers;

class Room extends BaseController
{
    protected $roomModel;
    protected $occupantModel;
    protected $maintenanceModel;
    
    public function __construct()
    {
        $this->roomModel = model('RoomModel');
        $this->occupantModel = model('RoomOccupantModel');
        $this->maintenanceModel = model('RoomMaintenanceLogModel');
    }
    
    public function index()
    {
        // Get filter values from request
        $filters = [
            'room_number' => $this->request->getGet('room_number'),
            'floor' => $this->request->getGet('floor'),
            'room_type' => $this->request->getGet('room_type'),
            'status' => $this->request->getGet('status'),
            'page' => $this->request->getGet('page') ?? 1,
            'per_page' => $this->request->getGet('per_page') ?? 10
        ];
        
        // Get rooms with pagination
        $roomData = $this->roomModel->getRooms($filters);
        
        // Get room types for filter dropdown
        $roomTypes = ['Single', 'Double', 'Triple', 'Quad'];
        
        // Calculate pagination values
        $pager = service('pager');
        $page = $filters['page'];
        $perPage = $filters['per_page'];
        $total = $roomData['total'];
        $pager->makeLinks($page, $perPage, $total);
        
        // Prepare data for view
        $data = [
            'rooms' => $roomData['rooms'],
            'total' => $total,
            'pager' => $pager,
            'roomTypes' => $roomTypes,
            'filters' => $filters,
            'currentPage' => $page,
            'perPage' => $perPage,
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
            
            // Attempt to create room
            if ($this->roomModel->insert($roomData)) {
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Room created successfully',
                    'room_id' => $this->roomModel->getInsertID()
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
            
            // Only include block_reason if status is blocked
            if ($roomData['status'] === 'blocked') {
                $roomData['block_reason'] = $this->request->getPost('block_reason');
            }
            
            // Attempt to update room
            if ($this->roomModel->update($id, $roomData)) {
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
        
        $result = $this->occupantModel->removeOccupant($occupantId);
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
}
