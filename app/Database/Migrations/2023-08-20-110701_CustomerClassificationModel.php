<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CustomerClassificationModel extends Migration
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
                'type' => 'VARCHAR',
                'constraint' => '40',
                'null' => false
            ],
            'default_status_id' => [
                'type' => 'INT',
                'constraint' => '40',
                'null' => false
            ],
            'default_number' => [
                'type' => 'INT',
                'constraint' => '40',
                'null' => false
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
        $this->forge->createTable('customer_classifications');
    }

    public function down()
    {
        $this->forge->dropTable('customer_classifications');
    }



}
