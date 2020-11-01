<?php

use App\Enums\CongestionLevel;
use App\Enums\OccupancyStatus;
use App\Enums\ScheduleRelationship;
use App\Enums\VehicleStopStatus;

return [
    CongestionLevel::class => [
        CongestionLevel::UNKNOWN_CONGESTION_LEVEL => 'Niveau de congestion inconnu',
        CongestionLevel::RUNNING_SMOOTHLY => 'Aucune congestion',
        CongestionLevel::STOP_AND_GO => 'Faible congestion',
        CongestionLevel::CONGESTION => 'Congestion',
        CongestionLevel::SEVERE_CONGESTION => 'Congestion sévère',
    ],
    OccupancyStatus::class => [
        OccupancyStatus::EMPTY => 'Vide',
        OccupancyStatus::MANY_SEATS_AVAILABLE => 'Plusieurs sièges disponibles',
        OccupancyStatus::FEW_SEATS_AVAILABLE => 'Quelques sièges disponibles',
        OccupancyStatus::STANDING_ROOM_ONLY => 'Places debout seulement',
        OccupancyStatus::CRUSHED_STANDING_ROOM_ONLY => 'Quelques places debout seulement',
        OccupancyStatus::FULL => 'Plein',
        OccupancyStatus::NOT_ACCEPTING_PASSENGERS => "N'accepte plus de passagers",
    ],
    ScheduleRelationship::class => [
        ScheduleRelationship::SCHEDULED => 'Prévu',
        ScheduleRelationship::ADDED => 'Ajouté',
        ScheduleRelationship::UNSCHEDULED => 'Non prévu',
        ScheduleRelationship::CANCELED => 'Annulé',
    ],
    VehicleStopStatus::class => [
        VehicleStopStatus::INCOMING_AT => 'Arrive au prochain arrêt',
        VehicleStopStatus::STOPPED_AT => "À l'arrêt",
        VehicleStopStatus::IN_TRANSIT_TO => 'En déplacement',
    ],
];
