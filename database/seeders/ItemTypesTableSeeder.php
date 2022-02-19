<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Seeder;

class ItemTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('item_types')->insert([
            [
                'name' => 'إلكترونات',
                'active' => true,
            ],
            [
                'name' => 'مواد غدائية',
                'active' => true,
            ],
            [
                'name' => 'أدوية',
                'active' => false,
            ],
            [
                'name' => 'أدوات قرطاسية',
                'active' => true,
            ],
            [
                'name' => 'أخرى',
                'active' => true,
            ],
        ]);
    }
}
