<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('carriages', function (Blueprint $table) {
            $table->id();
            $table->string('agency_id');
            $table->string('carriage_id');
            $table->string('vehicle_id');
            $table->string('label')->nullable();
            $table->unsignedTinyInteger('occupancy_status')->nullable();
            $table->unsignedInteger('sequence')->nullable();
            $table->unsignedInteger('carriage_type_id')->nullable();
            $table->timestamps();
            $table->index(['agency_id', 'vehicle_id']);
            $table->unique(['agency_id', 'carriage_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carriages');
    }
};
