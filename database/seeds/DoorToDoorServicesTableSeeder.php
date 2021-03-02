<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class DoorToDoorServicesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('door_to_door_services')->insert([
            'car_id' => '1',
            'origin_id' => '31',
            'destination_id' => '62',
            'price' => '150000',
            'start' => '2020-12-24 12:00:00',
            'status' => 'open',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        DB::table('door_to_door_services')->insert([
            'car_id' => '1',
            'origin_id' => '42',
            'destination_id' => '51',
            'price' => '200000',
            'start' => '2020-12-12 12:00:00',
            'status' => 'open',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        DB::table('door_to_door_services')->insert([
            'car_id' => '1',
            'origin_id' => '42',
            'destination_id' => '51',
            'price' => '200000',
            'start' => '2020-12-2 12:00:00',
            'status' => 'open',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
    }
}
