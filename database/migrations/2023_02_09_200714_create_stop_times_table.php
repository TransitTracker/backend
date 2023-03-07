<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stop_times', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('agency_id');
            $table->string('gtfs_trip_id');
            $table->string('gtfs_stop_id');
            $table->time('departure');
            $table->unsignedInteger('sequence');
            $table->index(['agency_id', 'gtfs_trip_id']);
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
        Schema::dropIfExists('stop_times');
    }
};
