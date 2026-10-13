<?php

namespace Tests\Feature;

use App\Enums\VehicleType;
use App\Http\Resources\V2\AgencyResource;
use App\Jobs\SyncIconToMapbox;
use App\Models\Agency;
use ReflectionMethod;
use Tests\TestCase;

class AgencyVehicleTypesTest extends TestCase
{
    public function test_agency_casts_default_vehicle_type_as_enum(): void
    {
        $agency = new Agency;
        $agency->default_vehicle_type = VehicleType::Train;

        $this->assertInstanceOf(VehicleType::class, $agency->default_vehicle_type);
        $this->assertTrue($agency->default_vehicle_type->is(VehicleType::Train()));
    }

    public function test_agency_casts_vehicle_types_to_array(): void
    {
        $agency = new Agency;
        $agency->vehicle_types = [VehicleType::Bus, VehicleType::Tram];

        $this->assertSame([VehicleType::Bus, VehicleType::Tram], $agency->vehicle_types);

        $enums = $agency->vehicle_types_enum;
        $this->assertCount(2, $enums);
        $this->assertTrue($enums[0]->is(VehicleType::Bus()));
        $this->assertTrue($enums[1]->is(VehicleType::Tram()));
    }

    public function test_agency_vehicle_types_enum_falls_back_to_default_vehicle_type(): void
    {
        $agency = new Agency;
        $agency->default_vehicle_type = VehicleType::Tram;
        $agency->vehicle_types = [];

        $enums = $agency->vehicle_types_enum;
        $this->assertCount(1, $enums);
        $this->assertTrue($enums[0]->is(VehicleType::Tram()));
    }

    public function test_agency_resource_preserves_default_vehicle_type_string_and_includes_vehicle_types(): void
    {
        $agency = new Agency([
            'id' => 1,
            'name' => 'Test Transit',
            'short_name' => 'TT',
            'slug' => 'test-transit',
            'cities' => ['Montreal'],
            'color' => '#112233',
            'text_color' => '#FFFFFF',
            'default_vehicle_type' => VehicleType::Train,
            'vehicle_types' => [VehicleType::Train, VehicleType::Bus],
            'license' => [],
            'is_archived' => false,
        ]);
        $agency->setRelation('regions', collect());

        $resource = (new AgencyResource($agency))->toArray(request());

        $this->assertSame('train', $resource['defaultVehicleType']);
        $this->assertSame([VehicleType::Train, VehicleType::Bus], $resource['vehicleTypes']);
    }

    public function test_sync_icon_to_mapbox_targets_all_agency_vehicle_types(): void
    {
        $agency = new Agency([
            'slug' => 'stm',
            'color' => '#00aeef',
            'text_color' => '#ffffff',
            'default_vehicle_type' => VehicleType::Bus,
            'vehicle_types' => [VehicleType::Bus, VehicleType::Tram],
        ]);

        $job = new SyncIconToMapbox(collect([$agency]));

        $method = new ReflectionMethod($job, 'iconTargets');
        $targets = $method->invoke($job);

        $this->assertCount(2, $targets);
        $this->assertSame($agency, $targets[0][0]);
        $this->assertTrue($targets[0][1]->is(VehicleType::Bus()));
        $this->assertSame($agency, $targets[1][0]);
        $this->assertTrue($targets[1][1]->is(VehicleType::Tram()));
    }

    public function test_sync_icon_to_mapbox_targets_forced_vehicle_type_when_specified(): void
    {
        $agency = new Agency([
            'slug' => 'stm',
            'color' => '#00aeef',
            'text_color' => '#ffffff',
            'default_vehicle_type' => VehicleType::Bus,
            'vehicle_types' => [VehicleType::Bus, VehicleType::Tram],
        ]);

        $job = new SyncIconToMapbox(collect([$agency]), VehicleType::Train());

        $method = new ReflectionMethod($job, 'iconTargets');
        $targets = $method->invoke($job);

        $this->assertCount(1, $targets);
        $this->assertSame($agency, $targets[0][0]);
        $this->assertTrue($targets[0][1]->is(VehicleType::Train()));
    }
}
