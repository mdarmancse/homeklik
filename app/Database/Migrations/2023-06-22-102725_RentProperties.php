<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class RentProperties extends Migration
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
            'property_type' => [
                'type' => 'VARCHAR',
                'constraint' => '30',
                'null' => true
                            ],
            'unit' => [
                'type' => 'VARCHAR',
                'constraint' => '30',
                'null' => true
                            ],
            'bedrooms' => [
                'type' => 'INT',
                'constraint' => '30',
                'null' => true
                            ],
            'washrooms' => [
                'type' => 'INT',
                'constraint' => '30',
                'null' => true
                            ],
            'parkings' => [
                'type' => 'INT',
                'constraint' => '30',
                'null' => true
                            ],
            'size' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => true
                            ],
            'street_address' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => true
                            ],
            'city' => [
                'type' => 'VARCHAR',
                'constraint' => '40',
                'null' => true
                            ],
            'province' => [
                'type' => 'VARCHAR',
                'constraint' => '40',
                'null' => true
                            ],
            'postal_code' => [
                'type' => 'VARCHAR',
                'constraint' => '40',
                'null' => true
                            ],                               
            'price' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
                'null' => FALSE,
                'default' => 0.00
                            ],
            'purchase_year' => [
                'type' => 'VARCHAR',
                'constraint' => '11',
                'null' => true
            ],
            'photo' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
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
            $this->forge->createTable('rent_properties');
        }
            
        public function down()
        {
            $this->forge->dropTable('rent_properties');
        }
}
