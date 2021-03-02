<?php

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
        $this->call(RolesTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(AreaTableSeeder::class);
        $this->call(DoorToDoorServicesTableSeeder::class);
        $this->call(DoorToDoorOrdersTableSeeder::class);
        $this->call(CarsTableSeeder::class);
        $this->call(InvoiceTableSeeder::class);
    }
}