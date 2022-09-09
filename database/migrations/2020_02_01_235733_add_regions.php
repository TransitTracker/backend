<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRegions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('regions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('info_title')->nullable();
            $table->text('info_body')->nullable();
            $table->string('map_box');
            $table->string('map_zoom');
            $table->text('conditions');
            $table->text('credits');
            $table->text('map')->nullable();
            $table->timestamps();
        });

        Schema::table('agencies', function (Blueprint $table) {
            $table->unsignedInteger('region_id')->nullable();
        });

        Schema::table('alerts', function (Blueprint $table) {
            $table->unsignedInteger('region_id')->nullable();
        });

        Schema::table('stats', function (Blueprint $table) {
            $table->unsignedInteger('region_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('regions');
        Schema::table('agencies', function (Blueprint $table) {
            $table->dropColumn('region_id');
        });
        Schema::table('alerts', function (Blueprint $table) {
            $table->dropColumn('region_id');
        });
        Schema::table('stats', function (Blueprint $table) {
            $table->dropColumn('region_id');
        });
    }
}
