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
        Schema::table('alerts', function (Blueprint $table) {
            $table->dropColumn(['is_active', 'can_be_closed', 'expiration']);
            $table->unsignedSmallInteger('category')
                ->nullable()
                ->after('body');
            $table->boolean('is_regional')
                ->default(true);
            $table->unsignedSmallInteger('status')
                ->default(4)
                ->before('title');
            $table->unsignedSmallInteger('new_status')
                ->nullable()
                ->after('status');
            $table->date('new_status_date')
                ->nullable()
                ->after('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('alerts', function (Blueprint $table) {
            $table->dropColumn(['category', 'is_regional', 'status', 'new_status', 'new_status_date']);
            $table->boolean('is_active')->default(false);
            $table->boolean('can_be_closed')->default(true);
            $table->dateTime('expiration')->nullable();
        });
    }
};
