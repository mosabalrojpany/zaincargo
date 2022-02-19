<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'محمد خالد',
            'username' => 'admin',
            'phone' => '0920000000',
            'password' => bcrypt('123123'),
            'role_id' => 1,
            'active' => 1,
        ]);

    }
}
