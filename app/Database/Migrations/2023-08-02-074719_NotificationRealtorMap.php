<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class NotificationRealtorMap extends Migration
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
                'null' => false
                            ],
            'notification_id' => [
                'type' => 'BIGINT',
                'constraint' => 255,
                'null' => false
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
        $this->forge->createTable('notification_realtor_map');
    }

    public function down()
    {
        $this->forge->dropTable('notification_realtor_map');
    }
}
