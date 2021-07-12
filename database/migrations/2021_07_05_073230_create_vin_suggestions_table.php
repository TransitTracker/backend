<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVinSuggestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vin_suggestions', function (Blueprint $table) {
            $table->id();
            $table->string('vin');
            $table->string('label');
            $table->string('note');
            $table->integer('upvotes')->default(0);
            $table->timestamps();
            $table->index('vin');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vin_suggestions');
    }
}
