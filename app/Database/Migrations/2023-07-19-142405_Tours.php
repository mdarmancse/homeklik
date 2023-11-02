<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Tours extends Migration
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
            'user_id' => [
                'type' => 'TEXT',
                'constraint' => '20',
                'null' => false
                            ],
            'listing_id' => [
                'type' => 'TEXT',
                'constraint' => '20',
                'null' => false
                            ],
            'realtor_id' => [
                'type' => 'TEXT',
                'constraint' => '20',
                'null' => true
                            ],
            'brokerage_id' => [
                'type' => 'TEXT',
                'constraint' => '20',
                'null' => true
                            ],
            'visit_id' => [
                'type' => 'TEXT',
                'constraint' => '20',
                'null' => true
                            ],
            'accept' => [
                'type' => 'TINYINT',
                'constraint' => '1',
                'null' => true
                            ],
            'bid_price' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
                'null' => true
            ],

            'bid_closing_date' => [
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
        $this->forge->createTable('tours');
    }

    public function down()
    {
        $this->forge->dropTable('tours');
    }
}
