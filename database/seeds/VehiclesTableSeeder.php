<?php

use Illuminate\Database\Seeder;

class VehiclesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('vehicles')->insert([
            'active' => 1,
            'agency_id' => 1,
            'trip' => "197160757",
            'route' => "55",
            'start' => null,
            'vehicle' => "24219",
           'lat' => 45.55573,
            'lon' => -73.66755,
            'bearing' =>  null,
            'speed' => 0.0,
            'stop_sequence' => null,
            'status' => null,
            'headsign' => null,
            'short_name' => null,
            'created_at' => "2019-06-08 00:06:48",
            'updated_at' => "2019-06-08 12:28:31"
        ]);

        DB::table('vehicles')->insert([
            'active' => 1,
            'agency_id' => 2,
            'trip' => "3472646-TRAIN-H19-Blocks-Samedi-02",
            'route' => "4",
            'start' => null,
            'vehicle' => "AMT1341",
           'lat' => 45.60547,
            'lon' => -73.74434,
            'bearing' =>  145.0,
            'speed' => 80.0,
            'stop_sequence' => null,
            'status' => null,
            'headsign' => null,
            'short_name' => null,
            'created_at' => "2019-06-08 00:07:05",
            'updated_at' => "2019-06-08 12:28:18"
        ]);

        DB::table('vehicles')->insert([
            'active' => 1,
            'agency_id' => 3,
            'trip' => null,
            'route' => "55S",
            'start' => null,
            'vehicle' => "1406",
           'lat' => 45.55624,
            'lon' => -73.76777,
            'bearing' =>  52.0,
            'speed' => 16.0,
            'stop_sequence' => null,
            'status' => null,
            'headsign' => "55S",
            'short_name' => null,
            'created_at' => "2019-06-08 12:27:51",
            'updated_at' => "2019-06-08 12:28:03"
        ]);

        DB::table('vehicles')->insert([
            'active' => 1,
            'agency_id' => 4,
            'trip' => "6_2_R_SA_2403_08_29",
            'route' => "6",
            'start' => null,
            'vehicle' => "21402",
           'lat' => 45.52365,
            'lon' => -73.52158,
            'bearing' =>  99.71,
            'speed' => 0.0,
            'stop_sequence' => null,
            'status' => null,
            'headsign' => null,
            'short_name' => null,
            'created_at' => "2019-06-08 00:06:14",
            'updated_at' => "2019-06-08 12:29:02"
        ]);

        DB::table('vehicles')->insert([
            'active' => 1,
            'agency_id' => 5,
            'trip' => "3698946-LA-H19-LA_GTFS-Samedi-02",
            'route' => "11",
            'start' => null,
            'vehicle' => "16014215",
           'lat' => 45.60194,
            'lon' => -73.78972,
            'bearing' =>  172.55,
            'speed' => 0.0,
            'stop_sequence' => null,
            'status' => null,
            'headsign' => null,
            'short_name' => null,
            'created_at' => "2019-06-08 12:32:38",
            'updated_at' => "2019-06-08 12:33:02"
        ]);

        DB::table('vehicles')->insert([
            'active' => 1,
            'agency_id' => 6,
            'trip' => "3502250-VR-H19-VR_GTFS-Samedi-01",
            'route' => "200",
            'start' => null,
            'vehicle' => "3011303",
           'lat' => 45.50239,
            'lon' => -73.37757,
            'bearing' =>  73.66,
            'speed' => 15.0,
            'stop_sequence' => null,
            'status' => null,
            'headsign' => null,
            'short_name' => null,
            'created_at' => "2019-06-08 12:33:09",
            'updated_at' => "2019-06-08 12:33:11"
        ]);

        DB::table('vehicles')->insert([
            'active' => 1,
            'agency_id' => 7,
            'trip' => "3558073-LR-H19-LR_GTFS-Samedi-02",
            'route' => "323",
            'start' => null,
            'vehicle' => "308418",
           'lat' => 45.45203,
            'lon' => -73.46708,
            'bearing' =>  203.29,
            'speed' => 57.0,
            'stop_sequence' => null,
            'status' => null,
            'headsign' => null,
            'short_name' => null,
            'created_at' => "2019-06-08 12:34:15",
            'updated_at' => "2019-06-08 12:34:25"
        ]);

        DB::table('vehicles')->insert([
            'active' => 1,
            'agency_id' => 8,
            'trip' => "3411117-LASSO-H19-BGTFSLAS-Week-end-01",
            'route' => "8",
            'start' => null,
            'vehicle' => "219401",
           'lat' => 45.7672,
            'lon' => -73.43525,
            'bearing' =>  212.85,
            'speed' => 12.0,
            'stop_sequence' => null,
            'status' => null,
            'headsign' => null,
            'short_name' => null,
            'created_at' => "2019-06-08 12:34:42",
            'updated_at' => "2019-06-08 12:34:44"
        ]);

        DB::table('vehicles')->insert([
            'active' => 1,
            'agency_id' => 9,
            'trip' => "3543566-SJU-H19-SJU_GTFS-Week-end-01",
            'route' => "340",
            'start' => null,
            'vehicle' => "6005245",
           'lat' => 45.51164,
            'lon' => -73.37302,
            'bearing' =>  264.14,
            'speed' => 58.0,
            'stop_sequence' => null,
            'status' => null,
            'headsign' => null,
            'short_name' => null,
            'created_at' => "2019-06-08 12:35:57",
            'updated_at' => "2019-06-08 12:35:59"
        ]);

        DB::table('vehicles')->insert([
            'active' => 1,
            'agency_id' => 10,
            'trip' => "3540160-SO-H19-SO_GTFS-Samedi-01",
            'route' => "31",
            'start' => null,
            'vehicle' => "3026333",
           'lat' => 45.36839,
            'lon' => -73.71033,
            'bearing' =>  103.3,
            'speed' => 0.0,
            'stop_sequence' => null,
            'status' => null,
            'headsign' => null,
            'short_name' => null,
            'created_at' => "2019-06-08 12:36:42",
            'updated_at' => "2019-06-08 12:36:46"
        ]);
    }
}
