<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class PreConstructionPropertyModel extends Migration
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
            'address' => [
                'type' => 'LONGTEXT',
                'null' => true
                            ],
            'photo' => [
                'type' => 'LONGTEXT',
                'null' => true
                        ],
            'price' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
                'null' => FALSE,
                'default' => 0.00
                            ],
            'bathrooms' => [
                'type' => 'INT',
                'constraint' => '30',
                'null' => true
                            ],
            'bedrooms' => [
                'type' => 'INT',
                'constraint' => '30',
                'null' => true
                            ],
            'parking' => [
                'type' => 'INT',
                'constraint' => '30',
                'null' => true
                            ],
            'size_total' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
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
                    $this->forge->createTable('preconstructionproperties');
                }
            
        public function down()
        {
            $this->forge->dropTable('preconstructionproperties');
        }
            }
