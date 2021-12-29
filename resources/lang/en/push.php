<?php

return [
    'new_vehicle' => [
        'title' => ':emoji New :type! :label | :agency',
        'body' => ':label has appeared for this first time, on route :route',
        'action' => '📍 Track in the app',
    ],
    'electric_stm' => [
        'title' => '⚡ :label is on route :headsign!',
        'body' => ':label made his first appearance today, on route :route',
        'action_track' => '📍 Track',
        'action_gtfstools' => '⏭️ Departures',
    ],
    'welcome' => [
        'title' => 'Subscription activated for Transit Tracker!',
        'body' => 'You can change your subscriptions or unsubscribe at any time in the notification centre.',
    ],
];
