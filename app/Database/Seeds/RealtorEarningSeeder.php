<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use \CodeIgniter\I18n\Time;
class RealtorEarningSeeder extends Seeder
{
    public function run()
    {
        $data = [
        
            // app - General App Settings
            [
                'id'     => 1,
                'realtor_id'            => '1' ,
                'tour_id'            => '1' ,
                'month'          => 'January',
                'year'     => '2023',
                'earning'     => '15000',
                'created_at'         => Time::now()
                
            ],
            
            [
                'id'     => 2,
                'realtor_id'            => '1' ,
                'tour_id'            => '1' ,
                'tour_id'            => '1' ,
                'month'          => 'February',
                'year'     => '2023',
                'earning'     => '258000',
                'created_at'         => Time::now()
            ],
            [
                'id'     => 3,
                'realtor_id'            => '1' ,
                'tour_id'            => '1' ,
                'month'          => 'March',
                'year'     => '2023',
                'earning'     => '150000',
                'created_at'         => Time::now()
            ],
            [
                'id'     => 4,
                'realtor_id'            => '1' ,
                'tour_id'            => '1' ,
                'month'          => 'April',
                'year'     => '2023',
                'earning'     => '154700',
                'created_at'         => Time::now()
            ],
            [
                'id'     => 5,
                'realtor_id'            => '1' ,
                'tour_id'            => '1' ,
                'month'          => 'May',
                'year'     => '2023',
                'earning'     => '25800',
                'created_at'         => Time::now()
            ],
            [
                'id'     => 6,
                'realtor_id'            => '1' ,
                'tour_id'            => '1' ,
                'month'          => 'June',
                'year'     => '2023',
                'earning'     => '369852',
                'created_at'         => Time::now()
            ],
            [
                'id'     => 7,
                'realtor_id'            => '1' ,
                'tour_id'            => '1' ,
                'month'          => 'July',
                'year'     => '2023',
                'earning'     => '1500000',
                'created_at'         => Time::now()
            ],
            [
                'id'     => 8,
                'realtor_id'            => '1' ,
                'tour_id'            => '1' ,
                'month'          => 'August',
                'year'     => '2023',
                'earning'     => '785122',
                'created_at'         => Time::now()
            ],
            [
                'id'     => 9,
                'realtor_id'            => '1' ,
                'tour_id'            => '1' ,
                'month'          => 'September',
                'year'     => '2023',
                'earning'     => '369897',
                'created_at'         => Time::now()
            ],
            [
                'id'     => 10,
                'realtor_id'            => '1' ,
                'tour_id'            => '1' ,
                'month'          => 'October',
                'year'     => '2023',
                'earning'     => '20230',
                'created_at'         => Time::now()
            ],
            [
                'id'     => 11,
                'realtor_id'            => '1' ,
                'tour_id'            => '1' ,
                'month'          => 'November',
                'year'     => '2023',
                'earning'     => '220250',
                'created_at'         => Time::now()
            ],
            [
                'id'     => 12,
                'realtor_id'            => '1' ,
                'tour_id'            => '1' ,
                'month'          => 'December',
                'year'     => '2023',
                'earning'     => '50000',
                'created_at'         => Time::now()
            ],
            [
                'id'     => 13,
                'realtor_id'            => '1' ,
                'tour_id'            => '1' ,
                'month'          => 'January',
                'year'     => '2023',
                'earning'     => '25410',
                'created_at'         => Time::now()
            ],
            [
                'id'     => 14,
                'realtor_id'            => '1' ,
                'tour_id'            => '1' ,
                'month'          => 'August',
                'year'     => '2023',
                'earning'     => '25871',
                'created_at'         => Time::now()
            ],
            [
                'id'     => 15,
                'realtor_id'            => '1' ,
                'tour_id'            => '1' ,
                'month'          => 'September',
                'year'     => '+1 (437) 366-6143',
                'earning'     => '450000',
                'created_at'         => Time::now()
            ],
            [
                'id'     => 16,
                'realtor_id'            => '1' ,
                'tour_id'            => '1' ,
                'month'          => 'April',
                'year'     => '2023',
                'earning'     => '487410',
                'created_at'         => Time::now()
            ]

        ];
        $this->db->table('realtor_earnings')->insertBatch($data);
    }
}
