<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Seeder;

class BranchesBankTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('branches_bank')->insert([
            [
                'branche_id' => '1',
                'Customer_balance_denar' => 0.00,
                'Customer_balance_dolar' => 0.00,
            ],
            [
                'branche_id' => '2',
                'Customer_balance_denar' => 0.00,
                'Customer_balance_dolar' => 0.00,
            ],
            [
                'branche_id' => '3',
                'Customer_balance_denar' => 0.00,
                'Customer_balance_dolar' => 0.00,
            ],
        ]);
    }
}
