<?php

use Illuminate\Database\Seeder;

class AgenciesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('agencies')->insert([
            'name' => 'Société de transport de Montréal',
            'color' => '#00aeef',
            'vehicles_type' => 'bus',
            'gtfs_id' => 'STM',
            'slug' => 'stm'
        ]);

        DB::table('agencies')->insert([
            'name' => 'exo - Trains',
            'color' => '#000000',
            'vehicles_type' => 'train',
            'gtfs_id' => 'TRAINS',
            'slug' => 'trains'
        ]);

        DB::table('agencies')->insert([
            'name' => 'Société de transport de Laval',
            'color' => '#84c444',
            'vehicles_type' => 'bus',
            'gtfs_id' => 'STL',
            'slug' => 'stl'
        ]);

        DB::table('agencies')->insert([
            'name' => 'Réseau de transport de Longueuil',
            'color' => '#a80532',
            'vehicles_type' => 'bus',
            'gtfs_id' => 'RTL',
            'slug' => 'rtl'
        ]);

        DB::table('agencies')->insert([
            'name' => 'exo Laurentides',
            'color' => '#00A586',
            'vehicles_type' => 'bus',
            'gtfs_id' => 'CITLA',
            'slug' => 'citla'
        ]);

        DB::table('agencies')->insert([
            'name' => 'exo Vallée-du-Richelieu',
            'color' => '#1F96A4',
            'vehicles_type' => 'bus',
            'gtfs_id' => 'CITVR',
            'slug' => 'citvr'
        ]);

        DB::table('agencies')->insert([
            'name' => 'exo Le Richelain',
            'color' => '#7C5D81',
            'vehicles_type' => 'bus',
            'gtfs_id' => 'CITLR',
            'slug' => 'citlr'
        ]);

        DB::table('agencies')->insert([
            'name' => 'exo L\'Assomption',
            'color' => '#0071BA',
            'vehicles_type' => 'bus',
            'gtfs_id' => 'MRCLASSO',
            'slug' => 'mrclasso'
        ]);

        DB::table('agencies')->insert([
            'name' => 'exo Sainte-Julie',
            'color' => '#F7A389',
            'vehicles_type' => 'bus',
            'gtfs_id' => 'OMITSJU',
            'slug' => 'omitsju'
        ]);

        DB::table('agencies')->insert([
            'name' => 'exo Sud-Ouest',
            'color' => '#B94065',
            'vehicles_type' => 'bus',
            'gtfs_id' => 'CITSO',
            'slug' => 'citso'
        ]);
    }
}
