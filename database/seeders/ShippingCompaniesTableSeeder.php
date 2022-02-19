<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Seeder;

class ShippingCompaniesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('shipping_companies')->insert([
            [
                'name' => 'Fedex',
                'active' => true,
            ],
            [
                'name' => 'DHL',
                'active' => true,
            ],
        ]);
    }
}
