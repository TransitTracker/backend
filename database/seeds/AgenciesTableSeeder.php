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
            'text_color' => '#FFFFFF',
            'vehicles_type' => 'bus',
            'gtfs_id' => 'STM',
            'slug' => 'stm'
        ]);

        DB::table('agencies')->insert([
            'name' => 'exo Trains',
            'color' => '#000000',
            'text_color' => '#FFFFFF',
            'vehicles_type' => 'train',
            'gtfs_id' => 'TRAINS',
            'slug' => 'trains'
        ]);

        DB::table('agencies')->insert([
            'name' => 'Société de transport de Laval',
            'color' => '#84c444',
            'text_color' => '#FFFFFF',
            'vehicles_type' => 'bus',
            'gtfs_id' => 'STL',
            'slug' => 'stl'
        ]);

        DB::table('agencies')->insert([
            'name' => 'Réseau de transport de Longueuil',
            'color' => '#a80532',
            'text_color' => '#FFFFFF',
            'vehicles_type' => 'bus',
            'gtfs_id' => 'RTL',
            'slug' => 'rtl'
        ]);

        DB::table('agencies')->insert([
            'name' => 'exo Laurentides',
            'color' => '#00A586',
            'text_color' => '#FFFFFF',
            'vehicles_type' => 'bus',
            'gtfs_id' => 'CITLA',
            'slug' => 'la'
        ]);

        DB::table('agencies')->insert([
            'name' => 'exo Vallée-du-Richelieu',
            'color' => '#1F96A4',
            'text_color' => '#FFFFFF',
            'vehicles_type' => 'bus',
            'gtfs_id' => 'CITVR',
            'slug' => 'vr'
        ]);

        DB::table('agencies')->insert([
            'name' => 'exo Le Richelain',
            'color' => '#7C5D81',
            'text_color' => '#FFFFFF',
            'vehicles_type' => 'bus',
            'gtfs_id' => 'CITLR',
            'slug' => 'lr'
        ]);

        DB::table('agencies')->insert([
            'name' => 'exo L\'Assomption',
            'color' => '#0071BA',
            'text_color' => '#FFFFFF',
            'vehicles_type' => 'bus',
            'gtfs_id' => 'MRCLASSO',
            'slug' => 'lasso'
        ]);

        DB::table('agencies')->insert([
            'name' => 'exo Sainte-Julie',
            'color' => '#F7A389',
            'text_color' => '#FFFFFF',
            'vehicles_type' => 'bus',
            'gtfs_id' => 'OMITSJU',
            'slug' => 'sju'
        ]);

        DB::table('agencies')->insert([
            'name' => 'exo Sud-Ouest',
            'color' => '#B94065',
            'text_color' => '#FFFFFF',
            'vehicles_type' => 'bus',
            'gtfs_id' => 'CITSO',
            'slug' => 'so'
        ]);

        DB::table('agencies')->insert([
            'name' => 'exo Haut-Saint-Laurent',
            'color' => '#DBE9D0',
            'text_color' => '#000000',
            'vehicles_type' => 'bus',
            'gtfs_id' => 'CITHSL',
            'slug' => 'hsl'
        ]);

        DB::table('agencies')->insert([
            'name' => 'exo La Presqu\'Île',
            'color' => '#FCEFC5',
            'text_color' => '#000000',
            'vehicles_type' => 'bus',
            'gtfs_id' => 'CITPI',
            'slug' => 'pi'
        ]);

        DB::table('agencies')->insert([
            'name' => 'exo Roussillon',
            'color' => '#CEDFE4',
            'text_color' => '#000000',
            'vehicles_type' => 'bus',
            'gtfs_id' => 'CITROUS',
            'slug' => 'rous'
        ]);

        DB::table('agencies')->insert([
            'name' => 'exo Sorel-Varennes',
            'color' => '#EFDCCE',
            'text_color' => '#000000',
            'vehicles_type' => 'bus',
            'gtfs_id' => 'CITSV',
            'slug' => 'sv'
        ]);

        DB::table('agencies')->insert([
            'name' => 'exo Terrebonne-Mascouche',
            'color' => '#9ED1C6',
            'text_color' => '#000000',
            'vehicles_type' => 'bus',
            'gtfs_id' => 'MRCLM',
            'slug' => 'tm'
        ]);

        DB::table('agencies')->insert([
            'name' => 'exo Chambly-Richelieu-Carignan',
            'color' => '#F1776A',
            'text_color' => '#FFFFFF',
            'vehicles_type' => 'bus',
            'gtfs_id' => 'CITCRC',
            'slug' => 'crc'
        ]);
    }
}
