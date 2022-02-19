<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Seeder;

class SettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('settings')->insert([
            'email' => 'electrolibya@gmail.com',
            'phone' => '+218-91-4858527',
            'phone2' => null,
            'address' => 'طرابلس الغيران مقابل شيل بن غرسه / مجمع بوابة التقنية - الدور الثاني',
            'city' => 'طرابلس',
            'latitude' => 32.842603,
            'longitude' => 13.069277,
            'facebook' => 'https://www.facebook.com/electrolibya',
            'instagram' => null,
            'twitter' => null,
            'youtube' => null,
            'desc' => 'شركة إلكتروليبيا للشحن وخدمات التسوق..نوفر لك منتجاتك الى ليبيا ونتسوق لك من اي مكان',
            'keywords' => 'إلكترو ليبيا , شركة شحن , شحن بحري , شحن جوي , خدمات لوجيستية',
            'active' => true,
            'maintenance_msg' => 'نقوم بإجراء بعض التحسينات والتطويرات من أجلكم , سنعود قريبا',
            'currency_type_id' => 1,
        ]);
    }
}
