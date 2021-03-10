<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIndexesToRoutesAndServicesTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('routes', function (Blueprint $table) {
            $table->index(['agency_id', 'route_id']);
        });
        Schema::table('services', function (Blueprint $table) {
            $table->index(['agency_id', 'service_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('routes', function (Blueprint $table) {
            $table->dropIndex(['agency_id', 'route_id']);
        });
        Schema::table('services', function (Blueprint $table) {
            $table->dropIndex(['agency_id', 'service_id']);
        });
    }
}
