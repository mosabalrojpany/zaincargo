<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UserRolesTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(ReceivingPlacesTableSeeder::class);
        $this->call(CustomersTableSeeder::class);
        $this->call(ItemTypesTableSeeder::class);
        $this->call(CountriesTableSeeder::class);
        $this->call(CitiesTableSeeder::class);
        $this->call(AddressesTableSeeder::class);
        $this->call(ShippingCompaniesTableSeeder::class);
        $this->call(CurrencyTypesTableSeeder::class);
        $this->call(BranchesTableSeeder::class);
        $this->call(BranchesBankTableSeeder::class);
        $this->call(SettingsTableSeeder::class);
    }
}
