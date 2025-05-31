<?php

namespace App\Models;

use CodeIgniter\Model;

class RoomModel extends Model
{
    protected $table      = 'rooms';
    protected $primaryKey = 'id';
    
    protected $allowedFields = [
        'room_number', 'floor', 'capacity', 'status', 'type', 'bedspaces_total', 'bedspaces_occupied'
    ];
    
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
        // For demo, return hardcoded value - in production this would query the database
        return 83;
    }
    
    /**
     * Count occupied rooms
     */
    public function countOccupied()
    {
        // For demo, return hardcoded value - in production this would query the database
        return 51;
    }
    
    /**
     * Count rooms under maintenance
     */
    public function countMaintenance()
    {
        // For demo, return hardcoded value - in production this would query the database
        return 0;
    }
    
    /**
     * Count blocked rooms
     */
    public function countBlocked()
    {
        // For demo, return hardcoded value - in production this would query the database
        return 3;
    }
    
    /**
     * Get available bedspaces
     */
    public function getAvailableBedspaces()
    {
        // For demo, return hardcoded value - in production this would query the database
        return [
            'total' => 155,
            'byType' => [
                '2-bed' => ['rooms' => 3, 'beds' => 6],
                '3-bed' => ['rooms' => 0, 'beds' => 0],
                '4-bed' => ['rooms' => 4, 'beds' => 16],
                '5-bed' => ['rooms' => 17, 'beds' => 85],
                '6-bed' => ['rooms' => 8, 'beds' => 48]
            ]
        ];
    }
    
    /**
     * Get blocked rooms details
     */
    public function getBlockedDetails()
    {
        // For demo, return hardcoded value - in production this would query the database
        return [
            ['room' => '103', 'reason' => 'Plumbing issues'],
            ['room' => '215', 'reason' => 'Electrical repairs'],
            ['room' => '307', 'reason' => 'Renovation']
        ];
    }
    
    /**
     * Get maintenance schedule
     */
    public function getMaintenanceSchedule()
    {
        // For demo, return hardcoded value - in production this would query the database
        return [
            'lastMaintenance' => ['room' => '202', 'daysAgo' => 3],
            'nextScheduled' => ['room' => '105', 'daysAhead' => 5]
        ];
    }
}
