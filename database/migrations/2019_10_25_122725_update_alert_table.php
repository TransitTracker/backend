<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateAlertTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('alerts', function (Blueprint $table) {
            $table->dropColumn('colour');
            $table->dropColumn('expiration');
            $table->boolean('is_active')->default(false);
            $table->string('icon')->nullable();
            $table->string('color')->default('primary');
            $table->boolean('can_be_closed')->default(true);
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
            $table->dropColumn(['is_active', 'icon', 'color', 'can_be_closed']);
            $table->string('colour')->nullable();
            $table->dateTime('expiration')->nullable();
        });
    }
}
