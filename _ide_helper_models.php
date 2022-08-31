<?php

// @formatter:off
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
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $timestamp
 * @property string $text_color
 * @property \Illuminate\Database\Eloquent\Collection|\App\Models\Tag[] $tags
 * @property int $is_active
 * @property string|null $static_gtfs_url
 * @property string|null $realtime_url
 * @property string|null $realtime_type
 * @property string|null $realtime_options
 * @property array|null $license
 * @property int $refresh_is_active
 * @property string|null $short_name
 * @property string $cron_schedule
 * @property array|null $cities
 * @property string|null $static_etag
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\NotificationUser[] $activeNotificationUsers
 * @property-read int|null $active_notification_users_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Vehicle[] $exoLabelledVehicles
 * @property-read int|null $exo_labelled_vehicles_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Vehicle[] $exoUnlabelledVehicles
 * @property-read int|null $exo_unlabelled_vehicles_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Vehicle[] $exoWithVin
 * @property-read int|null $exo_with_vin_count
 * @property-read mixed $download_method
 * @property-read mixed $header_name
 * @property-read mixed $header_value
 * @property-read mixed $param_name
 * @property-read mixed $param_value
 * @property-read array $random_cities
 * @property-read mixed $realtime_method
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Link[] $links
 * @property-read int|null $links_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\NotificationUser[] $notificationUsers
 * @property-read int|null $notification_users_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Region[] $regions
 * @property-read int|null $regions_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Route[] $routes
 * @property-read int|null $routes_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Service[] $services
 * @property-read int|null $services_count
 * @property-read int|null $tags_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Trip[] $trips
 * @property-read int|null $trips_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Vehicle[] $vehicles
 * @property-read int|null $vehicles_count
 * @method static \Illuminate\Database\Eloquent\Builder|Agency active()
 * @method static \Illuminate\Database\Eloquent\Builder|Agency newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Agency newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Agency query()
 * @method static \Illuminate\Database\Eloquent\Builder|Agency whereCities($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Agency whereColor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Agency whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Agency whereCronSchedule($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Agency whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Agency whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Agency whereLicense($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Agency whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Agency whereRealtimeOptions($value)
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
 * @property int $is_active
 * @property string|null $icon
 * @property string $color
 * @property bool $can_be_closed
 * @property array|null $title
 * @property array|null $body
 * @property string|null $action
 * @property mixed|null $action_parameters
 * @property string|null $expiration
 * @property string|null $image
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Region[] $regions
 * @property-read int|null $regions_count
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
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Agency[] $agencies
 * @property-read int|null $agencies_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Vehicle[] $vehicles
 * @property-read int|null $vehicles_count
 * @method static \Illuminate\Database\Eloquent\Builder|Link newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Link newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Link query()
 * @method static \Illuminate\Database\Eloquent\Builder|Link whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Link whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Link whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Link whereInternalTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Link whereLink($value)
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
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Agency[] $agencies
 * @property-read int|null $agencies_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\NotificationChannels\WebPush\PushSubscription[] $pushSubscriptions
 * @property-read int|null $push_subscriptions_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Vehicle[] $vehicles
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
 * @property mixed $map_center
 * @property int $map_zoom
 * @property array $credits
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property array $description
 * @property array|null $meta_description
 * @property string|null $image
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Agency[] $activeAgencies
 * @property-read int|null $active_agencies_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Alert[] $activeAlerts
 * @property-read int|null $active_alerts_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Agency[] $agencies
 * @property-read int|null $agencies_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Alert[] $alerts
 * @property-read int|null $alerts_count
 * @property-read array $cities
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Stat[] $stats
 * @property-read int|null $stats_count
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
 * App\Models\Route
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
 * @property-read \App\Models\Agency|null $agency
 * @method static \Illuminate\Database\Eloquent\Builder|Route newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Route newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Route query()
 * @method static \Illuminate\Database\Eloquent\Builder|Route whereAgencyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Route whereColor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Route whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Route whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Route whereLongName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Route whereRouteId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Route whereShortName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Route whereTextColor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Route whereUpdatedAt($value)
 */
	class Route extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Service
 *
 * @property int $id
 * @property string $service_id
 * @property string $start_date
 * @property string $end_date
 * @property int $agency_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Agency|null $agency
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Trip[] $trips
 * @property-read int|null $trips_count
 * @method static \Illuminate\Database\Eloquent\Builder|Service newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Service newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Service query()
 * @method static \Illuminate\Database\Eloquent\Builder|Service whereAgencyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Service whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Service whereEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Service whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Service whereServiceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Service whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Service whereUpdatedAt($value)
 */
	class Service extends \Eloquent {}
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
 * @property string|null $icon
 * @property string $color
 * @property string $text_color
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Agency[] $agencies
 * @property-read int|null $agencies_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Vehicle[] $vehicles
 * @property-read int|null $vehicles_count
 * @method static \Illuminate\Database\Eloquent\Builder|Tag newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Tag newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Tag query()
 * @method static \Illuminate\Database\Eloquent\Builder|Tag whereColor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tag whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tag whereIcon($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tag whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tag whereLabel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tag whereTextColor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tag whereUpdatedAt($value)
 */
	class Tag extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Trip
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
 * @property string|null $shape
 * @property-read \App\Models\Agency|null $agency
 * @property-read \App\Models\Service|null $service
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Vehicle[] $vehicles
 * @property-read int|null $vehicles_count
 * @method static \Illuminate\Database\Eloquent\Builder|Trip newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Trip newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Trip query()
 * @method static \Illuminate\Database\Eloquent\Builder|Trip whereAgencyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Trip whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Trip whereExpiration($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Trip whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Trip whereRouteColor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Trip whereRouteLongName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Trip whereRouteShortName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Trip whereRouteTextColor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Trip whereServiceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Trip whereShape($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Trip whereTripHeadsign($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Trip whereTripId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Trip whereTripShortName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Trip whereUpdatedAt($value)
 */
	class Trip extends \Eloquent {}
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
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @method static \Database\Factories\UserFactory factory(...$parameters)
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
 * @property bool $active
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
 * @property int|null $status
 * @property int|null $trip_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $icon
 * @property int|null $relationship
 * @property string|null $label
 * @property string|null $force_label
 * @property string|null $plate
 * @property string|null $odometer
 * @property string|null $timestamp
 * @property int|null $congestion
 * @property int|null $occupancy
 * @property-read \App\Models\Agency|null $agency
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Tag[] $agencyTags
 * @property-read int|null $agency_tags_count
 * @property-read string $displayed_label
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Link[] $links
 * @property-read int|null $links_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\NotificationUser[] $notificationUsers
 * @property-read int|null $notification_users_count
 * @property-read \Illuminate\Database\Eloquent\Collection|Vehicle[] $relatedVehicles
 * @property-read int|null $related_vehicles_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Tag[] $tags
 * @property-read int|null $tags_count
 * @property-read \App\Models\Trip|null $trip
 * @method static \Illuminate\Database\Eloquent\Builder|Vehicle active()
 * @method static \Illuminate\Database\Eloquent\Builder|Vehicle downloadable()
 * @method static \Illuminate\Database\Eloquent\Builder|Vehicle exo()
 * @method static \Illuminate\Database\Eloquent\Builder|Vehicle exoLabelled()
 * @method static \Illuminate\Database\Eloquent\Builder|Vehicle exoUnlabelled()
 * @method static \Illuminate\Database\Eloquent\Builder|Vehicle exoWithVin()
 * @method static \Illuminate\Database\Eloquent\Builder|Vehicle newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Vehicle newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Vehicle query()
 * @method static \Illuminate\Database\Eloquent\Builder|Vehicle whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Vehicle whereAgencyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Vehicle whereBearing($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Vehicle whereCongestion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Vehicle whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Vehicle whereForceLabel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Vehicle whereGtfsTrip($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Vehicle whereIcon($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Vehicle whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Vehicle whereLabel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Vehicle whereLat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Vehicle whereLon($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Vehicle whereOccupancy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Vehicle whereOdometer($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Vehicle wherePlate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Vehicle whereRelationship($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Vehicle whereRoute($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Vehicle whereSpeed($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Vehicle whereStart($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Vehicle whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Vehicle whereStopSequence($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Vehicle whereTimestamp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Vehicle whereTripId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Vehicle whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Vehicle whereVehicle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Vehicle withoutTouch()
 */
	class Vehicle extends \Eloquent {}
}

namespace App\Models\Vin{
/**
 * App\Models\Vin\Suggestion
 *
 * @property int $id
 * @property string $vin
 * @property string $label
 * @property string|null $note
 * @property int $upvotes
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property bool $is_rejected
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Vehicle[] $vehicles
 * @property-read int|null $vehicles_count
 * @method static \Illuminate\Database\Eloquent\Builder|Suggestion newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Suggestion newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Suggestion query()
 * @method static \Illuminate\Database\Eloquent\Builder|Suggestion whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Suggestion whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Suggestion whereIsRejected($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Suggestion whereLabel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Suggestion whereNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Suggestion whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Suggestion whereUpvotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Suggestion whereVin($value)
 */
	class Suggestion extends \Eloquent {}
}

