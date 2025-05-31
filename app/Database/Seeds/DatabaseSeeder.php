<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Call the individual seeders in order
        $this->call('App\Database\Seeds\RoomSeeder');
        $this->call('App\Database\Seeds\ActivitySeeder');
        
        echo "All seeders executed successfully.\n";
    }
}
