<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class SystemOption extends Migration
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
            'option_name' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => false
                            ],
            'option_slug' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => false
                            ],
            'option_value' => [
                'type' => 'LONGTEXT',
                'null' => false
                            ],
            'created_by' => [
                'type' => 'TIMESTAMP',
                'null' => true,
                            ],
            'updated_by' => [
                'type' => 'TIMESTAMP',
                'null' => true,
                            ],
            'created_at' => [
                'type' => 'TIMESTAMP',
                'null' => true
                            ],
            'updated_at' => [
                'type' => 'TIMESTAMP',
                'null' => true,
                            ],
            'deleted_at' => [
                'type' => 'TIMESTAMP',
                'null' => true
                            ],
                        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('system_option');
    }

    public function down()
    {
        $this->forge->dropTable('system_option');
    }
}
