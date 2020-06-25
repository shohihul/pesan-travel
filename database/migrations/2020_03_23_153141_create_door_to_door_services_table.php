<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDoorToDoorServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('door_to_door_services', function (Blueprint $table) {
            $table->id();
            $table->integer('car_id');
            $table->integer('origin_id');
            $table->integer('destination_id');
            $table->integer('price');
            $table->dateTime('start');
            $table->dateTime('finish')->nullable();
            $table->string('route_status')->default('not available');
            $table->string('status')->default('scheduled');
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
        Schema::dropIfExists('door_to_door_services');
    }
}