<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateActivitiesTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'activity_type' => [
                'type'           => 'ENUM',
                'constraint'     => ['check-in', 'check-out', 'maintenance', 'payment', 'room-blocked', 'room-unblocked'],
            ],
            'room_number' => [
                'type'           => 'VARCHAR',
                'constraint'     => '20',
                'null'           => true,
            ],
            'tenant_id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'null'           => true,
            ],
            'description' => [
                'type'           => 'VARCHAR',
                'constraint'     => '255',
            ],
            'user_id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'null'           => true, // For system-generated activities
            ],
            'icon' => [
                'type'           => 'VARCHAR',
                'constraint'     => '50',
                'null'           => true,
            ],
            'color' => [
                'type'           => 'VARCHAR',
                'constraint'     => '20',
                'null'           => true,
            ],
            'timestamp' => [
                'type'           => 'DATETIME',
                'null'           => false,
            ],
            'created_at' => [
                'type'           => 'DATETIME',
                'null'           => true,
            ],
            'updated_at' => [
                'type'           => 'DATETIME',
                'null'           => true,
            ],
        ]);
        
        $this->forge->addKey('id', true);
        $this->forge->createTable('activities');
    }

    public function down()
    {
        $this->forge->dropTable('activities');
    }
}
