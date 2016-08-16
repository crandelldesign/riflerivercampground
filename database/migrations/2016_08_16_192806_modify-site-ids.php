<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifySiteIds extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('camp_sites', function (Blueprint $table) {
            $table->string('site_id', 7)->change();
        });
        Schema::table('cabin_sites', function (Blueprint $table) {
            $table->string('site_id', 7)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('camp_sites', function (Blueprint $table) {
            $table->integer('site_id')->change();
        });
        Schema::table('cabin_sites', function (Blueprint $table) {
            $table->integer('site_id')->change();
        });
    }
}
