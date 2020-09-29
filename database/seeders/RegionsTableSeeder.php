<?php

namespace Database\Seeders;

use App\Models\Region;
use Illuminate\Database\Seeder;

class RegionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $mtl = new Region();
        $mtl->name = 'Montréal';
        $mtl->slug = 'mtl';

        $it = [];
        $it['en'] = 'Welcome to version 2.0';
        $it['fr'] = 'Bienvenue dans la version 2.0';
        $mtl->info_title = $it;

        $ib = [];
        $ib['en'] = '<b>Montr\u00e9al Transit Tracker version 2 introduces several new features and changes that enhance your experience.<\/b><ul><li>New interface<\/li><li>More agencies<\/li><li>Auto refresh<\/li><li>Detailed information on vehicles and their trip<\/li><\/ul>';
        $ib['fr'] = '<b>Montr\u00e9al Transit Tracker version 2 introduit plusieurs nouvelles fonctionnalit\u00e9s et modifications pour am\u00e9liorer votre exp\u00e9rience.<\/b><ul><li>Nouvelle interface<\/li><li>Beaucoup plus d\'agences (STL, autobus d\\\'exo et RTL)<\/li><li>Actualisation automatique<\/li><li>Informations d\u00e9taill\u00e9es sur les v\u00e9hicules et leurs voyages<\/li><li>Traduction en fran\u00e7ais<\/li><\/ul>';
        $mtl->info_body = $ib;

        $mb = [];
        array_push($mb, -73.6610);
        array_push($mb, 45.5894);
        $mtl->map_box = $mb;

        $mtl->map_zoom = 9;

        $co = [];
        $co['en'] = '';
        $co['fr'] = '';
        $mtl->conditions = $co;

        $cr = [];
        $cr['en'] = '<p>For STM vehicles, you can see related departures. A big thanks to <a href="https://www.cs.mcgill.ca/~jread3/">Gerbil\'s app</a> for this feature!</p><hr class="mb-4"><p>This application is intended to provide an overview of the Montréal metropolitan area\'s public transportation network.</p><p>The data on this website is given as is and should not be used as a public transport timetable. The accuracy and reliability of the data is not guaranteed.</p><p>The data is provided by the following agencies:</p><ul class="mb-4"><li><a href="http://stm.info">Société de transport de Montréal (STM)</a></li><li><a href="https://stl.laval.qc.ca">Société de transport de Laval (STL)</a></li><li><a href="https://exo.quebec">exo</a> (including exo buses, exo trains and Réseau de transport de Longueuil buses)</li></ul><p>All of the above data is available under the <a href="https://creativecommons.org/licenses/by/4.0/deed.en">Creative Common 4.0 CC BY</a> license.</p>';
        $cr['fr'] = '<p>Pour les véhicles de la STM, vous pouvez voir les départs reliés. Un grand merci à <a href="https://www.cs.mcgill.ca/~jread3/">l\'application de Gerbil</a> pour cette fonctionnalité!</p><hr class="mb-4"><p>Cette application à pour but d\'offrir une vue d\'ensemble du réseau de transport en commun de la région métropolitaine de Montréal.</p><p>Les données de cette application sont présentées telles quelles et ne doivent pas être utilisées comme horaire de transport en commun. L\'exactitude et la fiabilité des données ne sont pas garanties.</p><p>Les données sont fournies par les agences suivantes :</p><ul class="mb-4"><li><a href="http://stm.info">Société de transport de Montréal (STM)</a></li><li><a href="https://stl.laval.qc.ca">Société de transport de Laval (STL)</a></li><li><a href="https://exo.quebec">exo</a> (incluant les autobus d\'exo, les trains d\'exo et les autobus du Réseau de transport de Longueuil)</li></ul><p>Les données ci-dessus sont toutes disponibles sous la licence  <a href="https://creativecommons.org/licenses/by/4.0/deed.en">Creative Common 4.0 CC BY</a>.</p>';
        $mtl->credits = $cr;

        $mtl->map = '<svg></svg>';
        $mtl->save();
    }
}
