<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Seeder;

class BranchesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('branches')->insert([
            [
                'phone' => '+218-91-4858527',
                'phone2' => null,
                'email' => 'electrolibya@gmail.com',
                'address' => 'طرابلس الغيران مقابل شيل بن غرسه / مجمع بوابة التقنية - الدور الثاني',
                'city' => 'طرابلس',
                'latitude' => 32.842603,
                'longitude' => 13.069277,
                'active' => true,
            ],
            [
                'phone' => '0911996311',
                'phone2' => null,
                'email' => 'electrolibya@gmail.com',
                'city' => 'مصراته',
                'address' => 'مدخل مصراتة القديم متفرع من الطريق الساحلي',
                'latitude' => 32.325484,
                'longitude' => 15.099333,
                'active' => true,
            ],
            [
                'phone' => '0914858527',
                'phone2' => null,
                'email' => 'electrolibya@gmail.com',
                'city' => 'بنغازي',
                'address' => 'الرحبة امتداد شارع البيبسي -قرب مدرسة الفويهات الثانوية بنين',
                'latitude' => 32.118840,
                'longitude' => 20.086566,
                'active' => true,
            ],
        ]);
    }
}
