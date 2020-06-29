<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransitTrackerTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Vehicles table
        Schema::create('vehicles', function (Blueprint $table) {
            $table->increments('id');
            $table->boolean('active')->default(true);
            $table->unsignedInteger('agency_id')->nullable();
            $table->string('gtfs_trip')->nullable();
            $table->string('route');
            $table->time('start')->nullable();
            $table->string('vehicle');
            $table->float('lat', 7, 5)->nullable();
            $table->float('lon', 7, 5)->nullable();
            $table->float('bearing')->nullable();
            $table->float('speed')->nullable();
            $table->unsignedInteger('stop_sequence')->nullable();
            $table->string('status')->nullable();
            $table->unsignedInteger('trip_id')->nullable();
            $table->timestamps();
        });

        // Trips table
        Schema::create('trips', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('agency_id')->nullable();
            $table->string('trip_id');
            $table->string('trip_headsign');
            $table->string('trip_short_name')->nullable();
            $table->string('route_color')->nullable();
            $table->string('route_text_color')->nullable();
            $table->string('route_short_name')->nullable();
            $table->string('route_long_name')->nullable();
            $table->date('expiration')->default('20250624');
            $table->timestamps();
        });

        // Routes table
        Schema::create('routes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('agency_id');
            $table->string('route_id');
            $table->string('short_name');
            $table->string('long_name');
            $table->string('color');
            $table->string('text_color');
            $table->timestamps();
        });

        // Agencies table
        Schema::create('agencies', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('color');
            $table->string('vehicles_type');
            $table->string('gtfs_id');
            $table->string('slug')->unique();
            $table->timestamps();
        });

        // Alerts table
        Schema::create('alerts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title_en');
            $table->string('title_fr');
            $table->text('body_en');
            $table->text('body_fr');
            $table->string('colour');
            $table->dateTime('expiration');
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
        Schema::dropIfExists('vehicles');
        Schema::dropIfExists('trips');
        Schema::dropIfExists('routes');
        Schema::dropIfExists('agencies');
        Schema::dropIfExists('alerts');
    }
}
