<?php

namespace App\Controllers;

use App\Models\RoomModel;
use App\Models\ActivityModel;

class Home extends BaseController
{
    public function index()
    {
        // Initialize our models
        $roomModel = new RoomModel();
        $activityModel = new ActivityModel();
        
        // Get data for the dashboard
        $data = [
            // Room data
            'availableRooms' => $roomModel->countAvailable(),
            'occupiedRooms' => $roomModel->countOccupied(),
            'roomsUnderMaintenance' => $roomModel->countMaintenance(),
            'roomsBlocked' => $roomModel->countBlocked(),
            'availableBedspaces' => $roomModel->getAvailableBedspaces(),
            'blockedDetails' => $roomModel->getBlockedDetails(),
            'maintenanceSchedule' => $roomModel->getMaintenanceSchedule(),
            
            // Activity data
            'recentActivities' => $activityModel->getRecentActivities(),
            'lastActivityTime' => $activityModel->getLastActivityTime(),
            
            // User data (in a real app, this would come from a session/auth service)
            'username' => 'Sharul Aiman'
        ];
        
        // Pass data to the view
        return view('dashboard_new', $data);
    }
}
