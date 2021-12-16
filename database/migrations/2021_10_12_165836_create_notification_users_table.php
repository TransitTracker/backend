<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificationUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notification_users', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->boolean('is_active')->default(true);
            $table->boolean('is_french')->default(false);
            $table->string('endpoint', 500)->unique();
            $table->dateTime('expiration')->nullable();
            $table->boolean('subscribed_general_news')->default(true);
            $table->boolean('subscribed_electric_stm')->default(false);
            $table->index('uuid');
            $table->index('endpoint');
            $table->timestamps();
        });

        Schema::create('agency_notification_user', function (Blueprint $table) {
            $table->unsignedInteger('agency_id');
            $table->unsignedInteger('notification_user_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notification_users');
        Schema::dropIfExists('agency_notification_user');
    }
}
