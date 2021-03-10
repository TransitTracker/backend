<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLinksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('links', function (Blueprint $table) {
            $table->id();
            $table->string('internal_title');
            $table->string('title');
            $table->string('description');
            $table->string('link');
            $table->timestamps();
        });

        Schema::create('agency_link', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('agency_id');
            $table->unsignedInteger('link_id');
        });

        Schema::create('link_vehicle', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('link_id');
            $table->unsignedInteger('vehicle_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('links');
        Schema::dropIfExists('agency_link');
        Schema::dropIfExists('link_vehicle');
    }
}
