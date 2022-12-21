<?php

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Seeder;

class CustomersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Customer::create(
            [
            'dateCreated' => '12-12-2022',
            'gateway_id' => 'cus_G7Dvo4iphUNk',
            'cpfCnpj' => '05348908908',
            'name' => 'Fabio Aluno',
            'phone' => '42991622889',
            'mobilePhone' => '42991622889',
            'externalReference' => '2',
            'notificationDisabled' => false,
            ]);
    }
}
