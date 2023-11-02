<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Realtors extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'BIGINT',
                'constraint' => 255,
                'unsigned' => true,
                'auto_increment' => true
                    ],
            'brokerage_id' => [
                'type' => 'TEXT',
                'constraint' => '50',
                'null' => true
                            ],
            'name' => [
                'type' => 'TEXT',
                'constraint' => '50',
                'null' => false
                            ],
            'username' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => true
                            ],
            'password' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => true
                            ],
            'rico' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => true
                            ],
            'registration_date' => [
                'type' => 'DATETIME',
                'null' => true
                            ],
            'board_name' => [
                'type' => 'TEXT',
                'constraint' => '100',
                'null' => true
                ],
            'street_number' => [
                'type' => 'LONGTEXT',
                'null' => true
                            ],
            'street_address1' => [
                'type' => 'LONGTEXT',
                'null' => true
                            ],
            'street_address2' => [
                'type' => 'LONGTEXT',
                'null' => true
                            ],
            'unit' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => true
                        ],
            'city' => [
                'type' => 'TEXT',
                'constraint' => '100',
                'null' => true
                            ],
            'province' => [
                'type' => 'TEXT',
                'constraint' => '100',
                'null' => true
                            ],
            'postal_code' => [
                'type' => 'VARCHAR',
                'constraint' => '30',
                'null' => true
                            ],
            'email' => [
                'type' => 'VARCHAR',
                'constraint' => '40',
                'null' => true
                            ],
            'mobile' => [
                'type' => 'VARCHAR',
                'constraint' => '20',
                'null' => true
                            ],
            'device_id' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => true
                            ],
            'otp' => [
                'type' => 'VARCHAR',
                'constraint' => '25',
                'null' => true
                            ],
            'status' => [
                'type' => 'TINYINT',
                'constraint' => '1',
                'null' => true
                            ],
            'created_at' => [
                'type' => 'TIMESTAMP',
                'null' => true
                            ],
            'updated_at' => [
                'type' => 'TIMESTAMP',
                'null' => true
                            ],
            'deleted_at' => [
                'type' => 'TIMESTAMP',
                'null' => true
                            ],
                        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('realtors');
    }

    public function down()
    {
        $this->forge->dropTable('realtors');
    }
}
