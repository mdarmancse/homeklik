<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CityModel extends Migration
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
                'type' => 'VARCHAR',
                'constraint' => '40',
                'null' => false
                            ],
            'latitude' => [
                'type' => 'VARCHAR',
                'constraint' => '40',
                'null' => false
                            ],
            'longitude' => [
                'type' => 'VARCHAR',
                'constraint' => '40',
                'null' => false
                            ],
            'is_featured' => [
                'type' => 'TINYINT',
                'constraint' => '1',
                'null' => false
                            ],
            'status' => [
                'type' => 'TINYINT',
                'constraint' => '1',
                'default'      =>1,
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
        $this->forge->createTable('cities');
    }

    public function down()
    {
        $this->forge->dropTable('cities');
    }
}
