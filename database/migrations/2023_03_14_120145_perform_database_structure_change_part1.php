<?php

use App\Enums\VehicleType;
use App\Models\Gtfs\Route;
use App\Models\Gtfs\Service;
use App\Models\Gtfs\Trip;
use App\Models\Vehicle;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use MatanYadaev\EloquentSpatial\Objects\Point;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Routes
        Schema::table('routes', function (Blueprint $table) {
            $table->string('gtfs_route_id')->after('agency_id');
            $table->unsignedTinyInteger('type')->after('gtfs_route_id');
            $table->index(['agency_id', 'gtfs_route_id']);
        });

        Route::select(['id'])->update([
            'gtfs_route_id' => DB::raw('route_id'),
            // type is new
        ]);

        // Services
        Schema::table('services', function (Blueprint $table) {
            $table->string('gtfs_service_id')->after('id');
            $table->boolean('sunday')->after('gtfs_service_id');
            $table->boolean('saturday')->after('gtfs_service_id');
            $table->boolean('friday')->after('gtfs_service_id');
            $table->boolean('thursday')->after('gtfs_service_id');
            $table->boolean('wednesday')->after('gtfs_service_id');
            $table->boolean('tuesday')->after('gtfs_service_id');
            $table->boolean('monday')->after('gtfs_service_id');
            $table->index(['agency_id', 'gtfs_service_id']);
        });

        Service::select(['id'])->update([
            'gtfs_service_id' => DB::raw('service_id'),
            // day fields are new
        ]);

        // Trips
        Schema::table('trips', function (Blueprint $table) {
            $table->string('gtfs_trip_id')->after('agency_id');
            $table->string('gtfs_service_id')->after('trip_id');
            $table->string('gtfs_route_id')->after('trip_id');
            $table->string('gtfs_shape_id')->after('gtfs_block_id')->nullable();
            $table->string('short_name')->after('trip_headsign')->nullable();
            $table->string('headsign')->after('trip_headsign')->nullable();
            $table->index(['agency_id', 'gtfs_trip_id']);
            $table->index(['agency_id', 'gtfs_block_id', 'gtfs_service_id']);
        });

        Trip::select(['id'])->update([
            'gtfs_trip_id' => DB::raw('trip_id'),
            'gtfs_shape_id' => DB::raw('shape'),
            'headsign' => DB::raw('trip_headsign'),
            'short_name' => DB::raw('trip_short_name'),
            // gtfs_service_id and gtfs_route_id to be added with a GTFS static refresh
        ]);

        // Vehicles
        Schema::table('vehicles', function (Blueprint $table) {
            // Since multiple fields are kept, the order will not be respected
            $table->boolean('is_active');
            $table->string('vehicle_id');
            $table->string('gtfs_trip_id')->nullable();
            $table->string('gtfs_route_id')->nullable();
            $table->time('start_time')->nullable();
            $table->unsignedInteger('schedule_relationship')->nullable();
            $table->string('license_plate')->nullable();
            $table->geometry('position', subtype: 'point');
            $table->double('odometer')->unsigned()->change();
            $table->unsignedInteger('current_stop_sequence')->nullable();
            $table->string('gtfs_stop_id')->nullable();
            $table->unsignedTinyInteger('current_status')->nullable();
            $table->unsignedBigInteger('timestamp')->change();
            $table->unsignedTinyInteger('congestion_level')->nullable();
            $table->unsignedTinyInteger('occupancy_status')->nullable();
            $table->unsignedTinyInteger('vehicle_type')->nullable();
            $table->string('force_vehicle_id')->nullable();
            $table->index(['agency_id', 'vehicle_id']);
        });

        Vehicle::select(['id'])->update([
            'is_active' => DB::raw('active'),
            'vehicle_id' => DB::raw('vehicle'),
            'gtfs_trip_id' => DB::raw('gtfs_trip'),
            'gtfs_route_id' => DB::raw('route'),
            'start_time' => DB::raw('start'),
            'schedule_relationship' => DB::raw('relationship'),
            'license_plate' => DB::raw('plate'),
            // position is below
            // odometer is only a type change
            'current_stop_sequence' => DB::raw('stop_sequence'),
            // gtfs_stop_id is new
            'current_status' => DB::raw('status'),
            // timestamp is only a type change
            'congestion_level' => DB::raw('congestion'),
            'occupancy_status' => DB::raw('occupancy'),
            // vehicle_type is below
            'force_vehicle_id' => DB::raw('force_ref'),
        ]);

        Vehicle::select(['id', 'lat', 'lon', 'icon'])->each(function (Vehicle $vehicle) {
            $vehicle->vehicle_type = VehicleType::coerce(Str::ucfirst($vehicle->icon))?->value;

            if ($vehicle->lat && $vehicle->lon) {
                $vehicle->position = new Point($vehicle->lat, $vehicle->lon);
            }

            $vehicle->save();
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
            $table->dropColumn([
                'type',
                'gtfs_route_id',
            ]);
            $table->dropIndex(['agency_id', 'gtfs_route_id']);
        });

        Schema::table('services', function (Blueprint $table) {
            $table->dropColumn([
                'sunday',
                'saturday',
                'friday',
                'thursday',
                'wednesday',
                'tuesday',
                'monday',
                'gtfs_service_id',
            ]);
            $table->dropIndex(['agency_id', 'gtfs_service_id']);
        });

        Schema::table('trips', function (Blueprint $table) {
            $table->dropColumn([
                'gtfs_trip_id',
                'gtfs_service_id',
                'gtfs_route_id',
                'gtfs_shape_id',
                'short_name',
                'headsign',
            ]);
            $table->dropIndex(['agency_id', 'gtfs_trip_id']);
            $table->dropIndex(['agency_id', 'gtfs_block_id', 'gtfs_service_id']);
        });

        Schema::table('vehicles', function (Blueprint $table) {
            $table->dropColumn([
                'is_active',
                'vehicle_id',
                'gtfs_trip_id',
                'gtfs_route_id',
                'start_time',
                'schedule_relationship',
                'license_plate',
                'position',
                'current_stop_sequence',
                'gtfs_stop_id',
                'current_status',
                'congestion_level',
                'occupancy_status',
                'vehicle_type',
                'force_vehicle_id',
            ]);
            $table->dropIndex(['agency_id', 'vehicle_id']);
        });
    }
};
