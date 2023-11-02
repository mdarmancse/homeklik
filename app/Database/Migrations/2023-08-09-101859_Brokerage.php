<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Brokerage extends Migration
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
            'name' => [
                'type' => 'TEXT',
                'constraint' => '50',
                'null' => false
                            ],
            'address' => [
                'type' => 'LONGTEXT',
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
        $this->forge->createTable('brokerages');
    }

    public function down()
    {
        $this->forge->dropTable('brokerages');
    }
}
