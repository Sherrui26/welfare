<?php

namespace App\Models;

use CodeIgniter\Model;

class ActivityModel extends Model
{
    protected $table      = 'activities';
    protected $primaryKey = 'id';
    
    protected $allowedFields = [
        'activity_type', 'room_number', 'description', 'user_id', 'timestamp'
    ];
    
    // Activity types
    const TYPE_CHECKIN = 'check-in';
    const TYPE_CHECKOUT = 'check-out';
    const TYPE_MAINTENANCE = 'maintenance';
    const TYPE_PAYMENT = 'payment';
    
    /**
     * Get recent activities
     */
    public function getRecentActivities($limit = 5)
    {
        // For demo, return hardcoded activities
        return [
            [
                'type' => self::TYPE_CHECKIN,
                'icon' => 'fa-sign-in-alt',
                'color' => 'green',
                'title' => 'Check-in: Room 101',
                'description' => 'John Smith has checked in',
                'time' => '11:32 AM'
            ],
            [
                'type' => self::TYPE_CHECKOUT,
                'icon' => 'fa-sign-out-alt',
                'color' => 'red',
                'title' => 'Check-out: Room 102',
                'description' => 'Jane Cooper has checked out',
                'time' => '10:15 AM'
            ],
            [
                'type' => self::TYPE_MAINTENANCE,
                'icon' => 'fa-tools',
                'color' => 'yellow',
                'title' => 'Maintenance: Room 103',
                'description' => 'Plumbing issue reported',
                'time' => '9:45 AM'
            ],
            [
                'type' => self::TYPE_PAYMENT,
                'icon' => 'fa-money-bill-wave',
                'color' => 'blue',
                'title' => 'Payment Received: Room 201',
                'description' => 'Monthly rent payment processed',
                'time' => '8:20 AM'
            ]
        ];
    }
    
    /**
     * Get last activity timestamp
     */
    public function getLastActivityTime()
    {
        // For demo, return hardcoded time
        return 'Today, 2:37 PM';
    }
}
