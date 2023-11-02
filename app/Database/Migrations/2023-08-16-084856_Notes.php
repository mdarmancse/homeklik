<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Notes extends Migration
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
            'realtor_id' => [
                'type' => 'BIGINT',
                'constraint' => 255,
                'unsigned' => true,
                'null' => false
                            ],
            'title' => [
                'type' => 'TEXT',
                'constraint' => '100',
                'null' => false
                            ],
            'details' => [
                'type' => 'LONGTEXT',
                'null' => true
                            ],
            'date' => [
                'type' => 'DATE',
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
        $this->forge->createTable('notes');
    }

    public function down()
    {
        $this->forge->dropTable('notes');
    }
}
