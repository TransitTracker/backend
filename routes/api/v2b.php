<?php

use Illuminate\Database\Eloquent\Builder;

Route::get('agencies/{agency}/vehicles', [\App\Http\Controllers\Api\V2b\AgencyController::class, 'vehicles']);

// Original routes
Route::get('regions', [\App\Http\Controllers\Api\V2\RegionController::class, 'index']);
Route::get('tags', [\App\Http\Controllers\Api\V2\TagController::class, 'index']);
Route::get('links', [\App\Http\Controllers\Api\V2\LinkController::class, 'index']);
Route::get('landing', [\App\Http\Controllers\Api\V2\LandingController::class, 'index']);

Route::get('test', function () {
   $result = \App\Models\Gtfs\Shape::whereAgencyId(1)
       ->select(['agency_id', 'gtfs_shape_id', 'total_distance', \Illuminate\Support\Facades\DB::raw('ST_Length(shape)/1000 AS length_in_kilometers')])
       ->with([
           'firstTrip:trips.agency_id,trips.gtfs_shape_id,gtfs_trip_id,gtfs_route_id,headsign,gtfs_service_id',
           'firstTrip.stopTimes' => function ($query) {
                $query->select(['agency_id', 'gtfs_trip_id', 'departure', 'sequence']);
                $query->orderBy('sequence');
           },
       ])
       ->limit(15)
       ->get();
//        ->map(function ($shape) {
//            if (!$shape->firstTrip || !$shape->firstTrip->stopTimes) { return; }
//
//            $km = $shape->length_in_kilometers;
//            $stops = $shape->firstTrip->stopTimes->count();
//            $tripTime = \Carbon\Carbon::parse($shape->firstTrip->stopTimes->last()->departure)->floatDiffInHours($shape->firstTrip->stopTimes->first()->departure);
//
//            if (!$km || !$stops || !$tripTime) { return; }
//
//            $routeId = intval($shape->firstTrip->gtfs_route_id);
//            $frequentRoutes = [18, 24, 51, 67, 105, 121, 141, 165, 439, 32, 33, 44, 45, 48, 49, 55, 64, 69, 80, 90, 97, 103, 136, 161, 171, 187, 193, 196, 197, 406, 470];
//            return [
//              'id' => $shape->gtfs_shape_id,
//              'route_type' => match (true) {
//                $routeId <= 5 => 'Métro',
//                (300 <= $routeId) && ($routeId <= 399) => 'Nuit',
//                in_array($routeId, $frequentRoutes) => 'Fréquente',
//                default => 'Normal',
//              },
//              'total_distance' => round($km, 2),
//                'number_of_stops' => $shape->firstTrip->stopTimes->count(),
//                'stop_frequency' => round($km / $stops, 2),
//              'commercial_speed' => round($km / $tripTime, 2),
//
//            ];
//        });

   return $result;

});

Route::fallback(fn () => response()->json(['message' => 'Route not found in v2b.'], 404));
