<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use \CodeIgniter\I18n\Time;
class BrokerageSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'id'     => 1,
                'name'            => 'Quoraish Ahmed' ,
                'address'          => 'New Market',
                'email'     => 'quoraish@gmail.com',
                'mobile'     => '+1 (437) 366-6143',
                'status'     => '1',
                'created_at'         => Time::now()
                
            ],
            [
                'id'     => 2,
                'name'            => 'Ehsan Ullah ' ,
                'address'          => 'Halishahar',
                'email'     => 'ehsan@gmail.com',
                'mobile'     => '+1 (437) 366-6143',
                'status'     => '1',
                'created_at'         => Time::now()
            ],
            [
                'id'     => 3,
                'name'            => 'Jahedul Islam' ,
                'address'          => 'Fateyabad',
                'email'     => 'jahed@gmail.com',
                'mobile'     => '+1 (437) 366-6143',
                'status'     => '1',
                'created_at'         => Time::now()
            ],
            [
                'id'     => 4,
                'name'            => 'Robin Hossain' ,
                'address'          => 'Fateyabad',
                'email'     => 'robin@gmail.com',
                'mobile'     => '+1 (437) 366-6143',
                'status'     => '1',
                'created_at'         => Time::now()
            ],
            [
                'id'     => 5,
                'name'            => 'Rifat Khan' ,
                'address'          => 'Dubai',
                'email'     => 'rifat@gmail.com',
                'mobile'     => '+1 (437) 366-6143',
                'status'     => '1',
                'created_at'         => Time::now()
            ]
        ];
        $this->db->table('brokerages')->insertBatch($data);
    }
}
