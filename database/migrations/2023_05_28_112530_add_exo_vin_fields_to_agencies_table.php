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
        Schema::table('agencies', function (Blueprint $table) {
            $table->unsignedInteger('exo_order_id')->nullable()->after('slug');
            $table->string('name_slug')->unique()->nullable()->after('slug');
            $table->longText('area_path')->nullable()->after('slug');
            $table->boolean('is_exo_sector')->default(false)->after('slug');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('agencies', function (Blueprint $table) {
            $table->dropColumn(['exo_order_id', 'name_slug', 'area_path', 'is_exo_sector']);
        });
    }
};
