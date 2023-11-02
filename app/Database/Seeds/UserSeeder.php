<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use \CodeIgniter\I18n\Time;
class UserSeeder extends Seeder
{
    public function run()
    {
        $data = [
        
            // app - General App Settings
            [
                'id'     => 1,
                'first_name'            => 'Homeklik' ,
                'last_name'          => 'Canada',
                'mobile'     => '+1 (437) 366-6143',
                'email'     => 'homeklik2023@gmail.com',
                'password'     => md5(HASH . "HK@#$2023"),
                'gender'            => 'Male' ,
                'user_type'          => 'SuperAdmin',
                'active'     => '1',
                'status'     => '1',
                'created_at'         => Time::now()
                
            ],
            
            [
                'id'     => 2,
                'first_name'            => 'Antar' ,
                'last_name'          => 'Nandi',
                'mobile'     => '01824506162',
                'email'     => 'antar@gmail.com',
                'password'     => md5(HASH . "123456"),
                'gender'            => 'Male' ,
                'user_type'          => 'SuperAdmin',
                'active'     => '1',
                'status'     => '1',
                'created_at'         => Time::now()
            ]
        ];
        $this->db->table('users')->insertBatch($data);
    }
}
