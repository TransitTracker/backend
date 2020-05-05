<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFailedJobsHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('failed_jobs_histories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedInteger('agency_id')->nullable();
            $table->string('exception');
            $table->dateTime('last_failed');
            $table->index(['name', 'exception']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('failed_jobs_histories');
    }
}
