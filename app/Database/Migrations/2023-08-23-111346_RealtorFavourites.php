<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class RealtorFavourites extends Migration
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
            'favourite' => [
                'type' => 'TINYINT',
                'constraint' => '1',
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
        $this->forge->createTable('realtor_favourites');
    }

    public function down()
    {
        $this->forge->dropTable('realtor_favourites');
    }
}
