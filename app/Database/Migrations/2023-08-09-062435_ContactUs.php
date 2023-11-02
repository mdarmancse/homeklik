<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ContactUs extends Migration
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
            'property_type' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => true
                            ],
            'area' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => true
                            ],
            'budget' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => true
                            ],
            'message' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
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
        $this->forge->createTable('contact_us');
    }

    public function down()
    {
        $this->forge->dropTable('contact_us');
    }
}
