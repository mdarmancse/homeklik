<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UsersTable extends Migration
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
            'first_name' => [
                'type' => 'VARCHAR',
                'constraint' => '20',
                'null' => true
                            ],
            'last_name' => [
                'type' => 'VARCHAR',
                'constraint' => '20',
                'null' => true
                            ],
            'mobile' => [
                'type' => 'VARCHAR',
                'constraint' => '20',
                ],
            'email' => [
                'type' => 'VARCHAR',
                'constraint' => '30',
                'null' => true
                            ],
            'password' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                            ],
            'gender' => [
                'type' => 'VARCHAR',
                'constraint' => '11',
                'null' => true
                        ],
            'dob' => [
                'type' => 'DATE',
                'null' => true
                            ],
            'street_address' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => true
                            ],
            'unit' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => true
                            ],
            'postal_code' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => true
                            ],
            'city' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => true
                            ],
            'province' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => true
                            ],
            'image' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => true
                            ],
            'user_type' => [
                'type' => 'VARCHAR',
                'constraint' => '20',
                'null' => true
                            ],
            'language_slug' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => true
                            ],
            'device_id' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => true
                            ],
            'sms_otp' => [
                'type' => 'VARCHAR',
                'constraint' => '20',
                'null' => true
                            ],
            'active' => [
                'type' => 'TINYINT',
                'constraint' => '1',
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
        $this->forge->createTable('users');
    }

    public function down()
    {
        $this->forge->dropTable('users');
    }
}
