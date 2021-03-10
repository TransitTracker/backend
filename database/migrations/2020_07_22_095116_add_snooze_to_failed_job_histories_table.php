<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSnoozeToFailedJobHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('failed_jobs_histories', function (Blueprint $table) {
            $table->dropColumn('last_failed');
            $table->dateTime('snooze')->default(now());
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('failed_jobs_histories', function (Blueprint $table) {
            $table->dropColumn('snooze');
            $table->dateTime('last_failed')->default(now());
        });
    }
}
