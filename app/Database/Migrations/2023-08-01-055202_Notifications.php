<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Notifications extends Migration
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
            'notification_title' => [
                'type' => 'VARCHAR',
                'constraint' => '150',
                'null' => false
                            ],
            'notification_description' => [
                'type' => 'LONGTEXT',
                'null' => false
                            ],
            'image' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => true
                            ],
            'selection_type' => [
                'type' => 'VARCHAR',
                'constraint' => '20',
                'null' => true
                            ],
            'language_slug' => [
                'type' => 'VARCHAR',
                'constraint' => '20',
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
        $this->forge->createTable('notifications');
    }

    public function down()
    {
        $this->forge->dropTable('notifications');
    }
}
