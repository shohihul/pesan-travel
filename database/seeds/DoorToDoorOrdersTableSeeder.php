<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class DoorToDoorOrdersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('door_to_door_orders')->insert([
            'customer_id' => '3',
            'door_to_door_service_id' => '1',
            'pickup_point' => '-7.032309860846338,112.75828160900916',
            'dropoff_point' => '-3.7877750364476417,102.26055809377482',
            'location_point_status' => 'new',
            'quantity' => '2',
            'amount' => '300000',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        DB::table('door_to_door_orders')->insert([
            'customer_id' => '4',
            'door_to_door_service_id' => '1',
            'pickup_point' => '-7.040759401491945,112.72930256644659',
            'dropoff_point' => '-3.813376401627553,102.26901341686613',
            'location_point_status' => 'new',
            'quantity' => '1',
            'amount' => '150000',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        DB::table('door_to_door_orders')->insert([
            'customer_id' => '5',
            'door_to_door_service_id' => '1',
            'pickup_point' => '-7.029044183687205,112.75955200195312',
            'dropoff_point' => '7.028682144719907,112.747642993927',
            'location_point_status' => 'new',
            'quantity' => '1',
            'amount' => '150000',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
    }
}
