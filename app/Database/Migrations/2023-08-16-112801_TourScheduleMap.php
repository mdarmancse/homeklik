<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TourScheduleMap extends Migration
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
            'tour_id' => [
                'type' => 'TEXT',
                'constraint' => '20',
                'null' => false
                            ],
            'date' => [
                'type' => 'DATE',
                'null' => true
                            ],
            'shift' => [
                'type' => 'TEXT',
                'constraint' => '30',
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
        $this->forge->createTable('tour_schedule_map');
    }

    public function down()
    {
        $this->forge->dropTable('tour_schedule_map');
    }
}
