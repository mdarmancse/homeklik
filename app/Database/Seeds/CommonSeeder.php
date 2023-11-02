<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class CommonSeeder extends Seeder
{
   
        public function run()
    {
        $this->call('UserSeeder');
        $this->call('CustomerClassificatios');
        $this->call('SystemOptionSeeder');
        $this->call('RealtorEarningSeeder');
        $this->call('BrokerageSeeder');
        $this->call('RealtorSeeder');
    }
    
}
