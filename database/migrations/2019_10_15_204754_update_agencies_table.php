<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateAgenciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('agencies', function (Blueprint $table) {
            $table->dropColumn('gtfs_id');
            $table->string('static_gtfs_url')->nullable();
            $table->string('realtime_url')->nullable();
            $table->string('realtime_type')->nullable();
            $table->json('realtime_options')->nullable();
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
            $table->dropColumn(['static_gtfs_url', 'realtime_url', 'realtime_type', 'realtime_options']);
            $table->string('gtfs_id');
        });
    }
}
