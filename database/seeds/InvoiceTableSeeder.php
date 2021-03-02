<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class InvoiceTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('invoices')->insert([
            'door_to_door_order_id' => '1',
            'service' => 'Antar Kota',
            'amount' => 300000,
            'due_date' => '2020-12-23 12:00:00',
            'transfer_to' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        DB::table('invoices')->insert([
            'door_to_door_order_id' => '2',
            'service' => 'Antar Kota',
            'amount' => 150000,
            'due_date' => '2020-12-23 12:00:00',
            'transfer_to' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);   
        
        DB::table('invoices')->insert([
            'door_to_door_order_id' => '3',
            'service' => 'Antar Kota',
            'amount' => 150000,
            'due_date' => '2020-12-23 12:00:00',
            'transfer_to' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);  
    }
}
