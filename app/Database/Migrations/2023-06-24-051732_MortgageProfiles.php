<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class MortgageProfiles extends Migration
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
                'type' => 'INT',
                'constraint' => '20',
                'null' => true
                            ],
            'home_buyer' => [
                'type' => 'VARCHAR',
                'constraint' => '30',
                'null' => true
                            ],
            'family_income' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
                'null' => true,
                'default' => 0.00
                            ],
            'credit_score' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
                'null' => true,
                'default' => 0.00
                            ],
            'heating_cost' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
                'null' => true,
                'default' => 0.00
                            ],
            'monthly_installment' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
                'null' => true,
                'default' => 0.00
                            ],
            'total_balance' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
                'null' => true,
                'default' => 0.00
                            ],
            'qualification_rate' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
                'null' => true,
                'default' => 0.00
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
            $this->forge->createTable('mortgage_profiles');
        }
            
        public function down()
        {
            $this->forge->dropTable('mortgage_profiles');
        }
}
