<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Brands extends Migration
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
                'constraint' => 50,
                'null' => true
                            ],
            'logo' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true
            ],
            'url' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
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
                    $this->forge->createTable('brands');
                }
            
        public function down()
        {
            $this->forge->dropTable('brands');
        }
}
