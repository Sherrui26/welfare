<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateRoomsTable extends Migration
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
            'room_number' => [
                'type'           => 'VARCHAR',
                'constraint'     => '20',
            ],
            'floor' => [
                'type'           => 'INT',
                'constraint'     => 2,
                'unsigned'       => true,
            ],
            'capacity' => [
                'type'           => 'INT',
                'constraint'     => 2,
                'unsigned'       => true,
                'default'        => 1,
            ],
            'status' => [
                'type'           => 'ENUM',
                'constraint'     => ['available', 'occupied', 'maintenance', 'blocked'],
                'default'        => 'available',
            ],
            'block_reason' => [
                'type'           => 'VARCHAR',
                'constraint'     => '255',
                'null'           => true,
            ],
            'maintenance_note' => [
                'type'           => 'TEXT',
                'null'           => true,
            ],
            'last_maintenance_date' => [
                'type'           => 'DATETIME',
                'null'           => true,
            ],
            'next_maintenance_date' => [
                'type'           => 'DATETIME',
                'null'           => true,
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
        $this->forge->addUniqueKey('room_number');
        $this->forge->createTable('rooms');
    }

    public function down()
    {
        $this->forge->dropTable('rooms');
    }
}
