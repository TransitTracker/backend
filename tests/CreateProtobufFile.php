<?php

use Carbon\Carbon;
use FelixINX\TransitRealtime\FeedEntity;
use FelixINX\TransitRealtime\FeedHeader;
use FelixINX\TransitRealtime\FeedMessage;
use FelixINX\TransitRealtime\Position;
use FelixINX\TransitRealtime\TripDescriptor;
use FelixINX\TransitRealtime\VehicleDescriptor;
use FelixINX\TransitRealtime\VehiclePosition;

$feed = new FeedMessage();

$header = new FeedHeader();
$header->setGtfsRealtimeVersion('2.0');
$header->setIncrementality(0); // FULL_DATASET
$header->setTimestamp(Carbon::now()->getTimestamp());
$feed->setHeader($header);

$feedEntity = new FeedEntity();
$feedEntity->setId('TEST');
$feedEntity->setIsDeleted(false);
$feed->setEntity([$feedEntity]);

$vehiclePosition = new VehiclePosition();
$vehiclePosition->setCurrentStopSequence(2);
$vehiclePosition->setStopId('54356'); // Not supported by Transit Tracker
$vehiclePosition->setCurrentStatus(0); // IN_TRANSIT_TO
$vehiclePosition->setTimestamp(Carbon::now()->subMinute()->getTimestamp());
$vehiclePosition->setCongestionLevel(1); // RUNNING_SMOOTHLY
$vehiclePosition->setOccupancyStatus(2); // MANY_SEATS_AVAILABLE
$feedEntity->setVehicle($vehiclePosition);

$tripDescriptor = new TripDescriptor();
$tripDescriptor->setTripId('218445629');
$tripDescriptor->setRouteId('74');
$tripDescriptor->setDirectionId(1); // Not supported by Transit Tracker
$tripDescriptor->setStartTime(Carbon::now()->subMinute(30)->format('H:i:s'));
$tripDescriptor->setStartDate(Carbon::now()->subMinute(30)->format('Ymd'));
$tripDescriptor->setScheduleRelationship(2); // ADDED
$vehiclePosition->setTrip($tripDescriptor);

$vehicleDescriptor = new VehicleDescriptor();
$vehicleDescriptor->setId('TEST');
$vehicleDescriptor->setLabel('00001');
$vehicleDescriptor->setLicensePlate('TTRACKER');
$vehiclePosition->setVehicle($vehicleDescriptor);

$position = new Position();
$position->setLatitude(45.499231);
$position->setLongitude(-73.566454);
$position->setBearing(28);
$position->setOdometer(575871044);
$position->setSpeed(25.00);
$vehiclePosition->setPosition($position);

file_put_contents('storage/app/public/test.json', $feed->serializeToJsonString());
file_put_contents('storage/app/public/test.pb', $feed->serializeToString());
