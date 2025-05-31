<?php

namespace App\Models;

use CodeIgniter\Model;

class ActivityModel extends Model
{
    protected $table      = 'activities';
    protected $primaryKey = 'id';
    
    protected $returnType     = 'array';
    protected $useSoftDeletes = false;
    
    protected $allowedFields = [
        'activity_type', 'room_number', 'tenant_id', 'description', 'user_id',
        'icon', 'color', 'timestamp'
    ];
    
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';
    
    // Activity types
    const TYPE_CHECKIN = 'check-in';
    const TYPE_CHECKOUT = 'check-out';
    const TYPE_MAINTENANCE = 'maintenance';
    const TYPE_PAYMENT = 'payment';
    const TYPE_ROOM_BLOCKED = 'room-blocked';
    const TYPE_ROOM_UNBLOCKED = 'room-unblocked';
    
    /**
     * Get recent activities
     */
    public function getRecentActivities($limit = 5)
    {
        // Get recent activities from database
        $activities = $this->orderBy('timestamp', 'DESC')
                          ->limit($limit)
                          ->findAll();
                          
        // Format activity data for the dashboard
        $formattedActivities = [];
        foreach ($activities as $activity) {
            $type = $activity['activity_type'];
            $roomPrefix = $activity['room_number'] ? "Room {$activity['room_number']}" : '';
            
            // Generate title based on activity type
            $title = '';
            switch ($type) {
                case self::TYPE_CHECKIN:
                    $title = "Check-in: {$roomPrefix}";
                    break;
                case self::TYPE_CHECKOUT:
                    $title = "Check-out: {$roomPrefix}";
                    break;
                case self::TYPE_MAINTENANCE:
                    $title = "Maintenance: {$roomPrefix}";
                    break;
                case self::TYPE_PAYMENT:
                    $title = "Payment Received: {$roomPrefix}";
                    break;
                case self::TYPE_ROOM_BLOCKED:
                    $title = "Room Blocked: {$roomPrefix}";
                    break;
                case self::TYPE_ROOM_UNBLOCKED:
                    $title = "Room Unblocked: {$roomPrefix}";
                    break;
                default:
                    $title = ucfirst(str_replace('-', ' ', $type)) . ($roomPrefix ? ": {$roomPrefix}" : '');
            }
            
            // Format time
            $datetime = new \DateTime($activity['timestamp']);
            $time = $datetime->format('g:i A'); // 12-hour format with AM/PM
            
            $formattedActivities[] = [
                'type' => $type,
                'icon' => $activity['icon'],
                'color' => $activity['color'],
                'title' => $title,
                'description' => $activity['description'],
                'time' => $time
            ];
        }
        
        return $formattedActivities;
    }
    
    /**
     * Get last activity timestamp
     */
    public function getLastActivityTime()
    {
        // Get the most recent activity from the database
        $lastActivity = $this->orderBy('timestamp', 'DESC')
                            ->first();
        
        if (!$lastActivity) {
            return 'No recent activity';
        }
        
        // Format the timestamp
        $timestamp = new \DateTime($lastActivity['timestamp']);
        $now = new \DateTime();
        $diff = $now->diff($timestamp);
        
        // If it's today
        if ($diff->days == 0) {
            return 'Today, ' . $timestamp->format('g:i A'); // e.g., Today, 2:37 PM
        } 
        // If it's yesterday
        else if ($diff->days == 1) {
            return 'Yesterday, ' . $timestamp->format('g:i A'); // e.g., Yesterday, 2:37 PM
        } 
        // If it's within the last week
        else if ($diff->days < 7) {
            return $timestamp->format('l, g:i A'); // e.g., Monday, 2:37 PM
        } 
        // Otherwise show the date
        else {
            return $timestamp->format('M j, Y, g:i A'); // e.g., Jun 15, 2025, 2:37 PM
        }
    }
}
