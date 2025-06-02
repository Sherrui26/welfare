<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateRoomTables extends Migration
{
    public function up()
    {
        // Rooms table (if it doesn't exist already)
        if (!$this->db->simpleQuery("SHOW TABLES LIKE 'rooms'")) {
            $this->forge->addField([
                'id' => [
                    'type'           => 'INT',
                    'constraint'     => 11,
                    'unsigned'       => true,
                    'auto_increment' => true,
                ],
                'room_number' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 20,
                ],
                'floor' => [
                    'type'       => 'INT',
                    'constraint' => 2,
                ],
                'room_type' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 50,
                    'null'       => true,
                ],
                'capacity' => [
                    'type'       => 'INT',
                    'constraint' => 2,
                    'default'    => 1,
                ],
                'status' => [
                    'type'       => 'ENUM',
                    'constraint' => ['available', 'occupied', 'maintenance', 'blocked'],
                    'default'    => 'available',
                ],
                'block_reason' => [
                    'type'       => 'TEXT',
                    'null'       => true,
                ],
                'maintenance_note' => [
                    'type'       => 'TEXT',
                    'null'       => true,
                ],
                'last_maintenance_date' => [
                    'type'       => 'DATETIME',
                    'null'       => true,
                ],
                'next_maintenance_date' => [
                    'type'       => 'DATETIME',
                    'null'       => true,
                ],
                'created_at' => [
                    'type'       => 'DATETIME',
                    'null'       => true,
                ],
                'updated_at' => [
                    'type'       => 'DATETIME',
                    'null'       => true,
                ],
                'deleted_at' => [
                    'type'       => 'DATETIME',
                    'null'       => true,
                ],
            ]);
            $this->forge->addKey('id', true);
            $this->forge->addUniqueKey('room_number');
            $this->forge->createTable('rooms');
        }

        // Room types table
        if (!$this->db->simpleQuery("SHOW TABLES LIKE 'room_types'")) {
            $this->forge->addField([
                'id' => [
                    'type'           => 'INT',
                    'constraint'     => 11,
                    'unsigned'       => true,
                    'auto_increment' => true,
                ],
                'name' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 50,
                ],
                'description' => [
                    'type'       => 'TEXT',
                    'null'       => true,
                ],
                'created_at' => [
                    'type'       => 'DATETIME',
                    'null'       => true,
                ],
                'updated_at' => [
                    'type'       => 'DATETIME',
                    'null'       => true,
                ],
            ]);
            $this->forge->addKey('id', true);
            $this->forge->createTable('room_types');
        }

        // Room amenities table
        if (!$this->db->simpleQuery("SHOW TABLES LIKE 'room_amenities'")) {
            $this->forge->addField([
                'id' => [
                    'type'           => 'INT',
                    'constraint'     => 11,
                    'unsigned'       => true,
                    'auto_increment' => true,
                ],
                'name' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 50,
                ],
                'icon' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 50,
                    'null'       => true,
                ],
                'created_at' => [
                    'type'       => 'DATETIME',
                    'null'       => true,
                ],
                'updated_at' => [
                    'type'       => 'DATETIME',
                    'null'       => true,
                ],
            ]);
            $this->forge->addKey('id', true);
            $this->forge->createTable('room_amenities');
        }

        // Room-amenity pivot table
        if (!$this->db->simpleQuery("SHOW TABLES LIKE 'room_has_amenities'")) {
            $this->forge->addField([
                'room_id' => [
                    'type'       => 'INT',
                    'constraint' => 11,
                    'unsigned'   => true,
                ],
                'amenity_id' => [
                    'type'       => 'INT',
                    'constraint' => 11,
                    'unsigned'   => true,
                ],
            ]);
            $this->forge->addKey(['room_id', 'amenity_id'], true);
            $this->forge->addForeignKey('room_id', 'rooms', 'id', 'CASCADE', 'CASCADE');
            $this->forge->addForeignKey('amenity_id', 'room_amenities', 'id', 'CASCADE', 'CASCADE');
            $this->forge->createTable('room_has_amenities');
        }

        // Room occupants (tenants)
        if (!$this->db->simpleQuery("SHOW TABLES LIKE 'room_occupants'")) {
            $this->forge->addField([
                'id' => [
                    'type'           => 'INT',
                    'constraint'     => 11,
                    'unsigned'       => true,
                    'auto_increment' => true,
                ],
                'room_id' => [
                    'type'       => 'INT',
                    'constraint' => 11,
                    'unsigned'   => true,
                ],
                'occupant_name' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 100,
                ],
                'occupant_id' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 50,
                    'null'       => true,
                ],
                'occupant_type' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 50,
                    'null'       => true,
                ],
                'check_in_date' => [
                    'type'       => 'DATE',
                    'null'       => true,
                ],
                'check_out_date' => [
                    'type'       => 'DATE',
                    'null'       => true,
                ],
                'status' => [
                    'type'       => 'ENUM',
                    'constraint' => ['active', 'inactive'],
                    'default'    => 'active',
                ],
                'created_at' => [
                    'type'       => 'DATETIME',
                    'null'       => true,
                ],
                'updated_at' => [
                    'type'       => 'DATETIME',
                    'null'       => true,
                ],
            ]);
            $this->forge->addKey('id', true);
            $this->forge->addForeignKey('room_id', 'rooms', 'id', 'CASCADE', 'CASCADE');
            $this->forge->createTable('room_occupants');
        }

        // Room maintenance logs
        if (!$this->db->simpleQuery("SHOW TABLES LIKE 'room_maintenance_logs'")) {
            $this->forge->addField([
                'id' => [
                    'type'           => 'INT',
                    'constraint'     => 11,
                    'unsigned'       => true,
                    'auto_increment' => true,
                ],
                'room_id' => [
                    'type'       => 'INT',
                    'constraint' => 11,
                    'unsigned'   => true,
                ],
                'maintenance_date' => [
                    'type'       => 'DATE',
                ],
                'maintenance_type' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 50,
                ],
                'maintenance_notes' => [
                    'type'       => 'TEXT',
                    'null'       => true,
                ],
                'performed_by' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 100,
                    'null'       => true,
                ],
                'created_at' => [
                    'type'       => 'DATETIME',
                    'null'       => true,
                ],
                'updated_at' => [
                    'type'       => 'DATETIME',
                    'null'       => true,
                ],
            ]);
            $this->forge->addKey('id', true);
            $this->forge->addForeignKey('room_id', 'rooms', 'id', 'CASCADE', 'CASCADE');
            $this->forge->createTable('room_maintenance_logs');
        }
    }

    public function down()
    {
        // Drop tables in reverse order to avoid foreign key constraints
        $this->forge->dropTable('room_maintenance_logs', true);
        $this->forge->dropTable('room_occupants', true);
        $this->forge->dropTable('room_has_amenities', true);
        $this->forge->dropTable('room_amenities', true);
        $this->forge->dropTable('room_types', true);
        $this->forge->dropTable('rooms', true);
    }
}
