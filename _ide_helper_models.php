<?php

// @formatter:off
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */

namespace App{
    /**
     * App\Alert.
     *
     * @property int $id
     * @property \Illuminate\Support\Carbon|null $created_at
     * @property \Illuminate\Support\Carbon|null $updated_at
     * @property int $is_active
     * @property string|null $icon
     * @property string $color
     * @property int $can_be_closed
     * @property array|null $title
     * @property array|null $body
     * @property-read array $translations
     * @property-read \Illuminate\Database\Eloquent\Collection|\App\Region[] $regions
     * @property-read int|null $regions_count
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Alert newModelQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Alert newQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Alert query()
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Alert whereBody($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Alert whereCanBeClosed($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Alert whereColor($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Alert whereCreatedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Alert whereIcon($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Alert whereId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Alert whereIsActive($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Alert whereTitle($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Alert whereUpdatedAt($value)
     */
    class Alert extends \Eloquent
    {
    }
}

namespace App{
    /**
     * App\Route.
     *
     * @property int $id
     * @property string $agency_id
     * @property string $route_id
     * @property string $short_name
     * @property string $long_name
     * @property string $color
     * @property string $text_color
     * @property \Illuminate\Support\Carbon|null $created_at
     * @property \Illuminate\Support\Carbon|null $updated_at
     * @property-read \App\Agency $agency
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Route newModelQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Route newQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Route query()
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Route whereAgencyId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Route whereColor($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Route whereCreatedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Route whereId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Route whereLongName($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Route whereRouteId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Route whereShortName($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Route whereTextColor($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Route whereUpdatedAt($value)
     */
    class Route extends \Eloquent
    {
    }
}

namespace App{
    /**
     * App\Trip.
     *
     * @property int $id
     * @property int|null $agency_id
     * @property string $trip_id
     * @property string $trip_headsign
     * @property string|null $trip_short_name
     * @property string|null $route_color
     * @property string|null $route_text_color
     * @property string|null $route_short_name
     * @property string|null $route_long_name
     * @property string $expiration
     * @property \Illuminate\Support\Carbon|null $created_at
     * @property \Illuminate\Support\Carbon|null $updated_at
     * @property int|null $service_id
     * @property-read \App\Agency|null $agency
     * @property-read \App\Service|null $service
     * @property-read \Illuminate\Database\Eloquent\Collection|\App\Vehicle[] $vehicles
     * @property-read int|null $vehicles_count
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Trip newModelQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Trip newQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Trip query()
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Trip whereAgencyId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Trip whereCreatedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Trip whereExpiration($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Trip whereId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Trip whereRouteColor($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Trip whereRouteLongName($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Trip whereRouteShortName($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Trip whereRouteTextColor($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Trip whereServiceId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Trip whereTripHeadsign($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Trip whereTripId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Trip whereTripShortName($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Trip whereUpdatedAt($value)
     */
    class Trip extends \Eloquent
    {
    }
}

