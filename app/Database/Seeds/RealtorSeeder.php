<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use \CodeIgniter\I18n\Time;
class RealtorSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'id'     => 1,
                'brokerage_id'            => '5' ,
                'name'          => 'ANTAR NANDI',
                'username'     => 'ANTAR_NANDI',
                'password'     => '783a19b0ec08cdac8354663112d1f5d2',// HK@#$2023
                'rico'            => 'RC4' ,
                'registration_date'          => '2023-08-23',
                'board_name'     => 'Chittagong',
                'street_number'     => '16',
                'street_address1'            => 'Mehedibag Road' ,
                'street_address2'          => 'Mehedibag Road',
                'unit'     => 'C',
                'city'     => 'Toronto',
                'province'          => 'Ontario',
                'postal_code'     => '4355',
                'email'     => 'antar@gmail.com',
                'mobile'     => '+880-1824506162',
                'device_id'            => 'sdfghjk567u' ,
                'otp'          => '123456',
                'status'     => '1',
                'created_at'         => Time::now()
                
            ],
            [
                'id'     => 2,
                'brokerage_id'            => '4' ,
                'name'          => 'Shoaib Elias',
                'username'     => 'SHOAIB_ELIAS',
                'password'     => '783a19b0ec08cdac8354663112d1f5d2',// HK@#$2023
                'rico'            => 'RC4' ,
                'registration_date'          => '2023-08-23',
                'board_name'     => 'Chittagong',
                'street_number'     => '16',
                'street_address1'            => 'Mehedibag Road' ,
                'street_address2'          => 'Mehedibag Road',
                'unit'     => 'C',
                'city'     => 'Ottaowa',
                'province'          => 'Alberta',
                'postal_code'     => '4355',
                'email'     => 'shoaib@gmail.com',
                'mobile'     => '+880 1864-598947',
                'device_id'            => 'sdfghjk567u' ,
                'otp'          => '123456',
                'status'     => '1',
                'created_at'         => Time::now()
            ],
            [
                'id'     => 3,
                'brokerage_id'            => '3' ,
                'name'          => 'Sarwar Zaman Khan',
                'username'     => 'SARWAR_ZAMAN_KHAN',
                'password'     => '783a19b0ec08cdac8354663112d1f5d2',// HK@#$2023
                'rico'            => 'RC4' ,
                'registration_date'          => '2023-08-23',
                'board_name'     => 'Chittagong',
                'street_number'     => '16',
                'street_address1'            => 'Mehedibag Road' ,
                'street_address2'          => 'Mehedibag Road',
                'unit'     => 'C',
                'city'     => 'Calgary',
                'province'          => 'Manitova',
                'postal_code'     => '4355',
                'email'     => 'sarwar@gmail.com',
                'mobile'     => '+880-1644610434',
                'device_id'            => 'sdfghjk567u' ,
                'otp'          => '123456',
                'status'     => '1',
                'created_at'         => Time::now()
            ],
            [
                'id'     => 4,
                'brokerage_id'            => '2' ,
                'name'          => 'Abir Das',
                'username'     => 'ABIR_DAS',
                'password'     => '783a19b0ec08cdac8354663112d1f5d2',// HK@#$2023
                'rico'            => 'RC4' ,
                'registration_date'          => '2023-08-23',
                'board_name'     => 'Chittagong',
                'street_number'     => '16',
                'street_address1'            => 'Mehedibag Road' ,
                'street_address2'          => 'Mehedibag Road',
                'unit'     => 'C',
                'city'     => 'Toronto',
                'province'          => 'Ontario',
                'postal_code'     => '4355',
                'email'     => 'abir@gmail.com',
                'mobile'     => '+880 1819-951151',
                'device_id'            => 'sdfghjk567u' ,
                'otp'          => '123456',
                'status'     => '1',
                'created_at'         => Time::now()
            ],
            [
                'id'     => 5,
                'brokerage_id'            => '1' ,
                'name'          => 'Arman Ullah',
                'username'     => 'ARMAN_ULLAH_KHAN',
                'password'     => '783a19b0ec08cdac8354663112d1f5d2',// HK@#$2023
                'rico'            => 'RC4' ,
                'registration_date'          => '2023-08-23',
                'board_name'     => 'Chittagong',
                'street_number'     => '16',
                'street_address1'            => 'Mehedibag Road' ,
                'street_address2'          => 'Mehedibag Road',
                'unit'     => 'C',
                'city'     => 'Montreal',
                'province'          => 'Nova Scotia',
                'postal_code'     => '4355',
                'email'     => 'arman@gmail.com',
                'mobile'     => '+880 1787-281564',
                'device_id'            => 'sdfghjk567u' ,
                'otp'          => '123456',
                'status'     => '1',
                'created_at'         => Time::now()
            ]
        ];
        $this->db->table('realtors')->insertBatch($data);
    }
}
