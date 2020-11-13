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
            $table->string('pickup_point');
            $table->string('dropoff_point');
            $table->string('location_point_status')->default('new');
            $table->string('location_note')->nullable();
            $table->string('admin_note')->nullable();
            $table->integer('quantity');
            $table->string('status')->default('new');
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
