<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterReservationAddContactInfo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('reservations', function (Blueprint $table) {
            $table->string('contact_name');
            $table->string('contact_email');
            $table->string('contact_phone');
            $table->string('best_time')->nullable();
            $table->text('comment')->nullable();
            $table->boolean('is_paid');
            $table->boolean('is_down_payment');
            $table->float('down_payment')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('reservations', function (Blueprint $table) {
            $table->dropColumn('contact_name');
            $table->dropColumn('contact_email');
            $table->dropColumn('contact_phone');
            $table->dropColumn('best_time');
            $table->dropColumn('comment');
            $table->dropColumn('is_paid');
            $table->dropColumn('is_down_payment');
            $table->dropColumn('down_payment');
        });
    }
}
