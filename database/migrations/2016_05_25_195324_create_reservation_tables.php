<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReservationTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('camp_sites', function (Blueprint $table) {
            $table->timestamps();
            $table->increments('id');
            $table->integer('site_id')->unique();
            $table->string('type');
            $table->float('adult_price');
            $table->float('child_price');
        });

        Schema::create('cabin_sites', function (Blueprint $table) {
            $table->timestamps();
            $table->increments('id');
            $table->integer('site_id')->unique();
            $table->float('price');
            $table->float('additional_adult_price');
            $table->float('additional_child_price');
            $table->integer('max_capacity')->default(6);
        });

        Schema::create('reservations', function (Blueprint $table) {
            $table->timestamps();
            $table->increments('id');
            $table->dateTime('starts_at');
            $table->dateTime('ends_at');
            $table->integer('site_id');
            $table->integer('reservationable_id');
            $table->string('reservationable_type');
            $table->integer('adult_count');
            $table->integer('children_count');
            $table->float('price');
        });

        Schema::create('holidays', function (Blueprint $table) {
            $table->timestamps();
            $table->increments('id');
            $table->dateTime('starts_at');
            $table->dateTime('ends_at');
            $table->string('title');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('camp_sites');
        Schema::drop('cabin_sites');
        Schema::drop('reservations');
        Schema::drop('holidays');
    }
}
