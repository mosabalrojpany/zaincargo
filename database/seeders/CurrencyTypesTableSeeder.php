<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Seeder;

class CurrencyTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('currency_types')->insert([
            [
                'name' => 'دينار ليبي',
                'sign' => 'د.ل',
                'value' => 1,
                'active' => true,
            ]
            , [
                'name' => 'دولار أمريكي',
                'sign' => '$',
                'value' => 2.5,
                'active' => true,
            ],
        ]);
    }
}
