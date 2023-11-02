<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CustomerClassificationMap extends Migration
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
            'classification_id' => [
                'type' => 'INT',
                'constraint' => 255,
                'null' => false
            ],

            'realtor_id' => [
                'type' => 'INT',
                'constraint' => 255,
                'null' => false
            ],
            'visit_status_id' => [
                'type' => 'INT',
                'constraint' => 255,
                'null' => false
            ],
            'number' => [
                'type' => 'INT',
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
        $this->forge->createTable('customer_classification_map');
    }

    public function down()
    {
        $this->forge->dropTable('customer_classification_map');
    }
}
