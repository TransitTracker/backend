<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeAlertTranslatableFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('alerts', function (Blueprint $table) {
            $table->dropColumn(['title_en', 'title_fr', 'body_en', 'body_fr', 'region_id']);
            $table->json('title')->nullable();
            $table->json('body')->nullable();
        });

        Schema::create('alert_region', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('alert_id');
            $table->unsignedInteger('region_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('alerts', function (Blueprint $table) {
            $table->dropColumn(['title', 'body']);
            $table->string('title_en')->nullable();
            $table->string('title_fr')->nullable();
            $table->text('body_en')->nullable();
            $table->text('body_fr')->nullable();
            $table->unsignedInteger('region_id')->nullable();
        });

        Schema::dropIfExists('alert_region');
    }
}
