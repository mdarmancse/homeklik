<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class RealtorEarnings extends Migration
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
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => true
                            ],
            'tour_id' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => true
                            ],
            'month' => [
                'type' => 'TEXT',
                'constraint' => '50',
                'null' => false
                            ],
            'year' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => true
                            ],
            'earning' => [
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
        $this->forge->createTable('realtor_earnings');
    }

    public function down()
    {
        $this->forge->dropTable('realtor_earnings');
    }
}
