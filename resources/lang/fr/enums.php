<?php

use App\Enums\TagType;

return [
    'App\\Enums\\CongestionLevel' => [
        '0' => 'Niveau de congestion inconnu',
        '1' => 'Aucune congestion',
        '2' => 'Faible congestion',
        '3' => 'Congestion',
        '4' => 'Congestion sévère',
    ],
    'App\\Enums\\OccupancyStatus' => [
        '0' => 'Vide',
        '1' => 'Plusieurs sièges disponibles',
        '2' => 'Quelques sièges disponibles',
        '3' => 'Places debout seulement',
        '4' => 'Quelques places debout seulement',
        '5' => 'Plein',
        '6' => 'N\'accepte plus de passagers',
    ],
    'App\\Enums\\ScheduleRelationship' => [
        '0' => 'Prévu',
        '1' => 'Ajouté',
        '2' => 'Non prévu',
        '3' => 'Annulé',
    ],
    'App\\Enums\\VehicleStopStatus' => [
        '0' => 'Arrive au prochain arrêt',
        '1' => 'À l\'arrêt',
        '2' => 'En déplacement',
    ],
    TagType::class => [
        TagType::Unspecified => 'Non spécifié',
        TagType::StmGarage => 'Centre de transport de la STM',
        TagType::Operator => 'Opérateur',
    ],
];
