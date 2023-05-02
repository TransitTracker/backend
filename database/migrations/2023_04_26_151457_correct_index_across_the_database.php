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
        Schema::table('routes', function (Blueprint $table) {
            $table->unique(['agency_id', 'gtfs_route_id']);
            $table->dropIndex(['agency_id', 'gtfs_route_id']);
        });

        Schema::table('services', function (Blueprint $table) {
            $table->unique(['agency_id', 'gtfs_service_id']);
            $table->dropIndex(['agency_id', 'gtfs_service_id']);
        });

        Schema::table('stops', function (Blueprint $table) {
            $table->unique(['agency_id', 'gtfs_stop_id']);
            $table->dropIndex(['agency_id', 'gtfs_stop_id']);
        });

        Schema::table('stop_times', function (Blueprint $table) {
            $table->unique(['agency_id', 'gtfs_trip_id', 'sequence']);
        });

        Schema::table('trips', function (Blueprint $table) {
            $table->unique(['agency_id', 'gtfs_trip_id']);
            $table->dropIndex(['agency_id', 'gtfs_trip_id']);
        });

        Schema::table('vehicles', function (Blueprint $table) {
            $table->unique(['agency_id', 'vehicle_id']);
            $table->dropIndex(['agency_id', 'vehicle_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('routes', function (Blueprint $table) {
            $table->index(['agency_id', 'gtfs_route_id']);
            $table->dropUnique(['agency_id', 'gtfs_route_id']);
        });

        Schema::table('services', function (Blueprint $table) {
            $table->index(['agency_id', 'gtfs_service_id']);
            $table->dropUnique(['agency_id', 'gtfs_service_id']);
        });

        Schema::table('stops', function (Blueprint $table) {
            $table->index(['agency_id', 'gtfs_stop_id']);
            $table->dropUnique(['agency_id', 'gtfs_stop_id']);
        });

        Schema::table('stop_times', function (Blueprint $table) {
            $table->dropUnique(['agency_id', 'gtfs_trip_id', 'sequence']);
        });

        Schema::table('trips', function (Blueprint $table) {
            $table->index(['agency_id', 'gtfs_trip_id']);
            $table->dropUnique(['agency_id', 'gtfs_trip_id']);
        });

        Schema::table('vehicles', function (Blueprint $table) {
            $table->index(['agency_id', 'vehicle_id']);
            $table->dropUnique(['agency_id', 'vehicle_id']);
        });
    }
};
