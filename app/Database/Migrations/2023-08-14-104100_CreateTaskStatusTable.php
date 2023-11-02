<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTaskStatusTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            'slug' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            'status' => [
                'type' => 'TINYINT',
                'constraint' => '1',
                'null' => true
            ],
            'created_by' => [
                'type' => 'INT',
                'null' => true,
            ],
            'updated_by' => [
                'type' => 'INT',
                'null' => true,
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
        $this->forge->createTable('task_status');
    }

    public function down()
    {
        $this->forge->dropTable('task_status');
    }
}
