<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('information', function (Blueprint $table) {
            $table->string('vin', 17)->primary()->unique();
            $table->string('make');
            $table->string('model');
            $table->unsignedInteger('year');
            $table->unsignedInteger('length')->nullable();
            $table->string('engine')->nullable();
            $table->string('assembly')->nullable();
            $table->string('fuel')->nullable();
            $table->string('sequence')->nullable();
            $table->json('others')->nullable();
            $table->timestamps();
            $table->index('make');
            $table->index('model');
            $table->index(['make', 'model']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('information');
    }
};
