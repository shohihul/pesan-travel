<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

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
            'name' => 'admin',
            'email' => 'admin@admin.com',
            'password' => bcrypt('secret'),
            'role_id' => '1',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        DB::table('users')->insert([
            'name' => 'Muhammad Ali',
            'email' => 'ali@driver.com',
            'password' => bcrypt('secret'),
            'role_id' => '2',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        DB::table('users')->insert([
            'name' => 'Putri Aisyah',
            'email' => 'putri@customer.com',
            'password' => bcrypt('secret'),
            'role_id' => '3',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        DB::table('users')->insert([
            'name' => 'Ramadhan',
            'email' => 'ramadhan@customer.com',
            'password' => bcrypt('secret'),
            'role_id' => '3',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        DB::table('users')->insert([
            'name' => 'Susilo',
            'email' => 'susilo@customer.com',
            'password' => bcrypt('secret'),
            'role_id' => '3',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
    }
}
