<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Seeder;

class ReceivingPlacesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('receiving_places')->insert([
            [
                'name' => 'طرابلس',
                'active' => 1,
            ],
            [
                'name' => 'مصراتة',
                'active' => 1,
            ],
            [
                'name' => 'بنغازي',
                'active' => 1,
            ],
            [
                'name' => 'سبها',
                'active' => 0,
            ],
        ]);
    }
}
