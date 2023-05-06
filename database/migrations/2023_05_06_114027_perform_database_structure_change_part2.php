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
            $table->dropColumn('route_id');
            $table->dropIndex(['agency_id', 'route_id']);
        });

        Schema::table('services', function (Blueprint $table) {
            $table->dropColumn('service_id');
            $table->dropIndex(['agency_id', 'service_id']);
        });

        Schema::table('trips', function (Blueprint $table) {
            $table->dropColumn(['trip_id', 'trip_headsign', 'trip_short_name', 'route_color', 'route_text_color', 'route_short_name', 'route_long_name', 'service_id', 'shape']);
            $table->dropIndex(['agency_id', 'trip_id']);
        });

        Schema::table('vehicles', function (Blueprint $table) {
            $table->dropIndex(['vehicle', 'agency_id']);
            $table->dropColumn([
                'active',
                'route',
                'start',
                'vehicle',
                'lat',
                'lon',
                'stop_sequence',
                'status',
                'trip_id',
                'icon',
                'relationship',
                'plate',
                'congestion',
                'occupancy',
                'force_ref',
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
