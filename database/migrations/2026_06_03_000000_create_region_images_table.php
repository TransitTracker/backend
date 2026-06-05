<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('region_images', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('region_id');
            $table->string('image_path');
            $table->string('author_name');
            $table->string('author_email');
            $table->string('author_link')->nullable();
            $table->text('description');
            $table->string('status')->default('pending');
            $table->timestamps();

            $table->foreign('region_id')->references('id')->on('regions')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('region_images');
    }
};
