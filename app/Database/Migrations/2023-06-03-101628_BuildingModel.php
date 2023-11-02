<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class BuildingModel extends Migration
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
            'bathroom_total' => [
                'type' => 'VARCHAR',
                'constraint' => '70',
                'null' => true
                ],
            'bedrooms_total' => [
                'type' => 'VARCHAR',
                'constraint' => '70',
                'null' => true
                ],
            'bedrooms_above_ground' => [
                'type' => 'VARCHAR',
                'constraint' => '70',
                'null' => true
                            ],
            'bedrooms_below_ground' => [
                'type' => 'VARCHAR',
                'constraint' => '70',
                'null' => true
                            ],
            'appliances' => [
                'type' => 'VARCHAR',
                'constraint' => '70',
                'null' => true
                        ],
            'architectural_style' => [
                'type' => 'VARCHAR',
                'constraint' => '30',
                'null' => true
                            ],
            'basement_development' => [
                'type' => 'VARCHAR',
                'constraint' => '70',
                'null' => true
                        ],
            'basement_type' => [
                'type' => 'VARCHAR',
                'constraint' => '70',
                'null' => true
                            ],
            'constructed_date' => [
                'type' => 'VARCHAR',
                'constraint' => '70',
                'null' => true
                            ],
            'construction_material' => [
                'type' => 'VARCHAR',
                'constraint' => '70',
                'null' => true
                            ],
            'construction_style_attachment' => [
                'type' => 'VARCHAR',
                'constraint' => '20',
                'null' => true
                            ],
            'cooling_type' => [
                'type' => 'VARCHAR',
                'constraint' => '70',
                'null' => true
                            ],
            'exterior_finish' => [
                'type' => 'VARCHAR',
                'constraint' => '70',
                'null' => true
                            ],
            'fireplace_present' => [
                'type' => 'VARCHAR',
                'constraint' => '70',
                'null' => true
                            ],
            'fireplace_total' => [
                'type' => 'VARCHAR',
                'constraint' => '70',
                'null' => true
                            ],
            'flooring_type' => [
                'type' => 'VARCHAR',
                'constraint' => '70',
                'null' => true
                            ],
            'foundation_type' => [
                'type' => 'VARCHAR',
                'constraint' => '70',
                'null' => true
                            ],
            'half_bath_total' => [
                'type' => 'VARCHAR',
                'constraint' => '70',
                'null' => true
                            ],
            'heating_fuel' => [
                'type' => 'VARCHAR',
                'constraint' => '70',
                'null' => true
                            ],
            'heating_type' => [
                'type' => 'VARCHAR',
                'constraint' => '70',
                'null' => true
                            ],
            'rooms' => [
                'type' => 'LONGTEXT',
                'null' => true
                            ],
            'stories_total' => [
                'type' => 'VARCHAR',
                'constraint' => '70',
                'null' => true
                            ],
            'total_finished_area' => [
                'type' => 'VARCHAR',
                'constraint' => '70',
                'null' => true
                        ],
            'type' => [
                'type' => 'VARCHAR',
                'constraint' => '70',
                'null' => true
                        ],
            'size_interior' => [
                'type' => 'VARCHAR',
                'constraint' => '70',
                'null' => true
                        ],
            'size_exterior' => [
                'type' => 'VARCHAR',
                'constraint' => '70',
                'null' => true
                        ],
            'amenities' => [
                'type' => 'VARCHAR',
                'constraint' => '70',
                'null' => true
                        ],
            'fire_protection' => [
                'type' => 'VARCHAR',
                'constraint' => '70',
                'null' => true
                        ],
            'age' => [
                'type' => 'VARCHAR',
                'constraint' => '10',
                'null' => true
                        ],
            'utility_water' => [
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
        $this->forge->createTable('buildings');
    }

    public function down()
    {
        $this->forge->dropTable('buildings');
    }
}
