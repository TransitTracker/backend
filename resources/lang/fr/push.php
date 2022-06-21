<?php

return [
    'new_vehicle' => [
        'title' => ':emoji Nouveau :type! :label | :agency',
        'body' => ':label est apparu pour la première fois, sur la route :route',
        'action' => '📍 Suivre',
    ],
    'updated_vehicle' => [
        'title' => ':emoji :label est sur la route :route!',
        'body' => ":label a fait sa première apparition aujourd'hui",
        'action_track' => '📍 Suivre',
    ],
    'electric_stm' => [
        'title' => '⚡ :label est sur la route :headsign!',
        'body' => ":label a fait sa première apparition aujourd'hui, sur la route :route",
        'action_track' => '📍 Suivre',
        'action_gtfstools' => '⏭️ Départs',
    ],
    'welcome' => [
        'title' => 'Abonnement activé pour Transit Tracker!',
        'body' => 'Vous pouvez modifier vos abonnements ou vous désabonner à tout moment via le centre de notification.',
    ],
];
