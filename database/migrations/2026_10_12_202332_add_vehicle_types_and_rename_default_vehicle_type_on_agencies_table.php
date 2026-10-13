<?php

use App\Enums\VehicleType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('agencies', function (Blueprint $table) {
            $table->unsignedTinyInteger('default_vehicle_type')->default(VehicleType::Bus);
            $table->json('vehicle_types')->nullable();
        });

        $legacyTypes = [
            'bus' => VehicleType::Bus,
            'train' => VehicleType::Train,
            'tram' => VehicleType::Tram,
        ];

        DB::table('agencies')->select(['id', 'vehicles_type'])->orderBy('id')->each(function ($agency) use ($legacyTypes) {
            $type = $legacyTypes[strtolower((string) $agency->vehicles_type)] ?? VehicleType::Bus;

            DB::table('agencies')->where('id', $agency->id)->update([
                'default_vehicle_type' => $type,
                'vehicle_types' => json_encode([$type]),
            ]);
        });

        Schema::table('agencies', function (Blueprint $table) {
            $table->dropColumn('vehicles_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('agencies', function (Blueprint $table) {
            $table->string('vehicles_type')->default('bus');
        });

        $legacyTypes = [
            VehicleType::Train => 'train',
            VehicleType::Tram => 'tram',
        ];

        DB::table('agencies')->select(['id', 'default_vehicle_type'])->orderBy('id')->each(function ($agency) use ($legacyTypes) {
            DB::table('agencies')->where('id', $agency->id)->update([
                'vehicles_type' => $legacyTypes[(int) $agency->default_vehicle_type] ?? 'bus',
            ]);
        });

        Schema::table('agencies', function (Blueprint $table) {
            $table->dropColumn(['default_vehicle_type', 'vehicle_types']);
        });
    }
};
