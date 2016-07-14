<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterReservationAddAdminComments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('reservations', function (Blueprint $table) {
            $table->boolean('is_approved');
            $table->boolean('is_active')->default(1);
            $table->text('admin_comment')->nullable();
            $table->dateTime('date_approved')->nullable();
            $table->boolean('is_checked_in');
            $table->dateTime('check_in_date_time')->nullable();
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
            $table->dropColumn('is_approved');
            $table->dropColumn('is_active');
            $table->dropColumn('admin_comment');
            $table->dropColumn('date_approved');
            $table->dropColumn('is_checked_in');
            $table->dropColumn('check_in_date_time');
        });
    }
}
