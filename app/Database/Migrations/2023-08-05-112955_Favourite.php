<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Favourite extends Migration
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
            'react' => [
                'type' => 'TINYINT',
                'constraint' => '1',
                'default' => 0,
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
        $this->forge->createTable('favourites');
    }

    public function down()
    {
        $this->forge->dropTable('favourites');
    }
}
