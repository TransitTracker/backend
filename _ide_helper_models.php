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
 * 
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
 * @property array<array-key, mixed>|null $license
 * @property bool $refresh_is_active
 * @property string|null $short_name
 * @property string $cron_schedule
 * @property array<array-key, mixed>|null $cities
 * @property string|null $static_etag
 * @property array<array-key, mixed>|null $headers
 * @property string|null $name_slug
 * @property string|null $area_path
 * @property bool $is_exo_sector
 * @property \Illuminate\Support\Collection<array-key, mixed>|null $features
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
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Agency active()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Agency exo()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Agency newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Agency newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Agency query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Agency whereAreaPath($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Agency whereCities($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Agency whereColor($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Agency whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Agency whereCronSchedule($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Agency whereExoOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Agency whereFeatures($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Agency whereHeaders($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Agency whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Agency whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Agency whereIsArchived($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Agency whereIsExoSector($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Agency whereLicense($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Agency whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Agency whereNameSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Agency whereRealtimeType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Agency whereRealtimeUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Agency whereRefreshIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Agency whereShortName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Agency whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Agency whereStaticEtag($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Agency whereStaticGtfsUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Agency whereTags($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Agency whereTextColor($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Agency whereTimestamp($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Agency whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Agency whereVehiclesType($value)
 */
	class Agency extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property bool $is_active
 * @property string|null $icon
 * @property string $color
 * @property bool $can_be_closed
 * @property array<array-key, mixed>|null $title
 * @property array<array-key, mixed> $subtitle
 * @property array<array-key, mixed>|null $body
 * @property string|null $action
 * @property \ArrayObject<array-key, mixed>|null $action_parameters
 * @property string|null $expiration
 * @property string|null $image
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Region> $regions
 * @property-read int|null $regions_count
 * @property-read mixed $translations
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Alert active()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Alert newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Alert newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Alert query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Alert whereAction($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Alert whereActionParameters($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Alert whereBody($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Alert whereCanBeClosed($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Alert whereColor($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Alert whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Alert whereExpiration($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Alert whereIcon($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Alert whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Alert whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Alert whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Alert whereJsonContainsLocale(string $column, string $locale, ?mixed $value, string $operand = '=')
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Alert whereJsonContainsLocales(string $column, array $locales, ?mixed $value, string $operand = '=')
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Alert whereLocale(string $column, string $locale)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Alert whereLocales(string $column, array $locales)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Alert whereSubtitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Alert whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Alert whereUpdatedAt($value)
 */
	class Alert extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $name
 * @property int|null $agency_id
 * @property string $exception
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $snooze
 * @property-read \App\Models\Agency|null $agency
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FailedJob newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FailedJob newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FailedJob query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FailedJob whereAgencyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FailedJob whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FailedJob whereException($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FailedJob whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FailedJob whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FailedJob whereSnooze($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FailedJob whereUpdatedAt($value)
 */
	class FailedJob extends \Eloquent {}
}

namespace App\Models\Gtfs{
/**
 * 
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
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Route newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Route newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Route query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Route whereAgencyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Route whereColor($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Route whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Route whereGtfsRouteId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Route whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Route whereLongName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Route whereShortName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Route whereTextColor($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Route whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Route whereUpdatedAt($value)
 */
	class Route extends \Eloquent {}
}

namespace App\Models\Gtfs{
/**
 * 
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
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Service newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Service newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Service query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Service whereAgencyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Service whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Service whereEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Service whereFriday($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Service whereGtfsServiceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Service whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Service whereMonday($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Service whereSaturday($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Service whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Service whereSunday($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Service whereThursday($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Service whereTuesday($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Service whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Service whereWednesday($value)
 */
	class Service extends \Eloquent {}
}

namespace App\Models\Gtfs{
/**
 * 
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
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Shape newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Shape newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Shape orderByDistance(\Illuminate\Contracts\Database\Query\Expression|\MatanYadaev\EloquentSpatial\Objects\Geometry|string $column, \Illuminate\Contracts\Database\Query\Expression|\MatanYadaev\EloquentSpatial\Objects\Geometry|string $geometryOrColumn, string $direction = 'asc')
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Shape orderByDistanceSphere(\Illuminate\Contracts\Database\Query\Expression|\MatanYadaev\EloquentSpatial\Objects\Geometry|string $column, \Illuminate\Contracts\Database\Query\Expression|\MatanYadaev\EloquentSpatial\Objects\Geometry|string $geometryOrColumn, string $direction = 'asc')
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Shape query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Shape whereAgencyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Shape whereContains(\Illuminate\Contracts\Database\Query\Expression|\MatanYadaev\EloquentSpatial\Objects\Geometry|string $column, \Illuminate\Contracts\Database\Query\Expression|\MatanYadaev\EloquentSpatial\Objects\Geometry|string $geometryOrColumn)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Shape whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Shape whereCrosses(\Illuminate\Contracts\Database\Query\Expression|\MatanYadaev\EloquentSpatial\Objects\Geometry|string $column, \Illuminate\Contracts\Database\Query\Expression|\MatanYadaev\EloquentSpatial\Objects\Geometry|string $geometryOrColumn)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Shape whereDisjoint(\Illuminate\Contracts\Database\Query\Expression|\MatanYadaev\EloquentSpatial\Objects\Geometry|string $column, \Illuminate\Contracts\Database\Query\Expression|\MatanYadaev\EloquentSpatial\Objects\Geometry|string $geometryOrColumn)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Shape whereDistance(\Illuminate\Contracts\Database\Query\Expression|\MatanYadaev\EloquentSpatial\Objects\Geometry|string $column, \Illuminate\Contracts\Database\Query\Expression|\MatanYadaev\EloquentSpatial\Objects\Geometry|string $geometryOrColumn, string $operator, int|float $value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Shape whereDistanceSphere(\Illuminate\Contracts\Database\Query\Expression|\MatanYadaev\EloquentSpatial\Objects\Geometry|string $column, \Illuminate\Contracts\Database\Query\Expression|\MatanYadaev\EloquentSpatial\Objects\Geometry|string $geometryOrColumn, string $operator, int|float $value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Shape whereEquals(\Illuminate\Contracts\Database\Query\Expression|\MatanYadaev\EloquentSpatial\Objects\Geometry|string $column, \Illuminate\Contracts\Database\Query\Expression|\MatanYadaev\EloquentSpatial\Objects\Geometry|string $geometryOrColumn)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Shape whereGtfsShapeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Shape whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Shape whereIntersects(\Illuminate\Contracts\Database\Query\Expression|\MatanYadaev\EloquentSpatial\Objects\Geometry|string $column, \Illuminate\Contracts\Database\Query\Expression|\MatanYadaev\EloquentSpatial\Objects\Geometry|string $geometryOrColumn)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Shape whereNotContains(\Illuminate\Contracts\Database\Query\Expression|\MatanYadaev\EloquentSpatial\Objects\Geometry|string $column, \Illuminate\Contracts\Database\Query\Expression|\MatanYadaev\EloquentSpatial\Objects\Geometry|string $geometryOrColumn)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Shape whereNotWithin(\Illuminate\Contracts\Database\Query\Expression|\MatanYadaev\EloquentSpatial\Objects\Geometry|string $column, \Illuminate\Contracts\Database\Query\Expression|\MatanYadaev\EloquentSpatial\Objects\Geometry|string $geometryOrColumn)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Shape whereOverlaps(\Illuminate\Contracts\Database\Query\Expression|\MatanYadaev\EloquentSpatial\Objects\Geometry|string $column, \Illuminate\Contracts\Database\Query\Expression|\MatanYadaev\EloquentSpatial\Objects\Geometry|string $geometryOrColumn)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Shape whereShape($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Shape whereSrid(\Illuminate\Contracts\Database\Query\Expression|\MatanYadaev\EloquentSpatial\Objects\Geometry|string $column, string $operator, int|float $value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Shape whereTotalDistance($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Shape whereTouches(\Illuminate\Contracts\Database\Query\Expression|\MatanYadaev\EloquentSpatial\Objects\Geometry|string $column, \Illuminate\Contracts\Database\Query\Expression|\MatanYadaev\EloquentSpatial\Objects\Geometry|string $geometryOrColumn)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Shape whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Shape whereWithin(\Illuminate\Contracts\Database\Query\Expression|\MatanYadaev\EloquentSpatial\Objects\Geometry|string $column, \Illuminate\Contracts\Database\Query\Expression|\MatanYadaev\EloquentSpatial\Objects\Geometry|string $geometryOrColumn)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Shape withCentroid(\Illuminate\Contracts\Database\Query\Expression|\MatanYadaev\EloquentSpatial\Objects\Geometry|string $column, string $alias = 'centroid')
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Shape withDistance(\Illuminate\Contracts\Database\Query\Expression|\MatanYadaev\EloquentSpatial\Objects\Geometry|string $column, \Illuminate\Contracts\Database\Query\Expression|\MatanYadaev\EloquentSpatial\Objects\Geometry|string $geometryOrColumn, string $alias = 'distance')
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Shape withDistanceSphere(\Illuminate\Contracts\Database\Query\Expression|\MatanYadaev\EloquentSpatial\Objects\Geometry|string $column, \Illuminate\Contracts\Database\Query\Expression|\MatanYadaev\EloquentSpatial\Objects\Geometry|string $geometryOrColumn, string $alias = 'distance')
 */
	class Shape extends \Eloquent {}
}

namespace App\Models\Gtfs{
/**
 * 
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
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Stop newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Stop newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Stop orderByDistance(\Illuminate\Contracts\Database\Query\Expression|\MatanYadaev\EloquentSpatial\Objects\Geometry|string $column, \Illuminate\Contracts\Database\Query\Expression|\MatanYadaev\EloquentSpatial\Objects\Geometry|string $geometryOrColumn, string $direction = 'asc')
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Stop orderByDistanceSphere(\Illuminate\Contracts\Database\Query\Expression|\MatanYadaev\EloquentSpatial\Objects\Geometry|string $column, \Illuminate\Contracts\Database\Query\Expression|\MatanYadaev\EloquentSpatial\Objects\Geometry|string $geometryOrColumn, string $direction = 'asc')
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Stop query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Stop whereAgencyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Stop whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Stop whereContains(\Illuminate\Contracts\Database\Query\Expression|\MatanYadaev\EloquentSpatial\Objects\Geometry|string $column, \Illuminate\Contracts\Database\Query\Expression|\MatanYadaev\EloquentSpatial\Objects\Geometry|string $geometryOrColumn)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Stop whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Stop whereCrosses(\Illuminate\Contracts\Database\Query\Expression|\MatanYadaev\EloquentSpatial\Objects\Geometry|string $column, \Illuminate\Contracts\Database\Query\Expression|\MatanYadaev\EloquentSpatial\Objects\Geometry|string $geometryOrColumn)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Stop whereDisjoint(\Illuminate\Contracts\Database\Query\Expression|\MatanYadaev\EloquentSpatial\Objects\Geometry|string $column, \Illuminate\Contracts\Database\Query\Expression|\MatanYadaev\EloquentSpatial\Objects\Geometry|string $geometryOrColumn)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Stop whereDistance(\Illuminate\Contracts\Database\Query\Expression|\MatanYadaev\EloquentSpatial\Objects\Geometry|string $column, \Illuminate\Contracts\Database\Query\Expression|\MatanYadaev\EloquentSpatial\Objects\Geometry|string $geometryOrColumn, string $operator, int|float $value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Stop whereDistanceSphere(\Illuminate\Contracts\Database\Query\Expression|\MatanYadaev\EloquentSpatial\Objects\Geometry|string $column, \Illuminate\Contracts\Database\Query\Expression|\MatanYadaev\EloquentSpatial\Objects\Geometry|string $geometryOrColumn, string $operator, int|float $value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Stop whereEquals(\Illuminate\Contracts\Database\Query\Expression|\MatanYadaev\EloquentSpatial\Objects\Geometry|string $column, \Illuminate\Contracts\Database\Query\Expression|\MatanYadaev\EloquentSpatial\Objects\Geometry|string $geometryOrColumn)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Stop whereGtfsStopId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Stop whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Stop whereIntersects(\Illuminate\Contracts\Database\Query\Expression|\MatanYadaev\EloquentSpatial\Objects\Geometry|string $column, \Illuminate\Contracts\Database\Query\Expression|\MatanYadaev\EloquentSpatial\Objects\Geometry|string $geometryOrColumn)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Stop whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Stop whereNotContains(\Illuminate\Contracts\Database\Query\Expression|\MatanYadaev\EloquentSpatial\Objects\Geometry|string $column, \Illuminate\Contracts\Database\Query\Expression|\MatanYadaev\EloquentSpatial\Objects\Geometry|string $geometryOrColumn)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Stop whereNotWithin(\Illuminate\Contracts\Database\Query\Expression|\MatanYadaev\EloquentSpatial\Objects\Geometry|string $column, \Illuminate\Contracts\Database\Query\Expression|\MatanYadaev\EloquentSpatial\Objects\Geometry|string $geometryOrColumn)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Stop whereOverlaps(\Illuminate\Contracts\Database\Query\Expression|\MatanYadaev\EloquentSpatial\Objects\Geometry|string $column, \Illuminate\Contracts\Database\Query\Expression|\MatanYadaev\EloquentSpatial\Objects\Geometry|string $geometryOrColumn)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Stop wherePosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Stop whereSrid(\Illuminate\Contracts\Database\Query\Expression|\MatanYadaev\EloquentSpatial\Objects\Geometry|string $column, string $operator, int|float $value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Stop whereTouches(\Illuminate\Contracts\Database\Query\Expression|\MatanYadaev\EloquentSpatial\Objects\Geometry|string $column, \Illuminate\Contracts\Database\Query\Expression|\MatanYadaev\EloquentSpatial\Objects\Geometry|string $geometryOrColumn)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Stop whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Stop whereWithin(\Illuminate\Contracts\Database\Query\Expression|\MatanYadaev\EloquentSpatial\Objects\Geometry|string $column, \Illuminate\Contracts\Database\Query\Expression|\MatanYadaev\EloquentSpatial\Objects\Geometry|string $geometryOrColumn)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Stop withCentroid(\Illuminate\Contracts\Database\Query\Expression|\MatanYadaev\EloquentSpatial\Objects\Geometry|string $column, string $alias = 'centroid')
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Stop withDistance(\Illuminate\Contracts\Database\Query\Expression|\MatanYadaev\EloquentSpatial\Objects\Geometry|string $column, \Illuminate\Contracts\Database\Query\Expression|\MatanYadaev\EloquentSpatial\Objects\Geometry|string $geometryOrColumn, string $alias = 'distance')
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Stop withDistanceSphere(\Illuminate\Contracts\Database\Query\Expression|\MatanYadaev\EloquentSpatial\Objects\Geometry|string $column, \Illuminate\Contracts\Database\Query\Expression|\MatanYadaev\EloquentSpatial\Objects\Geometry|string $geometryOrColumn, string $alias = 'distance')
 */
	class Stop extends \Eloquent {}
}

namespace App\Models\Gtfs{
/**
 * 
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
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StopTime newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StopTime newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StopTime query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StopTime whereAgencyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StopTime whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StopTime whereDeparture($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StopTime whereGtfsStopId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StopTime whereGtfsTripId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StopTime whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StopTime whereSequence($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StopTime whereUpdatedAt($value)
 */
	class StopTime extends \Eloquent {}
}

namespace App\Models\Gtfs{
/**
 * 
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
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Trip newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Trip newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Trip query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Trip whereAgencyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Trip whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Trip whereExpiration($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Trip whereGtfsBlockId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Trip whereGtfsRouteId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Trip whereGtfsServiceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Trip whereGtfsShapeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Trip whereGtfsTripId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Trip whereHeadsign($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Trip whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Trip whereShortName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Trip whereUpdatedAt($value)
 */
	class Trip extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $internal_title
 * @property array<array-key, mixed> $title
 * @property array<array-key, mixed> $description
 * @property string $link
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $is_active
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Agency> $agencies
 * @property-read int|null $agencies_count
 * @property-read mixed $translations
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Vehicle> $vehicles
 * @property-read int|null $vehicles_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Link active()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Link newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Link newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Link query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Link whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Link whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Link whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Link whereInternalTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Link whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Link whereJsonContainsLocale(string $column, string $locale, ?mixed $value, string $operand = '=')
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Link whereJsonContainsLocales(string $column, array $locales, ?mixed $value, string $operand = '=')
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Link whereLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Link whereLocale(string $column, string $locale)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Link whereLocales(string $column, array $locales)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Link whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Link whereUpdatedAt($value)
 */
	class Link extends \Eloquent {}
}

namespace App\Models{
/**
 * 
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
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotificationUser active()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotificationUser newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotificationUser newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotificationUser query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotificationUser whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotificationUser whereEndpoint($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotificationUser whereExpiration($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotificationUser whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotificationUser whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotificationUser whereIsFrench($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotificationUser whereSubscribedElectricStm($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotificationUser whereSubscribedGeneralNews($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotificationUser whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotificationUser whereUuid($value)
 */
	class NotificationUser extends \Eloquent implements \Illuminate\Contracts\Translation\HasLocalePreference {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property array<array-key, mixed>|null $info_title
 * @property array<array-key, mixed>|null $info_body
 * @property array<array-key, mixed> $map_box
 * @property \ArrayObject<array-key, mixed> $map_center
 * @property int $map_zoom
 * @property array<array-key, mixed> $credits
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property array<array-key, mixed> $description
 * @property array<array-key, mixed>|null $meta_description
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
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Region newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Region newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Region query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Region whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Region whereCredits($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Region whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Region whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Region whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Region whereInfoBody($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Region whereInfoTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Region whereJsonContainsLocale(string $column, string $locale, ?mixed $value, string $operand = '=')
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Region whereJsonContainsLocales(string $column, array $locales, ?mixed $value, string $operand = '=')
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Region whereLocale(string $column, string $locale)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Region whereLocales(string $column, array $locales)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Region whereMapBox($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Region whereMapCenter($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Region whereMapZoom($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Region whereMetaDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Region whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Region whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Region whereUpdatedAt($value)
 */
	class Region extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $type
 * @property object $data
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $region_id
 * @property-read \App\Models\Region|null $region
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Stat newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Stat newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Stat query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Stat whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Stat whereData($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Stat whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Stat whereRegionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Stat whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Stat whereUpdatedAt($value)
 */
	class Stat extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property array<array-key, mixed> $label
 * @property array<array-key, mixed>|null $short_label
 * @property \BenSampo\Enum\Enum $type
 * @property array<array-key, mixed>|null $description
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
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tag newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tag newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tag ofType(int $type)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tag query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tag whereColor($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tag whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tag whereDarkColor($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tag whereDarkTextColor($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tag whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tag whereIcon($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tag whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tag whereJsonContainsLocale(string $column, string $locale, ?mixed $value, string $operand = '=')
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tag whereJsonContainsLocales(string $column, array $locales, ?mixed $value, string $operand = '=')
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tag whereLabel($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tag whereLocale(string $column, string $locale)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tag whereLocales(string $column, array $locales)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tag whereShortLabel($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tag whereShowOnMap($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tag whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tag whereTextColor($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tag whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tag whereUpdatedAt($value)
 */
	class Tag extends \Eloquent {}
}

namespace App\Models{
/**
 * 
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
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUpdatedAt($value)
 */
	class User extends \Eloquent implements \Filament\Models\Contracts\FilamentUser {}
}

namespace App\Models{
/**
 * 
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
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Link> $activeLinks
 * @property-read int|null $active_links_count
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
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vehicle active()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vehicle downloadable()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vehicle exo()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vehicle exoWithVin()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vehicle newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vehicle newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vehicle orderByDistance(\Illuminate\Contracts\Database\Query\Expression|\MatanYadaev\EloquentSpatial\Objects\Geometry|string $column, \Illuminate\Contracts\Database\Query\Expression|\MatanYadaev\EloquentSpatial\Objects\Geometry|string $geometryOrColumn, string $direction = 'asc')
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vehicle orderByDistanceSphere(\Illuminate\Contracts\Database\Query\Expression|\MatanYadaev\EloquentSpatial\Objects\Geometry|string $column, \Illuminate\Contracts\Database\Query\Expression|\MatanYadaev\EloquentSpatial\Objects\Geometry|string $geometryOrColumn, string $direction = 'asc')
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vehicle query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vehicle vin()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vehicle whereAgencyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vehicle whereBearing($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vehicle whereCongestionLevel($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vehicle whereContains(\Illuminate\Contracts\Database\Query\Expression|\MatanYadaev\EloquentSpatial\Objects\Geometry|string $column, \Illuminate\Contracts\Database\Query\Expression|\MatanYadaev\EloquentSpatial\Objects\Geometry|string $geometryOrColumn)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vehicle whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vehicle whereCrosses(\Illuminate\Contracts\Database\Query\Expression|\MatanYadaev\EloquentSpatial\Objects\Geometry|string $column, \Illuminate\Contracts\Database\Query\Expression|\MatanYadaev\EloquentSpatial\Objects\Geometry|string $geometryOrColumn)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vehicle whereCurrentStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vehicle whereCurrentStopSequence($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vehicle whereDisjoint(\Illuminate\Contracts\Database\Query\Expression|\MatanYadaev\EloquentSpatial\Objects\Geometry|string $column, \Illuminate\Contracts\Database\Query\Expression|\MatanYadaev\EloquentSpatial\Objects\Geometry|string $geometryOrColumn)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vehicle whereDistance(\Illuminate\Contracts\Database\Query\Expression|\MatanYadaev\EloquentSpatial\Objects\Geometry|string $column, \Illuminate\Contracts\Database\Query\Expression|\MatanYadaev\EloquentSpatial\Objects\Geometry|string $geometryOrColumn, string $operator, int|float $value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vehicle whereDistanceSphere(\Illuminate\Contracts\Database\Query\Expression|\MatanYadaev\EloquentSpatial\Objects\Geometry|string $column, \Illuminate\Contracts\Database\Query\Expression|\MatanYadaev\EloquentSpatial\Objects\Geometry|string $geometryOrColumn, string $operator, int|float $value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vehicle whereEquals(\Illuminate\Contracts\Database\Query\Expression|\MatanYadaev\EloquentSpatial\Objects\Geometry|string $column, \Illuminate\Contracts\Database\Query\Expression|\MatanYadaev\EloquentSpatial\Objects\Geometry|string $geometryOrColumn)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vehicle whereForceLabel($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vehicle whereForceVehicleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vehicle whereGtfsRouteId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vehicle whereGtfsStopId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vehicle whereGtfsTrip($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vehicle whereGtfsTripId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vehicle whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vehicle whereIntersects(\Illuminate\Contracts\Database\Query\Expression|\MatanYadaev\EloquentSpatial\Objects\Geometry|string $column, \Illuminate\Contracts\Database\Query\Expression|\MatanYadaev\EloquentSpatial\Objects\Geometry|string $geometryOrColumn)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vehicle whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vehicle whereLabel($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vehicle whereLastSeenAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vehicle whereLicensePlate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vehicle whereNotContains(\Illuminate\Contracts\Database\Query\Expression|\MatanYadaev\EloquentSpatial\Objects\Geometry|string $column, \Illuminate\Contracts\Database\Query\Expression|\MatanYadaev\EloquentSpatial\Objects\Geometry|string $geometryOrColumn)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vehicle whereNotWithin(\Illuminate\Contracts\Database\Query\Expression|\MatanYadaev\EloquentSpatial\Objects\Geometry|string $column, \Illuminate\Contracts\Database\Query\Expression|\MatanYadaev\EloquentSpatial\Objects\Geometry|string $geometryOrColumn)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vehicle whereOccupancyStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vehicle whereOdometer($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vehicle whereOverlaps(\Illuminate\Contracts\Database\Query\Expression|\MatanYadaev\EloquentSpatial\Objects\Geometry|string $column, \Illuminate\Contracts\Database\Query\Expression|\MatanYadaev\EloquentSpatial\Objects\Geometry|string $geometryOrColumn)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vehicle wherePosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vehicle whereScheduleRelationship($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vehicle whereSpeed($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vehicle whereSrid(\Illuminate\Contracts\Database\Query\Expression|\MatanYadaev\EloquentSpatial\Objects\Geometry|string $column, string $operator, int|float $value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vehicle whereStartTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vehicle whereTimestamp($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vehicle whereTouches(\Illuminate\Contracts\Database\Query\Expression|\MatanYadaev\EloquentSpatial\Objects\Geometry|string $column, \Illuminate\Contracts\Database\Query\Expression|\MatanYadaev\EloquentSpatial\Objects\Geometry|string $geometryOrColumn)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vehicle whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vehicle whereVehicleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vehicle whereVehicleType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vehicle whereWithin(\Illuminate\Contracts\Database\Query\Expression|\MatanYadaev\EloquentSpatial\Objects\Geometry|string $column, \Illuminate\Contracts\Database\Query\Expression|\MatanYadaev\EloquentSpatial\Objects\Geometry|string $geometryOrColumn)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vehicle withCentroid(\Illuminate\Contracts\Database\Query\Expression|\MatanYadaev\EloquentSpatial\Objects\Geometry|string $column, string $alias = 'centroid')
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vehicle withDistance(\Illuminate\Contracts\Database\Query\Expression|\MatanYadaev\EloquentSpatial\Objects\Geometry|string $column, \Illuminate\Contracts\Database\Query\Expression|\MatanYadaev\EloquentSpatial\Objects\Geometry|string $geometryOrColumn, string $alias = 'distance')
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vehicle withDistanceSphere(\Illuminate\Contracts\Database\Query\Expression|\MatanYadaev\EloquentSpatial\Objects\Geometry|string $column, \Illuminate\Contracts\Database\Query\Expression|\MatanYadaev\EloquentSpatial\Objects\Geometry|string $geometryOrColumn, string $alias = 'distance')
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vehicle withoutTouch()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vehicle withoutTypeOfTags(int $type)
 */
	class Vehicle extends \Eloquent {}
}

namespace App\Models\Vin{
/**
 * 
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
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Information newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Information newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Information query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Information whereAssembly($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Information whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Information whereEngine($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Information whereFuel($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Information whereLength($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Information whereMake($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Information whereModel($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Information whereOthers($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Information whereSequence($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Information whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Information whereVin($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Information whereYear($value)
 */
	class Information extends \Eloquent {}
}

namespace App\Models\Vin{
/**
 * 
 *
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Vehicle> $vehicles
 * @property-read int|null $vehicles_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Suggestion newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Suggestion newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Suggestion query()
 */
	class Suggestion extends \Eloquent {}
}