namespace App{
    /**
     * App\Agency.
     *
     * @property int $id
     * @property string $name
     * @property string $color
     * @property string $vehicles_type
     * @property string $slug
     * @property \Illuminate\Support\Carbon|null $created_at
     * @property \Illuminate\Support\Carbon|null $updated_at
     * @property int $timestamp
     * @property string $text_color
     * @property array|null $tags
     * @property int $is_active
     * @property string|null $static_gtfs_url
     * @property string|null $realtime_url
     * @property string|null $realtime_type
     * @property mixed|null $realtime_options
     * @property int|null $region_id
     * @property-read string $header_name
     * @property-read string $header_value
     * @property-read string $param_name
     * @property-read string $param_value
     * @property-read string $realtime_method
     * @property-read \Illuminate\Database\Eloquent\Collection|\App\Link[] $links
     * @property-read int|null $links_count
     * @property-read \App\Region|null $region
     * @property-read \Illuminate\Database\Eloquent\Collection|\App\Route[] $routes
     * @property-read int|null $routes_count
     * @property-read \Illuminate\Database\Eloquent\Collection|\App\Service[] $services
     * @property-read int|null $services_count
     * @property-read \Illuminate\Database\Eloquent\Collection|\App\Trip[] $trips
     * @property-read int|null $trips_count
     * @property-read \Illuminate\Database\Eloquent\Collection|\App\Vehicle[] $vehicles
     * @property-read int|null $vehicles_count
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Agency active()
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Agency newModelQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Agency newQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Agency query()
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Agency whereColor($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Agency whereCreatedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Agency whereId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Agency whereIsActive($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Agency whereName($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Agency whereRealtimeOptions($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Agency whereRealtimeType($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Agency whereRealtimeUrl($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Agency whereRegionId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Agency whereSlug($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Agency whereStaticGtfsUrl($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Agency whereTags($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Agency whereTextColor($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Agency whereTimestamp($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Agency whereUpdatedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Agency whereVehiclesType($value)
     */
    class Agency extends \Eloquent
    {
    }
}

namespace App{
    /**
     * App\Stat.
     *
     * @property int $id
     * @property string $type
     * @property object $data
     * @property \Illuminate\Support\Carbon|null $created_at
     * @property \Illuminate\Support\Carbon|null $updated_at
     * @property int|null $region_id
     * @property-read \App\Region|null $region
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Stat newModelQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Stat newQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Stat query()
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Stat whereCreatedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Stat whereData($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Stat whereId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Stat whereRegionId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Stat whereType($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Stat whereUpdatedAt($value)
     */
    class Stat extends \Eloquent
    {
    }
}

namespace App{
    /**
     * App\Link.
     *
     * @property int $id
     * @property string $internal_title
     * @property array $title
     * @property array $description
     * @property string $link
     * @property \Illuminate\Support\Carbon|null $created_at
     * @property \Illuminate\Support\Carbon|null $updated_at
     * @property-read \Illuminate\Database\Eloquent\Collection|\App\Agency[] $agencies
     * @property-read int|null $agencies_count
     * @property-read array $translations
     * @property-read \Illuminate\Database\Eloquent\Collection|\App\Vehicle[] $vehicles
     * @property-read int|null $vehicles_count
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Link newModelQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Link newQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Link query()
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Link whereCreatedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Link whereDescription($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Link whereId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Link whereInternalTitle($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Link whereLink($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Link whereTitle($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Link whereUpdatedAt($value)
     */
    class Link extends \Eloquent
    {
    }
}

namespace App{
    /**
     * App\FailedJobsHistory.
     *
     * @property int $id
     * @property string $name
     * @property int|null $agency_id
     * @property string $exception
     * @property string $last_failed
     * @property \Illuminate\Support\Carbon|null $created_at
     * @property \Illuminate\Support\Carbon|null $updated_at
     * @method static \Illuminate\Database\Eloquent\Builder|\App\FailedJobsHistory newModelQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|\App\FailedJobsHistory newQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|\App\FailedJobsHistory query()
     * @method static \Illuminate\Database\Eloquent\Builder|\App\FailedJobsHistory whereAgencyId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\FailedJobsHistory whereCreatedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\FailedJobsHistory whereException($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\FailedJobsHistory whereId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\FailedJobsHistory whereLastFailed($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\FailedJobsHistory whereName($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\FailedJobsHistory whereUpdatedAt($value)
     */
    class FailedJobsHistory extends \Eloquent
    {
    }
}

namespace App{
    /**
     * App\Service.
     *
     * @property int $id
     * @property string $service_id
     * @property string $start_date
     * @property string $end_date
     * @property int $agency_id
     * @property \Illuminate\Support\Carbon|null $created_at
     * @property \Illuminate\Support\Carbon|null $updated_at
     * @property-read \App\Agency $agency
     * @property-read \Illuminate\Database\Eloquent\Collection|\App\Trip[] $trips
     * @property-read int|null $trips_count
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Service newModelQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Service newQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Service query()
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Service whereAgencyId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Service whereCreatedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Service whereEndDate($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Service whereId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Service whereServiceId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Service whereStartDate($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Service whereUpdatedAt($value)
     */
    class Service extends \Eloquent
    {
    }
}

