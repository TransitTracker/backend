<?php

use App\Models\Vehicle;
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
        Schema::table('vehicles', function (Blueprint $table) {
            $table->dateTime('last_seen_at')->nullable()->after('updated_at');
        });

        Vehicle::whereNotNull('timestamp')
            ->select(['id'])
            ->update([
                'last_seen_at' => DB::raw('FROM_UNIXTIME(timestamp)'),
            ]);

        Vehicle::whereNull('timestamp')
            ->select(['id'])
            ->update([
                'last_seen_at' => DB::raw('updated_at'),
            ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vehicles', function (Blueprint $table) {
            $table->dropColumn('last_seen_at');
        });
    }
};
