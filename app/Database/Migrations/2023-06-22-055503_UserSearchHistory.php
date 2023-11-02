<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UserSearchHistory extends Migration
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
            'user_id' => [
                'type' => 'INT',
                'constraint' => '20',
                'null' => true
                            ],
            'type' => [
                'type' => 'VARCHAR',
                'constraint' => '20',
                'null' => true
                            ],
            'price_from' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
                'default'    => '0.00',
                ],
            'price_to' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
                'default'    => '0.00',
                ],
            'construction_style' => [
                'type' => 'LONGTEXT',
                'null' => true
                            ],
            'city' => [
                'type' => 'VARCHAR',
                'constraint' => '70',
                'null' => true
                            ],
            'province' => [
                'type' => 'VARCHAR',
                'constraint' => '70',
                'null' => true
                            ],
            'latitude' => [
                'type' => 'VARCHAR',
                'constraint' => '70',
                'null' => true
                            ],
            'longitude' => [
                'type' => 'VARCHAR',
                'constraint' => '70',
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
        $this->forge->createTable('user_search_histories');
    }

    public function down()
    {
        $this->forge->dropTable('user_search_histories');
    }
}
