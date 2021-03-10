<?php

use App\Models\Agency;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMultipleRegionsToAgenciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Create belongsToMany table
        Schema::create('agency_region', function (Blueprint $table) {
            $table->unsignedInteger('agency_id');
            $table->unsignedInteger('region_id');
        });

        // Attach new relationship
        foreach (Agency::all() as $agency) {
            $agency->regions()->attach($agency->region_id);
        }

        // Final adjustments to agencies table
        Schema::table('agencies', function (Blueprint $table) {
            $table->dropColumn('region_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('agencies', function (Blueprint $table) {
            $table->unsignedInteger('region_id');
        });

        // Cannot convert many to many relationship to belongs to one
    }
}
