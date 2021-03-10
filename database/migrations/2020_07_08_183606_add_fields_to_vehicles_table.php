<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToVehiclesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('vehicles', function (Blueprint $table) {
            // Convert status field to enum
            $table->unsignedSmallInteger('status')->change();

            // Add fields
            $table->tinyInteger('relationship')->unsigned()->nullable();
            $table->string('label')->nullable();
            $table->string('plate')->nullable();
            $table->string('odometer')->nullable();
            $table->string('timestamp')->nullable();
            $table->unsignedTinyInteger('congestion')->nullable();
            $table->unsignedTinyInteger('occupancy')->nullable();

            // Add index
            $table->index(['vehicle', 'agency_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('vehicles', function (Blueprint $table) {
            $table->dropColumn(['relationship', 'label', 'plate', 'odometer', 'timestamp', 'congestion', 'occupancy']);
            $table->string('status')->change();
            $table->dropIndex('vehicles_vehicle_agency_id_index');
        });
    }
}
