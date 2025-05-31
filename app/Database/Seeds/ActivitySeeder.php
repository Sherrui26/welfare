<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ActivitySeeder extends Seeder
{
    public function run()
    {
        // Demo activities for our dashboard
        $now = new \DateTime();
        
        $activitiesData = [
            [
                'activity_type' => 'check-in',
                'room_number' => '101',
                'tenant_id' => 1,
                'description' => 'John Smith has checked in',
                'user_id' => 1,
                'icon' => 'fa-sign-in-alt',
                'color' => 'green',
                'timestamp' => (clone $now)->modify('-1 hour 30 minutes')->format('Y-m-d H:i:s'),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'activity_type' => 'check-out',
                'room_number' => '102',
                'tenant_id' => 2,
                'description' => 'Jane Cooper has checked out',
                'user_id' => 1,
                'icon' => 'fa-sign-out-alt',
                'color' => 'red',
                'timestamp' => (clone $now)->modify('-2 hours 45 minutes')->format('Y-m-d H:i:s'),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'activity_type' => 'maintenance',
                'room_number' => '103',
                'tenant_id' => null,
                'description' => 'Plumbing issue reported',
                'user_id' => 1,
                'icon' => 'fa-tools',
                'color' => 'yellow',
                'timestamp' => (clone $now)->modify('-3 hours 15 minutes')->format('Y-m-d H:i:s'),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'activity_type' => 'payment',
                'room_number' => '201',
                'tenant_id' => 3,
                'description' => 'Monthly rent payment processed',
                'user_id' => 1,
                'icon' => 'fa-money-bill-wave',
                'color' => 'blue',
                'timestamp' => (clone $now)->modify('-4 hours 40 minutes')->format('Y-m-d H:i:s'),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'activity_type' => 'room-blocked',
                'room_number' => '215',
                'tenant_id' => null,
                'description' => 'Room blocked for electrical repairs',
                'user_id' => 1,
                'icon' => 'fa-ban',
                'color' => 'red',
                'timestamp' => (clone $now)->modify('-5 hours 20 minutes')->format('Y-m-d H:i:s'),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'activity_type' => 'maintenance',
                'room_number' => '202',
                'tenant_id' => null,
                'description' => 'Regular maintenance completed',
                'user_id' => 1,
                'icon' => 'fa-tools',
                'color' => 'yellow',
                'timestamp' => (clone $now)->modify('-3 days')->format('Y-m-d H:i:s'),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]
        ];
        
        // Insert data into the activities table
        $builder = $this->db->table('activities');
        $builder->insertBatch($activitiesData);
    }
}
