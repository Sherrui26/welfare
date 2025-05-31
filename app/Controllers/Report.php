<?php

namespace App\Controllers;

use App\Models\RoomModel;
use App\Models\ActivityModel;

class Report extends BaseController
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
            
            // Page specific data
            'username' => 'Sharul Aiman',
            'pageTitle' => 'Report Generation'
        ];
        
        // Pass data to the view
        return view('dashboard_new', $data);
    }
}
