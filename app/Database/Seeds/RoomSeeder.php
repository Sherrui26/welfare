<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class RoomSeeder extends Seeder
{
    public function run()
    {
        // Define room statuses for our demo data
        $statuses = ['available', 'occupied', 'maintenance', 'blocked'];
        
        // Demo block reasons
        $blockReasons = [
            'Plumbing issues',
            'Electrical repairs',
            'Renovation',
            'Structural damage',
            'Pest control'  
        ];
        
        // Get current date for maintenance scheduling
        $now = new \DateTime();
        $lastMaintenance = clone $now;
        $lastMaintenance->modify('-3 days');
        $nextMaintenance = clone $now;
        $nextMaintenance->modify('+5 days');
        
        // Create rooms data
        $roomsData = [];
        
        // Floor 1 rooms (101-110)
        for ($i = 1; $i <= 10; $i++) {
            $roomNum = '10' . $i;
            $status = $statuses[array_rand($statuses)];
            
            $roomsData[] = [
                'room_number' => $roomNum,
                'floor' => 1,
                'capacity' => rand(1, 4),
                'status' => $status,
                'block_reason' => $status === 'blocked' ? $blockReasons[array_rand($blockReasons)] : null,
                'maintenance_note' => $status === 'maintenance' ? 'Regular maintenance check' : null,
                'last_maintenance_date' => $roomNum === '202' ? $lastMaintenance->format('Y-m-d H:i:s') : null,
                'next_maintenance_date' => $roomNum === '105' ? $nextMaintenance->format('Y-m-d H:i:s') : null,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ];
        }
        
        // Floor 2 rooms (201-210)
        for ($i = 1; $i <= 10; $i++) {
            $roomNum = '20' . $i;
            $status = $statuses[array_rand($statuses)];
            
            $roomsData[] = [
                'room_number' => $roomNum,
                'floor' => 2,
                'capacity' => rand(1, 4),
                'status' => $status,
                'block_reason' => $status === 'blocked' ? $blockReasons[array_rand($blockReasons)] : null,
                'maintenance_note' => $status === 'maintenance' ? 'Regular maintenance check' : null,
                'last_maintenance_date' => $roomNum === '202' ? $lastMaintenance->format('Y-m-d H:i:s') : null,
                'next_maintenance_date' => null,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ];
        }
        
        // Floor 3 rooms (301-310)
        for ($i = 1; $i <= 10; $i++) {
            $roomNum = '30' . $i;
            $status = $statuses[array_rand($statuses)];
            
            $roomsData[] = [
                'room_number' => $roomNum,
                'floor' => 3,
                'capacity' => rand(1, 4),
                'status' => $status,
                'block_reason' => $status === 'blocked' ? $blockReasons[array_rand($blockReasons)] : null,
                'maintenance_note' => $status === 'maintenance' ? 'Regular maintenance check' : null,
                'last_maintenance_date' => null,
                'next_maintenance_date' => null,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ];
        }
        
        // Make sure we have some specific rooms for our UI
        // Make sure room 103, 215, and 307 are specifically blocked to match our UI
        foreach ($roomsData as &$room) {
            if ($room['room_number'] === '103') {
                $room['status'] = 'blocked';
                $room['block_reason'] = 'Plumbing issues';
            } else if ($room['room_number'] === '215') {
                $room['status'] = 'blocked';
                $room['block_reason'] = 'Electrical repairs';
            } else if ($room['room_number'] === '307') {
                $room['status'] = 'blocked';
                $room['block_reason'] = 'Renovation';
            }
        }
        
        // Insert data into the rooms table
        $builder = $this->db->table('rooms');
        $builder->insertBatch($roomsData);
    }
}