namespace App{
    /**
     * App\Vehicle.
     *
     * @property int $id
     * @property int $active
     * @property int|null $agency_id
     * @property string|null $gtfs_trip
     * @property string $route
     * @property string|null $start
     * @property string $vehicle
     * @property float|null $lat
     * @property float|null $lon
     * @property float|null $bearing
     * @property float|null $speed
     * @property int|null $stop_sequence
     * @property string|null $status
     * @property int|null $trip_id
     * @property \Illuminate\Support\Carbon|null $created_at
     * @property \Illuminate\Support\Carbon|null $updated_at
     * @property string $icon
     * @property-read \App\Agency|null $agency
     * @property-read \Illuminate\Database\Eloquent\Collection|\App\Link[] $links
     * @property-read int|null $links_count
     * @property-read \App\Trip|null $trip
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Vehicle active()
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Vehicle newModelQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Vehicle newQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Vehicle query()
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Vehicle whereActive($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Vehicle whereAgencyId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Vehicle whereBearing($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Vehicle whereCreatedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Vehicle whereGtfsTrip($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Vehicle whereIcon($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Vehicle whereId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Vehicle whereLat($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Vehicle whereLon($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Vehicle whereRoute($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Vehicle whereSpeed($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Vehicle whereStart($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Vehicle whereStatus($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Vehicle whereStopSequence($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Vehicle whereTripId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Vehicle whereUpdatedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Vehicle whereVehicle($value)
     */
    class Vehicle extends \Eloquent
    {
    }
}

namespace App{
    /**
     * App\User.
     *
     * @property int $id
     * @property string $name
     * @property string $email
     * @property \Illuminate\Support\Carbon|null $email_verified_at
     * @property string $password
     * @property string|null $remember_token
     * @property \Illuminate\Support\Carbon|null $created_at
     * @property \Illuminate\Support\Carbon|null $updated_at
     * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
     * @property-read int|null $notifications_count
     * @method static \Illuminate\Database\Eloquent\Builder|\App\User newModelQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|\App\User newQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|\App\User query()
     * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereCreatedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereEmail($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereEmailVerifiedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereName($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\User wherePassword($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereRememberToken($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereUpdatedAt($value)
     */
    class User extends \Eloquent
    {
    }
}

namespace App{
    /**
     * App\Region.
     *
     * @property int $id
     * @property string $name
     * @property string $slug
     * @property array|null $info_title
     * @property array|null $info_body
     * @property array $map_box
     * @property int $map_zoom
     * @property array $conditions
     * @property array $credits
     * @property string|null $map
     * @property \Illuminate\Support\Carbon|null $created_at
     * @property \Illuminate\Support\Carbon|null $updated_at
     * @property-read \Illuminate\Database\Eloquent\Collection|\App\Agency[] $activeAgencies
     * @property-read int|null $active_agencies_count
     * @property-read \Illuminate\Database\Eloquent\Collection|\App\Agency[] $agencies
     * @property-read int|null $agencies_count
     * @property-read \Illuminate\Database\Eloquent\Collection|\App\Alert[] $alerts
     * @property-read int|null $alerts_count
     * @property-read array $translations
     * @property-read \Illuminate\Database\Eloquent\Collection|\App\Stat[] $stats
     * @property-read int|null $stats_count
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Region newModelQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Region newQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Region query()
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Region whereConditions($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Region whereCreatedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Region whereCredits($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Region whereId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Region whereInfoBody($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Region whereInfoTitle($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Region whereMap($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Region whereMapBox($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Region whereMapZoom($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Region whereName($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Region whereSlug($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Region whereUpdatedAt($value)
     */
    class Region extends \Eloquent
    {
    }
}
