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
            'price' => '15000',
            'start' => '2020-06-24 12:00:00',
            'status' => 'scheduled',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
    }
}
