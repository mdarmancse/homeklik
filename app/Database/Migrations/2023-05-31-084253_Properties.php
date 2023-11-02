<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Properties extends Migration
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
            'entity_id' => [
                'type' => 'BIGINT',
                'constraint' => '100',
                'null' => true
                            ],
            'listing_id' => [
                'type' => 'VARCHAR',
                'constraint' => '20',
                'null' => true
                            ],
            'agent_details' => [
                'type' => 'LONGTEXT',
                'null' => true
                ],
            'land' => [
                'type' => 'LONGTEXT',
                'null' => true
                            ],
            'photo' => [
                'type' => 'LONGTEXT',
                'null' => true
                        ],
            'latitude' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => true
                            ],
            'longitude' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => true
                            ],
            'plan' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => true
                            ],
            'price' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
                'null' => FALSE,
                'default' => 0.00
                            ],
            'building_type' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => true
                            ],
            'property_type' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => true
                            ],
            'transaction_type' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => true
                            ],
            'parking' => [
                'type' => 'INT',
                'constraint' => '30',
                'null' => true
                            ],
            'province' => [
                'type' => 'VARCHAR',
                'constraint' => '40',
                'null' => true
                            ],
            'city' => [
                'type' => 'VARCHAR',
                'constraint' => '40',
                'null' => true
                            ],
            'size_total' => [
                'type' => 'VARCHAR',
                'constraint' => '40',
                'null' => true
                            ],
            'size_total_text' => [
                'type' => 'VARCHAR',
                'constraint' => '40',
                'null' => true
                            ],
            'maintenance_fee' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
                'null' => true,
                'default' => 0.00
                            ],
            'public_remarks' => [
                'type' => 'LONGTEXT',
                'null' => true
                            ],
            'features' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => true
                            ],
            'ownership_type' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => true
                            ],
            'tax_annual_amount' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => true
                            ],
            'lot_size_area' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => true
                            ],
            'address_data' => [
                'type' => 'VARCHAR',
                'constraint' => '1000',
                'null' => true
            ],
            'building_data' => [
                'type' => 'VARCHAR',
                'constraint' => '1000',
                'null' => true
            ],
            'listing_contract_date' => [
                'type' => 'DATETIME',
                'null' => true
            ],
            'last_updated' => [
                'type' => 'DATETIME',
                'null' => true
                            ],
            'is_feature' => [
                'type' => 'TINYINT',
                'constraint' => '1',
                'null' => true,
                'default' => 0
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
        $this->forge->createTable('properties');
    }

    public function down()
    {
        $this->forge->dropTable('properties');
    }
}
