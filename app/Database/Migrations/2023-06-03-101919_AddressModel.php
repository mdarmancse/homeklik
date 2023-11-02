<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddressModel extends Migration
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
            'attribute_id' => [
                'type' => 'VARCHAR',
                'constraint' => '20',
                'null' => true
                            ],
            'listing_id' => [
                'type' => 'VARCHAR',
                'constraint' => '20',
                'null' => true
                            ],
            'street_address' => [
                'type' => 'VARCHAR',
                'constraint' => '70',
                'null' => true
                ],
            'address_line' => [
                'type' => 'VARCHAR',
                'constraint' => '70',
                'null' => true
                ],
            'street_number' => [
                'type' => 'VARCHAR',
                'constraint' => '70',
                'null' => true
                            ],
            'street_name' => [
                'type' => 'VARCHAR',
                'constraint' => '70',
                'null' => true
                            ],
            'street_suffix' => [
                'type' => 'VARCHAR',
                'constraint' => '70',
                'null' => true
                        ],
            'street_direction_suffix' => [
                'type' => 'VARCHAR',
                'constraint' => '70',
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
            'neighbourhood' => [
                'type' => 'VARCHAR',
                'constraint' => '70',
                'null' => true
                            ],
            'postal_code' => [
                'type' => 'VARCHAR',
                'constraint' => '70',
                'null' => true
                            ],
            'unit_number' => [
                'type' => 'VARCHAR',
                'constraint' => '70',
                'null' => true
                            ],
            'country' => [
                'type' => 'VARCHAR',
                'constraint' => '20',
                'null' => true
                            ],
            'community_name' => [
                'type' => 'VARCHAR',
                'constraint' => '70',
                'null' => true
                            ],
            'sub_division' => [
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
        $this->forge->createTable('addresses');
    }

    public function down()
    {
        $this->forge->dropTable('addresses');
    }
}
