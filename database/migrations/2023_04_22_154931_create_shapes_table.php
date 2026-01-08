<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('shapes', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('agency_id');
            $table->string('gtfs_shape_id');
            $table->geometry('shape', subtype: 'linestring');
            $table->float('total_distance')->unsigned()->nullable();
            $table->unique(['agency_id', 'gtfs_shape_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shapes');
    }
};
