<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDoorToDoorOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('door_to_door_orders', function (Blueprint $table) {
            $table->id();
            $table->integer('customer_id');
            $table->integer('door_to_door_service_id');
            $table->string('pick_up_point');
            $table->string('drop_off_point');
            $table->string('location_point_status')->default('new');
            $table->string('location_point_note')->nullable();
            $table->string('quantity');
            $table->string('payment_status')->default('new');
            $table->string('amount');
            $table->integer('pickup_sequence')->nullable();
            $table->integer('dropoff_sequence')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('door_to_door_orders');
    }
}
