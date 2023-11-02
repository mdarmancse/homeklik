<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;

class CustomerClassificatios extends Seeder
{
    public function run()
    {
        $data = [

            // app - General App Settings
            [
                'id'     => 1,
                'name'            => 'Hot' ,
                'default_status_id'            => 1 ,
                'default_number'            => 5 ,
                'status'     => '1',
                'created_at'         => Time::now(),
                'updated_at'         => Time::now(),

            ],
            [
                'id'     => 2,
                'name'            => 'Warm' ,
                'default_status_id'            => 1 ,
                'default_number'            => 3 ,
                'status'     => '1',
                'created_at'         => Time::now(),
                'updated_at'         => Time::now(),

            ],
            [
                'id'     => 3,
                'name'            => 'Cold' ,
                'default_status_id'            => 1 ,
                'default_number'            => 5 ,
                'status'     => '1',
                'created_at'         => Time::now(),
                'updated_at'         => Time::now(),

            ],
            [
                'id'     => 4,
                'name'            => 'Potentials' ,
                'default_status_id'            => 1 ,
                'default_number'            => 3 ,
                'status'     => '1',
                'created_at'         => Time::now(),
                'updated_at'         => Time::now(),

            ],

        ];
        $this->db->table('customer_classifications')->insertBatch($data);
    }
}
