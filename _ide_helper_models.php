<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * App\Models\Agency
 *
 * @property int $id
 * @property string $name
 * @property string $color
 * @property string $vehicles_type
 * @property string $slug
 * @property int|null $exo_order_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $timestamp
 * @property string $text_color
 * @property \Illuminate\Database\Eloquent\Collection<int, \App\Models\Tag> $tags
 * @property bool $is_active
 * @property bool $is_archived
 * @property string|null $static_gtfs_url
 * @property string|null $realtime_url
 * @property string|null $realtime_type
 * @property array|null $license
 * @property bool $refresh_is_active
 * @property string|null $short_name
 * @property string $cron_schedule
 * @property array|null $cities
 * @property string|null $static_etag
 * @property array|null $headers
 * @property string|null $name_slug
 * @property string|null $area_path
 * @property bool $is_exo_sector
 * @property \Illuminate\Support\Collection|null $features
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\NotificationUser> $activeNotificationUsers
 * @property-read int|null $active_notification_users_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Vehicle> $exoWithVin
 * @property-read int|null $exo_with_vin_count
 * @property-read array $random_cities
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Link> $links
 * @property-read int|null $links_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\NotificationUser> $notificationUsers
 * @property-read int|null $notification_users_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Region> $regions
 * @property-read int|null $regions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Gtfs\Route> $routes
 * @property-read int|null $routes_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Gtfs\Service> $services
 * @property-read int|null $services_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Gtfs\Shape> $shapes
 * @property-read int|null $shapes_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Gtfs\StopTime> $stopTimes
 * @property-read int|null $stop_times_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Gtfs\Stop> $stops
 * @property-read int|null $stops_count
 * @property-read int|null $tags_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Gtfs\Trip> $trips
 * @property-read int|null $trips_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Vehicle> $vehicles
 * @property-read int|null $vehicles_count
 * @method static \Illuminate\Database\Eloquent\Builder|Agency active()
 * @method static \Illuminate\Database\Eloquent\Builder|Agency exo()
 * @method static \Illuminate\Database\Eloquent\Builder|Agency newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Agency newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Agency query()
 * @method static \Illuminate\Database\Eloquent\Builder|Agency whereAreaPath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Agency whereCities($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Agency whereColor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Agency whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Agency whereCronSchedule($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Agency whereExoOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Agency whereFeatures($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Agency whereHeaders($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Agency whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Agency whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Agency whereIsArchived($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Agency whereIsExoSector($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Agency whereLicense($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Agency whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Agency whereNameSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Agency whereRealtimeType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Agency whereRealtimeUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Agency whereRefreshIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Agency whereShortName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Agency whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Agency whereStaticEtag($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Agency whereStaticGtfsUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Agency whereTags($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Agency whereTextColor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Agency whereTimestamp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Agency whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Agency whereVehiclesType($value)
 */
	class Agency extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Alert
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property bool $is_active
 * @property string|null $icon
 * @property string $color
 * @property bool $can_be_closed
 * @property array|null $title
 * @property array $subtitle
 * @property array|null $body
 * @property string|null $action
 * @property \ArrayObject|null $action_parameters
 * @property string|null $expiration
 * @property string|null $image
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Region> $regions
 * @property-read int|null $regions_count
 * @property-read mixed $translations
 * @method static \Illuminate\Database\Eloquent\Builder|Alert active()
 * @method static \Illuminate\Database\Eloquent\Builder|Alert newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Alert newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Alert query()
 * @method static \Illuminate\Database\Eloquent\Builder|Alert whereAction($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Alert whereActionParameters($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Alert whereBody($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Alert whereCanBeClosed($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Alert whereColor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Alert whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Alert whereExpiration($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Alert whereIcon($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Alert whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Alert whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Alert whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Alert whereLocale(string $column, string $locale)
 * @method static \Illuminate\Database\Eloquent\Builder|Alert whereLocales(string $column, array $locales)
 * @method static \Illuminate\Database\Eloquent\Builder|Alert whereSubtitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Alert whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Alert whereUpdatedAt($value)
 */
	class Alert extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\FailedJob
 *
 * @property int $id
 * @property string $name
 * @property int|null $agency_id
 * @property string $exception
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $snooze
 * @property-read \App\Models\Agency|null $agency
 * @method static \Illuminate\Database\Eloquent\Builder|FailedJob newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FailedJob newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FailedJob query()
 * @method static \Illuminate\Database\Eloquent\Builder|FailedJob whereAgencyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FailedJob whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FailedJob whereException($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FailedJob whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FailedJob whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FailedJob whereSnooze($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FailedJob whereUpdatedAt($value)
 */
	class FailedJob extends \Eloquent {}
}

namespace App\Models\Gtfs{
/**
 * App\Models\Gtfs\Route
 *
 * @property int $id
 * @property string $agency_id
 * @property string $gtfs_route_id
 * @property int $type
 * @property string $short_name
 * @property string $long_name
 * @property string $color
 * @property string $text_color
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Agency|null $agency
 * @method static \Illuminate\Database\Eloquent\Builder|Route newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Route newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Route query()
 * @method static \Illuminate\Database\Eloquent\Builder|Route whereAgencyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Route whereColor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Route whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Route whereGtfsRouteId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Route whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Route whereLongName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Route whereShortName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Route whereTextColor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Route whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Route whereUpdatedAt($value)
 */
	class Route extends \Eloquent {}
}

namespace App\Models\Gtfs{
/**
 * App\Models\Gtfs\Service
 *
 * @property int $id
 * @property string $gtfs_service_id
 * @property int $monday
 * @property int $tuesday
 * @property int $wednesday
 * @property int $thursday
 * @property int $friday
 * @property int $saturday
 * @property int $sunday
 * @property string $start_date
 * @property string $end_date
 * @property int $agency_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Agency|null $agency
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Gtfs\Trip> $trips
 * @property-read int|null $trips_count
 * @method static \Illuminate\Database\Eloquent\Builder|Service newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Service newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Service query()
 * @method static \Illuminate\Database\Eloquent\Builder|Service whereAgencyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Service whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Service whereEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Service whereFriday($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Service whereGtfsServiceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Service whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Service whereMonday($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Service whereSaturday($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Service whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Service whereSunday($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Service whereThursday($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Service whereTuesday($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Service whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Service whereWednesday($value)
 */
	class Service extends \Eloquent {}
}

namespace App\Models\Gtfs{
/**
 * App\Models\Gtfs\Shape
 *
 * @property int $id
 * @property int $agency_id
 * @property string $gtfs_shape_id
 * @property \MatanYadaev\EloquentSpatial\Objects\Geometry $shape
 * @property float|null $total_distance
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Agency|null $agency
 * @property-read \App\Models\Gtfs\Trip|null $firstTrip
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Gtfs\Trip> $trips
 * @property-read int|null $trips_count
 * @method static \MatanYadaev\EloquentSpatial\SpatialBuilder|Shape newModelQuery()
 * @method static \MatanYadaev\EloquentSpatial\SpatialBuilder|Shape newQuery()
 * @method static \MatanYadaev\EloquentSpatial\SpatialBuilder|Shape orderByDistance(\Illuminate\Contracts\Database\Query\Expression|\MatanYadaev\EloquentSpatial\Objects\Geometry|string $column, \Illuminate\Contracts\Database\Query\Expression|\MatanYadaev\EloquentSpatial\Objects\Geometry|string $geometryOrColumn, string $direction = 'asc')
 * @method static \MatanYadaev\EloquentSpatial\SpatialBuilder|Shape orderByDistanceSphere(\Illuminate\Contracts\Database\Query\Expression|\MatanYadaev\EloquentSpatial\Objects\Geometry|string $column, \Illuminate\Contracts\Database\Query\Expression|\MatanYadaev\EloquentSpatial\Objects\Geometry|string $geometryOrColumn, string $direction = 'asc')
 * @method static \MatanYadaev\EloquentSpatial\SpatialBuilder|Shape query()
 * @method static \MatanYadaev\EloquentSpatial\SpatialBuilder|Shape whereAgencyId($value)
 * @method static \MatanYadaev\EloquentSpatial\SpatialBuilder|Shape whereContains(\Illuminate\Contracts\Database\Query\Expression|\MatanYadaev\EloquentSpatial\Objects\Geometry|string $column, \Illuminate\Contracts\Database\Query\Expression|\MatanYadaev\EloquentSpatial\Objects\Geometry|string $geometryOrColumn)
 * @method static \MatanYadaev\EloquentSpatial\SpatialBuilder|Shape whereCreatedAt($value)
 * @method static \MatanYadaev\EloquentSpatial\SpatialBuilder|Shape whereCrosses(\Illuminate\Contracts\Database\Query\Expression|\MatanYadaev\EloquentSpatial\Objects\Geometry|string $column, \Illuminate\Contracts\Database\Query\Expression|\MatanYadaev\EloquentSpatial\Objects\Geometry|string $geometryOrColumn)
 * @method static \MatanYadaev\EloquentSpatial\SpatialBuilder|Shape whereDisjoint(\Illuminate\Contracts\Database\Query\Expression|\MatanYadaev\EloquentSpatial\Objects\Geometry|string $column, \Illuminate\Contracts\Database\Query\Expression|\MatanYadaev\EloquentSpatial\Objects\Geometry|string $geometryOrColumn)
 * @method static \MatanYadaev\EloquentSpatial\SpatialBuilder|Shape whereDistance(\Illuminate\Contracts\Database\Query\Expression|\MatanYadaev\EloquentSpatial\Objects\Geometry|string $column, \Illuminate\Contracts\Database\Query\Expression|\MatanYadaev\EloquentSpatial\Objects\Geometry|string $geometryOrColumn, string $operator, int|float $value)
 * @method static \MatanYadaev\EloquentSpatial\SpatialBuilder|Shape whereDistanceSphere(\Illuminate\Contracts\Database\Query\Expression|\MatanYadaev\EloquentSpatial\Objects\Geometry|string $column, \Illuminate\Contracts\Database\Query\Expression|\MatanYadaev\EloquentSpatial\Objects\Geometry|string $geometryOrColumn, string $operator, int|float $value)
 * @method static \MatanYadaev\EloquentSpatial\SpatialBuilder|Shape whereEquals(\Illuminate\Contracts\Database\Query\Expression|\MatanYadaev\EloquentSpatial\Objects\Geometry|string $column, \Illuminate\Contracts\Database\Query\Expression|\MatanYadaev\EloquentSpatial\Objects\Geometry|string $geometryOrColumn)
 * @method static \MatanYadaev\EloquentSpatial\SpatialBuilder|Shape whereGtfsShapeId($value)
 * @method static \MatanYadaev\EloquentSpatial\SpatialBuilder|Shape whereId($value)
 * @method static \MatanYadaev\EloquentSpatial\SpatialBuilder|Shape whereIntersects(\Illuminate\Contracts\Database\Query\Expression|\MatanYadaev\EloquentSpatial\Objects\Geometry|string $column, \Illuminate\Contracts\Database\Query\Expression|\MatanYadaev\EloquentSpatial\Objects\Geometry|string $geometryOrColumn)
 * @method static \MatanYadaev\EloquentSpatial\SpatialBuilder|Shape whereNotContains(\Illuminate\Contracts\Database\Query\Expression|\MatanYadaev\EloquentSpatial\Objects\Geometry|string $column, \Illuminate\Contracts\Database\Query\Expression|\MatanYadaev\EloquentSpatial\Objects\Geometry|string $geometryOrColumn)
 * @method static \MatanYadaev\EloquentSpatial\SpatialBuilder|Shape whereNotWithin(\Illuminate\Contracts\Database\Query\Expression|\MatanYadaev\EloquentSpatial\Objects\Geometry|string $column, \Illuminate\Contracts\Database\Query\Expression|\MatanYadaev\EloquentSpatial\Objects\Geometry|string $geometryOrColumn)
 * @method static \MatanYadaev\EloquentSpatial\SpatialBuilder|Shape whereOverlaps(\Illuminate\Contracts\Database\Query\Expression|\MatanYadaev\EloquentSpatial\Objects\Geometry|string $column, \Illuminate\Contracts\Database\Query\Expression|\MatanYadaev\EloquentSpatial\Objects\Geometry|string $geometryOrColumn)
 * @method static \MatanYadaev\EloquentSpatial\SpatialBuilder|Shape whereShape($value)
 * @method static \MatanYadaev\EloquentSpatial\SpatialBuilder|Shape whereSrid(\Illuminate\Contracts\Database\Query\Expression|\MatanYadaev\EloquentSpatial\Objects\Geometry|string $column, string $operator, int|float $value)
 * @method static \MatanYadaev\EloquentSpatial\SpatialBuilder|Shape whereTotalDistance($value)
 * @method static \MatanYadaev\EloquentSpatial\SpatialBuilder|Shape whereTouches(\Illuminate\Contracts\Database\Query\Expression|\MatanYadaev\EloquentSpatial\Objects\Geometry|string $column, \Illuminate\Contracts\Database\Query\Expression|\MatanYadaev\EloquentSpatial\Objects\Geometry|string $geometryOrColumn)
 * @method static \MatanYadaev\EloquentSpatial\SpatialBuilder|Shape whereUpdatedAt($value)
 * @method static \MatanYadaev\EloquentSpatial\SpatialBuilder|Shape whereWithin(\Illuminate\Contracts\Database\Query\Expression|\MatanYadaev\EloquentSpatial\Objects\Geometry|string $column, \Illuminate\Contracts\Database\Query\Expression|\MatanYadaev\EloquentSpatial\Objects\Geometry|string $geometryOrColumn)
 * @method static \MatanYadaev\EloquentSpatial\SpatialBuilder|Shape withCentroid(\Illuminate\Contracts\Database\Query\Expression|\MatanYadaev\EloquentSpatial\Objects\Geometry|string $column, string $alias = 'centroid')
 * @method static \MatanYadaev\EloquentSpatial\SpatialBuilder|Shape withDistance(\Illuminate\Contracts\Database\Query\Expression|\MatanYadaev\EloquentSpatial\Objects\Geometry|string $column, \Illuminate\Contracts\Database\Query\Expression|\MatanYadaev\EloquentSpatial\Objects\Geometry|string $geometryOrColumn, string $alias = 'distance')
 * @method static \MatanYadaev\EloquentSpatial\SpatialBuilder|Shape withDistanceSphere(\Illuminate\Contracts\Database\Query\Expression|\MatanYadaev\EloquentSpatial\Objects\Geometry|string $column, \Illuminate\Contracts\Database\Query\Expression|\MatanYadaev\EloquentSpatial\Objects\Geometry|string $geometryOrColumn, string $alias = 'distance')
 */
	class Shape extends \Eloquent {}
}

namespace App\Models\Gtfs{
/**
 * App\Models\Gtfs\Stop
 *
 * @property int $id
 * @property int $agency_id
 * @property string $gtfs_stop_id
 * @property string|null $code
 * @property string|null $name
 * @property \MatanYadaev\EloquentSpatial\Objects\Geometry|null $position
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Agency|null $agency
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Gtfs\StopTime> $stopTimes
 * @property-read int|null $stop_times_count
 * @method static \MatanYadaev\EloquentSpatial\SpatialBuilder|Stop newModelQuery()
 * @method static \MatanYadaev\EloquentSpatial\SpatialBuilder|Stop newQuery()
 * @method static \MatanYadaev\EloquentSpatial\SpatialBuilder|Stop orderByDistance(\Illuminate\Contracts\Database\Query\Expression|\MatanYadaev\EloquentSpatial\Objects\Geometry|string $column, \Illuminate\Contracts\Database\Query\Expression|\MatanYadaev\EloquentSpatial\Objects\Geometry|string $geometryOrColumn, string $direction = 'asc')
 * @method static \MatanYadaev\EloquentSpatial\SpatialBuilder|Stop orderByDistanceSphere(\Illuminate\Contracts\Database\Query\Expression|\MatanYadaev\EloquentSpatial\Objects\Geometry|string $column, \Illuminate\Contracts\Database\Query\Expression|\MatanYadaev\EloquentSpatial\Objects\Geometry|string $geometryOrColumn, string $direction = 'asc')
 * @method static \MatanYadaev\EloquentSpatial\SpatialBuilder|Stop query()
 * @method static \MatanYadaev\EloquentSpatial\SpatialBuilder|Stop whereAgencyId($value)
 * @method static \MatanYadaev\EloquentSpatial\SpatialBuilder|Stop whereCode($value)
 * @method static \MatanYadaev\EloquentSpatial\SpatialBuilder|Stop whereContains(\Illuminate\Contracts\Database\Query\Expression|\MatanYadaev\EloquentSpatial\Objects\Geometry|string $column, \Illuminate\Contracts\Database\Query\Expression|\MatanYadaev\EloquentSpatial\Objects\Geometry|string $geometryOrColumn)
 * @method static \MatanYadaev\EloquentSpatial\SpatialBuilder|Stop whereCreatedAt($value)
 * @method static \MatanYadaev\EloquentSpatial\SpatialBuilder|Stop whereCrosses(\Illuminate\Contracts\Database\Query\Expression|\MatanYadaev\EloquentSpatial\Objects\Geometry|string $column, \Illuminate\Contracts\Database\Query\Expression|\MatanYadaev\EloquentSpatial\Objects\Geometry|string $geometryOrColumn)
 * @method static \MatanYadaev\EloquentSpatial\SpatialBuilder|Stop whereDisjoint(\Illuminate\Contracts\Database\Query\Expression|\MatanYadaev\EloquentSpatial\Objects\Geometry|string $column, \Illuminate\Contracts\Database\Query\Expression|\MatanYadaev\EloquentSpatial\Objects\Geometry|string $geometryOrColumn)
 * @method static \MatanYadaev\EloquentSpatial\SpatialBuilder|Stop whereDistance(\Illuminate\Contracts\Database\Query\Expression|\MatanYadaev\EloquentSpatial\Objects\Geometry|string $column, \Illuminate\Contracts\Database\Query\Expression|\MatanYadaev\EloquentSpatial\Objects\Geometry|string $geometryOrColumn, string $operator, int|float $value)
 * @method static \MatanYadaev\EloquentSpatial\SpatialBuilder|Stop whereDistanceSphere(\Illuminate\Contracts\Database\Query\Expression|\MatanYadaev\EloquentSpatial\Objects\Geometry|string $column, \Illuminate\Contracts\Database\Query\Expression|\MatanYadaev\EloquentSpatial\Objects\Geometry|string $geometryOrColumn, string $operator, int|float $value)
 * @method static \MatanYadaev\EloquentSpatial\SpatialBuilder|Stop whereEquals(\Illuminate\Contracts\Database\Query\Expression|\MatanYadaev\EloquentSpatial\Objects\Geometry|string $column, \Illuminate\Contracts\Database\Query\Expression|\MatanYadaev\EloquentSpatial\Objects\Geometry|string $geometryOrColumn)
 * @method static \MatanYadaev\EloquentSpatial\SpatialBuilder|Stop whereGtfsStopId($value)
 * @method static \MatanYadaev\EloquentSpatial\SpatialBuilder|Stop whereId($value)
 * @method static \MatanYadaev\EloquentSpatial\SpatialBuilder|Stop whereIntersects(\Illuminate\Contracts\Database\Query\Expression|\MatanYadaev\EloquentSpatial\Objects\Geometry|string $column, \Illuminate\Contracts\Database\Query\Expression|\MatanYadaev\EloquentSpatial\Objects\Geometry|string $geometryOrColumn)
 * @method static \MatanYadaev\EloquentSpatial\SpatialBuilder|Stop whereName($value)
 * @method static \MatanYadaev\EloquentSpatial\SpatialBuilder|Stop whereNotContains(\Illuminate\Contracts\Database\Query\Expression|\MatanYadaev\EloquentSpatial\Objects\Geometry|string $column, \Illuminate\Contracts\Database\Query\Expression|\MatanYadaev\EloquentSpatial\Objects\Geometry|string $geometryOrColumn)
 * @method static \MatanYadaev\EloquentSpatial\SpatialBuilder|Stop whereNotWithin(\Illuminate\Contracts\Database\Query\Expression|\MatanYadaev\EloquentSpatial\Objects\Geometry|string $column, \Illuminate\Contracts\Database\Query\Expression|\MatanYadaev\EloquentSpatial\Objects\Geometry|string $geometryOrColumn)
 * @method static \MatanYadaev\EloquentSpatial\SpatialBuilder|Stop whereOverlaps(\Illuminate\Contracts\Database\Query\Expression|\MatanYadaev\EloquentSpatial\Objects\Geometry|string $column, \Illuminate\Contracts\Database\Query\Expression|\MatanYadaev\EloquentSpatial\Objects\Geometry|string $geometryOrColumn)
 * @method static \MatanYadaev\EloquentSpatial\SpatialBuilder|Stop wherePosition($value)
 * @method static \MatanYadaev\EloquentSpatial\SpatialBuilder|Stop whereSrid(\Illuminate\Contracts\Database\Query\Expression|\MatanYadaev\EloquentSpatial\Objects\Geometry|string $column, string $operator, int|float $value)
 * @method static \MatanYadaev\EloquentSpatial\SpatialBuilder|Stop whereTouches(\Illuminate\Contracts\Database\Query\Expression|\MatanYadaev\EloquentSpatial\Objects\Geometry|string $column, \Illuminate\Contracts\Database\Query\Expression|\MatanYadaev\EloquentSpatial\Objects\Geometry|string $geometryOrColumn)
 * @method static \MatanYadaev\EloquentSpatial\SpatialBuilder|Stop whereUpdatedAt($value)
 * @method static \MatanYadaev\EloquentSpatial\SpatialBuilder|Stop whereWithin(\Illuminate\Contracts\Database\Query\Expression|\MatanYadaev\EloquentSpatial\Objects\Geometry|string $column, \Illuminate\Contracts\Database\Query\Expression|\MatanYadaev\EloquentSpatial\Objects\Geometry|string $geometryOrColumn)
 * @method static \MatanYadaev\EloquentSpatial\SpatialBuilder|Stop withCentroid(\Illuminate\Contracts\Database\Query\Expression|\MatanYadaev\EloquentSpatial\Objects\Geometry|string $column, string $alias = 'centroid')
 * @method static \MatanYadaev\EloquentSpatial\SpatialBuilder|Stop withDistance(\Illuminate\Contracts\Database\Query\Expression|\MatanYadaev\EloquentSpatial\Objects\Geometry|string $column, \Illuminate\Contracts\Database\Query\Expression|\MatanYadaev\EloquentSpatial\Objects\Geometry|string $geometryOrColumn, string $alias = 'distance')
 * @method static \MatanYadaev\EloquentSpatial\SpatialBuilder|Stop withDistanceSphere(\Illuminate\Contracts\Database\Query\Expression|\MatanYadaev\EloquentSpatial\Objects\Geometry|string $column, \Illuminate\Contracts\Database\Query\Expression|\MatanYadaev\EloquentSpatial\Objects\Geometry|string $geometryOrColumn, string $alias = 'distance')
 */
	class Stop extends \Eloquent {}
}

namespace App\Models\Gtfs{
/**
 * App\Models\Gtfs\StopTime
 *
 * @property int $id
 * @property int $agency_id
 * @property string $gtfs_trip_id
 * @property string $gtfs_stop_id
 * @property string $departure
 * @property int $sequence
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Gtfs\Stop|null $stop
 * @property-read \App\Models\Gtfs\Trip|null $trip
 * @method static \Illuminate\Database\Eloquent\Builder|StopTime newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|StopTime newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|StopTime query()
 * @method static \Illuminate\Database\Eloquent\Builder|StopTime whereAgencyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StopTime whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StopTime whereDeparture($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StopTime whereGtfsStopId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StopTime whereGtfsTripId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StopTime whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StopTime whereSequence($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StopTime whereUpdatedAt($value)
 */
	class StopTime extends \Eloquent {}
}

namespace App\Models\Gtfs{
/**
 * App\Models\Gtfs\Trip
 *
 * @property int $id
 * @property int|null $agency_id
 * @property string $gtfs_trip_id
 * @property string $gtfs_route_id
 * @property string $gtfs_service_id
 * @property string|null $gtfs_block_id
 * @property string|null $gtfs_shape_id
 * @property string|null $headsign
 * @property string|null $short_name
 * @property string|null $expiration
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Agency|null $agency
 * @property-read \App\Models\Gtfs\StopTime|null $firstDeparture
 * @property-read \App\Models\Gtfs\Route|null $route
 * @property-read \App\Models\Gtfs\Service|null $service
 * @property-read \App\Models\Gtfs\Shape|null $shape
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Gtfs\StopTime> $stopTimes
 * @property-read int|null $stop_times_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Vehicle> $vehicles
 * @property-read int|null $vehicles_count
 * @method static \Illuminate\Database\Eloquent\Builder|Trip newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Trip newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Trip query()
 * @method static \Illuminate\Database\Eloquent\Builder|Trip whereAgencyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Trip whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Trip whereExpiration($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Trip whereGtfsBlockId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Trip whereGtfsRouteId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Trip whereGtfsServiceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Trip whereGtfsShapeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Trip whereGtfsTripId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Trip whereHeadsign($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Trip whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Trip whereShortName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Trip whereUpdatedAt($value)
 */
	class Trip extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Link
 *
 * @property int $id
 * @property string $internal_title
 * @property array $title
 * @property array $description
 * @property string $link
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Agency> $agencies
 * @property-read int|null $agencies_count
 * @property-read mixed $translations
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Vehicle> $vehicles
 * @property-read int|null $vehicles_count
 * @method static \Illuminate\Database\Eloquent\Builder|Link newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Link newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Link query()
 * @method static \Illuminate\Database\Eloquent\Builder|Link whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Link whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Link whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Link whereInternalTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Link whereLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Link whereLocale(string $column, string $locale)
 * @method static \Illuminate\Database\Eloquent\Builder|Link whereLocales(string $column, array $locales)
 * @method static \Illuminate\Database\Eloquent\Builder|Link whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Link whereUpdatedAt($value)
 */
	class Link extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\NotificationUser
 *
 * @property int $id
 * @property string $uuid
 * @property bool $is_active
 * @property bool $is_french
 * @property string $endpoint
 * @property string|null $expiration
 * @property bool $subscribed_general_news
 * @property bool $subscribed_electric_stm
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Agency> $agencies
 * @property-read int|null $agencies_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \NotificationChannels\WebPush\PushSubscription> $pushSubscriptions
 * @property-read int|null $push_subscriptions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Vehicle> $vehicles
 * @property-read int|null $vehicles_count
 * @method static \Illuminate\Database\Eloquent\Builder|NotificationUser active()
 * @method static \Illuminate\Database\Eloquent\Builder|NotificationUser newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|NotificationUser newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|NotificationUser query()
 * @method static \Illuminate\Database\Eloquent\Builder|NotificationUser whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NotificationUser whereEndpoint($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NotificationUser whereExpiration($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NotificationUser whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NotificationUser whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NotificationUser whereIsFrench($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NotificationUser whereSubscribedElectricStm($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NotificationUser whereSubscribedGeneralNews($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NotificationUser whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NotificationUser whereUuid($value)
 */
	class NotificationUser extends \Eloquent implements \Illuminate\Contracts\Translation\HasLocalePreference {}
}

namespace App\Models{
/**
 * App\Models\Region
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property array|null $info_title
 * @property array|null $info_body
 * @property array $map_box
 * @property \ArrayObject $map_center
 * @property int $map_zoom
 * @property array $credits
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property array $description
 * @property array|null $meta_description
 * @property string|null $image
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Agency> $activeAgencies
 * @property-read int|null $active_agencies_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Alert> $activeAlerts
 * @property-read int|null $active_alerts_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Agency> $agencies
 * @property-read int|null $agencies_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Alert> $alerts
 * @property-read int|null $alerts_count
 * @property-read array $cities
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Stat> $stats
 * @property-read int|null $stats_count
 * @property-read mixed $translations
 * @method static \Illuminate\Database\Eloquent\Builder|Region newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Region newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Region query()
 * @method static \Illuminate\Database\Eloquent\Builder|Region whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Region whereCredits($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Region whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Region whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Region whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Region whereInfoBody($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Region whereInfoTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Region whereLocale(string $column, string $locale)
 * @method static \Illuminate\Database\Eloquent\Builder|Region whereLocales(string $column, array $locales)
 * @method static \Illuminate\Database\Eloquent\Builder|Region whereMapBox($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Region whereMapCenter($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Region whereMapZoom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Region whereMetaDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Region whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Region whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Region whereUpdatedAt($value)
 */
	class Region extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Stat
 *
 * @property int $id
 * @property string $type
 * @property object $data
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $region_id
 * @property-read \App\Models\Region|null $region
 * @method static \Illuminate\Database\Eloquent\Builder|Stat newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Stat newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Stat query()
 * @method static \Illuminate\Database\Eloquent\Builder|Stat whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Stat whereData($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Stat whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Stat whereRegionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Stat whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Stat whereUpdatedAt($value)
 */
	class Stat extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Tag
 *
 * @property int $id
 * @property array $label
 * @property array|null $short_label
 * @property \BenSampo\Enum\Enum $type
 * @property array|null $description
 * @property string|null $icon
 * @property string $color
 * @property string $dark_color
 * @property string $text_color
 * @property string $dark_text_color
 * @property int $show_on_map
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $slug
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Agency> $agencies
 * @property-read int|null $agencies_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Vehicle> $exoVinVehicles
 * @property-read int|null $exo_vin_vehicles_count
 * @property-read mixed $translations
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Vehicle> $vehicles
 * @property-read int|null $vehicles_count
 * @method static \Illuminate\Database\Eloquent\Builder|Tag newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Tag newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Tag ofType(int $type)
 * @method static \Illuminate\Database\Eloquent\Builder|Tag query()
 * @method static \Illuminate\Database\Eloquent\Builder|Tag whereColor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tag whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tag whereDarkColor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tag whereDarkTextColor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tag whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tag whereIcon($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tag whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tag whereLabel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tag whereLocale(string $column, string $locale)
 * @method static \Illuminate\Database\Eloquent\Builder|Tag whereLocales(string $column, array $locales)
 * @method static \Illuminate\Database\Eloquent\Builder|Tag whereShortLabel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tag whereShowOnMap($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tag whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tag whereTextColor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tag whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tag whereUpdatedAt($value)
 */
	class Tag extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\User
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Ladder\Models\UserRole> $roles
 * @property-read int|null $roles_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 */
	class User extends \Eloquent implements \Filament\Models\Contracts\FilamentUser {}
}

namespace App\Models{
/**
 * App\Models\Vehicle
 *
 * @property int $id
 * @property int|null $agency_id
 * @property string|null $gtfs_trip
 * @property float|null $bearing
 * @property float|null $speed
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $last_seen_at
 * @property string|null $label
 * @property string|null $force_label
 * @property float|null $odometer
 * @property int|null $timestamp
 * @property bool $is_active
 * @property string $vehicle_id
 * @property string|null $gtfs_trip_id
 * @property string|null $gtfs_route_id
 * @property string|null $start_time
 * @property int|null $schedule_relationship
 * @property string|null $license_plate
 * @property \MatanYadaev\EloquentSpatial\Objects\Geometry $position
 * @property int|null $current_stop_sequence
 * @property string|null $gtfs_stop_id
 * @property int|null $current_status
 * @property int|null $congestion_level
 * @property int|null $occupancy_status
 * @property \BenSampo\Enum\Enum|null $vehicle_type
 * @property string|null $force_vehicle_id
 * @property-read \App\Models\Agency|null $agency
 * @property-read string $displayed_label
 * @property-read string $ref
 * @property-read \App\Models\Gtfs\Route|null $gtfsRoute
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Link> $links
 * @property-read int|null $links_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\NotificationUser> $notificationUsers
 * @property-read int|null $notification_users_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Vehicle> $relatedVehicles
 * @property-read int|null $related_vehicles_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Tag> $tags
 * @property-read int|null $tags_count
 * @property-read \App\Models\Gtfs\Trip|null $trip
 * @property-read mixed $vin_information
 * @property-read \App\Models\Vin\Information|null $vinInformationForce
 * @property-read \App\Models\Vin\Information|null $vinInformationOriginal
 * @method static \MatanYadaev\EloquentSpatial\SpatialBuilder|Vehicle active()
 * @method static \MatanYadaev\EloquentSpatial\SpatialBuilder|Vehicle downloadable()
 * @method static \MatanYadaev\EloquentSpatial\SpatialBuilder|Vehicle exo()
 * @method static \MatanYadaev\EloquentSpatial\SpatialBuilder|Vehicle exoWithVin()
 * @method static \MatanYadaev\EloquentSpatial\SpatialBuilder|Vehicle newModelQuery()
 * @method static \MatanYadaev\EloquentSpatial\SpatialBuilder|Vehicle newQuery()
 * @method static \MatanYadaev\EloquentSpatial\SpatialBuilder|Vehicle orderByDistance(\Illuminate\Contracts\Database\Query\Expression|\MatanYadaev\EloquentSpatial\Objects\Geometry|string $column, \Illuminate\Contracts\Database\Query\Expression|\MatanYadaev\EloquentSpatial\Objects\Geometry|string $geometryOrColumn, string $direction = 'asc')
 * @method static \MatanYadaev\EloquentSpatial\SpatialBuilder|Vehicle orderByDistanceSphere(\Illuminate\Contracts\Database\Query\Expression|\MatanYadaev\EloquentSpatial\Objects\Geometry|string $column, \Illuminate\Contracts\Database\Query\Expression|\MatanYadaev\EloquentSpatial\Objects\Geometry|string $geometryOrColumn, string $direction = 'asc')
 * @method static \MatanYadaev\EloquentSpatial\SpatialBuilder|Vehicle query()
 * @method static \MatanYadaev\EloquentSpatial\SpatialBuilder|Vehicle vin()
 * @method static \MatanYadaev\EloquentSpatial\SpatialBuilder|Vehicle whereAgencyId($value)
 * @method static \MatanYadaev\EloquentSpatial\SpatialBuilder|Vehicle whereBearing($value)
 * @method static \MatanYadaev\EloquentSpatial\SpatialBuilder|Vehicle whereCongestionLevel($value)
 * @method static \MatanYadaev\EloquentSpatial\SpatialBuilder|Vehicle whereContains(\Illuminate\Contracts\Database\Query\Expression|\MatanYadaev\EloquentSpatial\Objects\Geometry|string $column, \Illuminate\Contracts\Database\Query\Expression|\MatanYadaev\EloquentSpatial\Objects\Geometry|string $geometryOrColumn)
 * @method static \MatanYadaev\EloquentSpatial\SpatialBuilder|Vehicle whereCreatedAt($value)
 * @method static \MatanYadaev\EloquentSpatial\SpatialBuilder|Vehicle whereCrosses(\Illuminate\Contracts\Database\Query\Expression|\MatanYadaev\EloquentSpatial\Objects\Geometry|string $column, \Illuminate\Contracts\Database\Query\Expression|\MatanYadaev\EloquentSpatial\Objects\Geometry|string $geometryOrColumn)
 * @method static \MatanYadaev\EloquentSpatial\SpatialBuilder|Vehicle whereCurrentStatus($value)
 * @method static \MatanYadaev\EloquentSpatial\SpatialBuilder|Vehicle whereCurrentStopSequence($value)
 * @method static \MatanYadaev\EloquentSpatial\SpatialBuilder|Vehicle whereDisjoint(\Illuminate\Contracts\Database\Query\Expression|\MatanYadaev\EloquentSpatial\Objects\Geometry|string $column, \Illuminate\Contracts\Database\Query\Expression|\MatanYadaev\EloquentSpatial\Objects\Geometry|string $geometryOrColumn)
 * @method static \MatanYadaev\EloquentSpatial\SpatialBuilder|Vehicle whereDistance(\Illuminate\Contracts\Database\Query\Expression|\MatanYadaev\EloquentSpatial\Objects\Geometry|string $column, \Illuminate\Contracts\Database\Query\Expression|\MatanYadaev\EloquentSpatial\Objects\Geometry|string $geometryOrColumn, string $operator, int|float $value)
 * @method static \MatanYadaev\EloquentSpatial\SpatialBuilder|Vehicle whereDistanceSphere(\Illuminate\Contracts\Database\Query\Expression|\MatanYadaev\EloquentSpatial\Objects\Geometry|string $column, \Illuminate\Contracts\Database\Query\Expression|\MatanYadaev\EloquentSpatial\Objects\Geometry|string $geometryOrColumn, string $operator, int|float $value)
 * @method static \MatanYadaev\EloquentSpatial\SpatialBuilder|Vehicle whereEquals(\Illuminate\Contracts\Database\Query\Expression|\MatanYadaev\EloquentSpatial\Objects\Geometry|string $column, \Illuminate\Contracts\Database\Query\Expression|\MatanYadaev\EloquentSpatial\Objects\Geometry|string $geometryOrColumn)
 * @method static \MatanYadaev\EloquentSpatial\SpatialBuilder|Vehicle whereForceLabel($value)
 * @method static \MatanYadaev\EloquentSpatial\SpatialBuilder|Vehicle whereForceVehicleId($value)
 * @method static \MatanYadaev\EloquentSpatial\SpatialBuilder|Vehicle whereGtfsRouteId($value)
 * @method static \MatanYadaev\EloquentSpatial\SpatialBuilder|Vehicle whereGtfsStopId($value)
 * @method static \MatanYadaev\EloquentSpatial\SpatialBuilder|Vehicle whereGtfsTrip($value)
 * @method static \MatanYadaev\EloquentSpatial\SpatialBuilder|Vehicle whereGtfsTripId($value)
 * @method static \MatanYadaev\EloquentSpatial\SpatialBuilder|Vehicle whereId($value)
 * @method static \MatanYadaev\EloquentSpatial\SpatialBuilder|Vehicle whereIntersects(\Illuminate\Contracts\Database\Query\Expression|\MatanYadaev\EloquentSpatial\Objects\Geometry|string $column, \Illuminate\Contracts\Database\Query\Expression|\MatanYadaev\EloquentSpatial\Objects\Geometry|string $geometryOrColumn)
 * @method static \MatanYadaev\EloquentSpatial\SpatialBuilder|Vehicle whereIsActive($value)
 * @method static \MatanYadaev\EloquentSpatial\SpatialBuilder|Vehicle whereLabel($value)
 * @method static \MatanYadaev\EloquentSpatial\SpatialBuilder|Vehicle whereLastSeenAt($value)
 * @method static \MatanYadaev\EloquentSpatial\SpatialBuilder|Vehicle whereLicensePlate($value)
 * @method static \MatanYadaev\EloquentSpatial\SpatialBuilder|Vehicle whereNotContains(\Illuminate\Contracts\Database\Query\Expression|\MatanYadaev\EloquentSpatial\Objects\Geometry|string $column, \Illuminate\Contracts\Database\Query\Expression|\MatanYadaev\EloquentSpatial\Objects\Geometry|string $geometryOrColumn)
 * @method static \MatanYadaev\EloquentSpatial\SpatialBuilder|Vehicle whereNotWithin(\Illuminate\Contracts\Database\Query\Expression|\MatanYadaev\EloquentSpatial\Objects\Geometry|string $column, \Illuminate\Contracts\Database\Query\Expression|\MatanYadaev\EloquentSpatial\Objects\Geometry|string $geometryOrColumn)
 * @method static \MatanYadaev\EloquentSpatial\SpatialBuilder|Vehicle whereOccupancyStatus($value)
 * @method static \MatanYadaev\EloquentSpatial\SpatialBuilder|Vehicle whereOdometer($value)
 * @method static \MatanYadaev\EloquentSpatial\SpatialBuilder|Vehicle whereOverlaps(\Illuminate\Contracts\Database\Query\Expression|\MatanYadaev\EloquentSpatial\Objects\Geometry|string $column, \Illuminate\Contracts\Database\Query\Expression|\MatanYadaev\EloquentSpatial\Objects\Geometry|string $geometryOrColumn)
 * @method static \MatanYadaev\EloquentSpatial\SpatialBuilder|Vehicle wherePosition($value)
 * @method static \MatanYadaev\EloquentSpatial\SpatialBuilder|Vehicle whereScheduleRelationship($value)
 * @method static \MatanYadaev\EloquentSpatial\SpatialBuilder|Vehicle whereSpeed($value)
 * @method static \MatanYadaev\EloquentSpatial\SpatialBuilder|Vehicle whereSrid(\Illuminate\Contracts\Database\Query\Expression|\MatanYadaev\EloquentSpatial\Objects\Geometry|string $column, string $operator, int|float $value)
 * @method static \MatanYadaev\EloquentSpatial\SpatialBuilder|Vehicle whereStartTime($value)
 * @method static \MatanYadaev\EloquentSpatial\SpatialBuilder|Vehicle whereTimestamp($value)
 * @method static \MatanYadaev\EloquentSpatial\SpatialBuilder|Vehicle whereTouches(\Illuminate\Contracts\Database\Query\Expression|\MatanYadaev\EloquentSpatial\Objects\Geometry|string $column, \Illuminate\Contracts\Database\Query\Expression|\MatanYadaev\EloquentSpatial\Objects\Geometry|string $geometryOrColumn)
 * @method static \MatanYadaev\EloquentSpatial\SpatialBuilder|Vehicle whereUpdatedAt($value)
 * @method static \MatanYadaev\EloquentSpatial\SpatialBuilder|Vehicle whereVehicleId($value)
 * @method static \MatanYadaev\EloquentSpatial\SpatialBuilder|Vehicle whereVehicleType($value)
 * @method static \MatanYadaev\EloquentSpatial\SpatialBuilder|Vehicle whereWithin(\Illuminate\Contracts\Database\Query\Expression|\MatanYadaev\EloquentSpatial\Objects\Geometry|string $column, \Illuminate\Contracts\Database\Query\Expression|\MatanYadaev\EloquentSpatial\Objects\Geometry|string $geometryOrColumn)
 * @method static \MatanYadaev\EloquentSpatial\SpatialBuilder|Vehicle withCentroid(\Illuminate\Contracts\Database\Query\Expression|\MatanYadaev\EloquentSpatial\Objects\Geometry|string $column, string $alias = 'centroid')
 * @method static \MatanYadaev\EloquentSpatial\SpatialBuilder|Vehicle withDistance(\Illuminate\Contracts\Database\Query\Expression|\MatanYadaev\EloquentSpatial\Objects\Geometry|string $column, \Illuminate\Contracts\Database\Query\Expression|\MatanYadaev\EloquentSpatial\Objects\Geometry|string $geometryOrColumn, string $alias = 'distance')
 * @method static \MatanYadaev\EloquentSpatial\SpatialBuilder|Vehicle withDistanceSphere(\Illuminate\Contracts\Database\Query\Expression|\MatanYadaev\EloquentSpatial\Objects\Geometry|string $column, \Illuminate\Contracts\Database\Query\Expression|\MatanYadaev\EloquentSpatial\Objects\Geometry|string $geometryOrColumn, string $alias = 'distance')
 * @method static \MatanYadaev\EloquentSpatial\SpatialBuilder|Vehicle withoutTouch()
 * @method static \MatanYadaev\EloquentSpatial\SpatialBuilder|Vehicle withoutTypeOfTags(int $type)
 */
	class Vehicle extends \Eloquent {}
}

namespace App\Models\Vin{
/**
 * App\Models\Vin\Information
 *
 * @property string $vin
 * @property string $make
 * @property string $model
 * @property int $year
 * @property int|null $length
 * @property string|null $engine
 * @property string|null $assembly
 * @property string|null $fuel
 * @property string|null $sequence
 * @property \Illuminate\Support\Collection|null $others
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Vehicle> $vehicles
 * @property-read int|null $vehicles_count
 * @method static \Illuminate\Database\Eloquent\Builder|Information newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Information newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Information query()
 * @method static \Illuminate\Database\Eloquent\Builder|Information whereAssembly($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Information whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Information whereEngine($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Information whereFuel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Information whereLength($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Information whereMake($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Information whereModel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Information whereOthers($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Information whereSequence($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Information whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Information whereVin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Information whereYear($value)
 */
	class Information extends \Eloquent {}
}

namespace App\Models\Vin{
/**
 * App\Models\Vin\Suggestion
 *
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Vehicle> $vehicles
 * @property-read int|null $vehicles_count
 * @method static \Illuminate\Database\Eloquent\Builder|Suggestion newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Suggestion newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Suggestion query()
 */
	class Suggestion extends \Eloquent {}
}

