<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: gtfs-realtime.proto3

namespace FelixINX\TransitRealtime;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * A definition (or update) of an entity in the transit feed.
 *
 * Generated from protobuf message <code>FelixINX.TransitRealtime.FeedEntity</code>
 */
class FeedEntity extends \Google\Protobuf\Internal\Message
{
    /**
     * The ids are used only to provide incrementality support. The id should be
     * unique within a FeedMessage. Consequent FeedMessages may contain
     * FeedEntities with the same id. In case of a DIFFERENTIAL update the new
     * FeedEntity with some id will replace the old FeedEntity with the same id
     * (or delete it - see is_deleted below).
     * The actual GTFS entities (e.g. stations, routes, trips) referenced by the
     * feed must be specified by explicit selectors (see EntitySelector below for
     * more info).
     * required string id = 1;
     *
     * Generated from protobuf field <code>string id = 1;</code>
     */
    private $id = '';
    /**
     * Whether this entity is to be deleted. Relevant only for incremental
     * fetches.
     * optional bool is_deleted = 2 [default = false];
     *
     * Generated from protobuf field <code>bool is_deleted = 2;</code>
     */
    private $is_deleted = false;
    /**
     * Data about the entity itself. Exactly one of the following fields must be
     * present (unless the entity is being deleted).
     * optional TripUpdate trip_update = 3;
     *
     * Generated from protobuf field <code>.FelixINX.TransitRealtime.TripUpdate trip_update = 3;</code>
     */
    private $trip_update = null;
    /**
     * optional VehiclePosition vehicle = 4;
     *
     * Generated from protobuf field <code>.FelixINX.TransitRealtime.VehiclePosition vehicle = 4;</code>
     */
    private $vehicle = null;
    /**
     * optional Alert alert = 5;
     *
     * Generated from protobuf field <code>.FelixINX.TransitRealtime.Alert alert = 5;</code>
     */
    private $alert = null;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string $id
     *           The ids are used only to provide incrementality support. The id should be
     *           unique within a FeedMessage. Consequent FeedMessages may contain
     *           FeedEntities with the same id. In case of a DIFFERENTIAL update the new
     *           FeedEntity with some id will replace the old FeedEntity with the same id
     *           (or delete it - see is_deleted below).
     *           The actual GTFS entities (e.g. stations, routes, trips) referenced by the
     *           feed must be specified by explicit selectors (see EntitySelector below for
     *           more info).
     *           required string id = 1;
     *     @type bool $is_deleted
     *           Whether this entity is to be deleted. Relevant only for incremental
     *           fetches.
     *           optional bool is_deleted = 2 [default = false];
     *     @type \FelixINX\TransitRealtime\TripUpdate $trip_update
     *           Data about the entity itself. Exactly one of the following fields must be
     *           present (unless the entity is being deleted).
     *           optional TripUpdate trip_update = 3;
     *     @type \FelixINX\TransitRealtime\VehiclePosition $vehicle
     *           optional VehiclePosition vehicle = 4;
     *     @type \FelixINX\TransitRealtime\Alert $alert
     *           optional Alert alert = 5;
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\GtfsRealtime::initOnce();
        parent::__construct($data);
    }

    /**
     * The ids are used only to provide incrementality support. The id should be
     * unique within a FeedMessage. Consequent FeedMessages may contain
     * FeedEntities with the same id. In case of a DIFFERENTIAL update the new
     * FeedEntity with some id will replace the old FeedEntity with the same id
     * (or delete it - see is_deleted below).
     * The actual GTFS entities (e.g. stations, routes, trips) referenced by the
     * feed must be specified by explicit selectors (see EntitySelector below for
     * more info).
     * required string id = 1;
     *
     * Generated from protobuf field <code>string id = 1;</code>
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * The ids are used only to provide incrementality support. The id should be
     * unique within a FeedMessage. Consequent FeedMessages may contain
     * FeedEntities with the same id. In case of a DIFFERENTIAL update the new
     * FeedEntity with some id will replace the old FeedEntity with the same id
     * (or delete it - see is_deleted below).
     * The actual GTFS entities (e.g. stations, routes, trips) referenced by the
     * feed must be specified by explicit selectors (see EntitySelector below for
     * more info).
     * required string id = 1;
     *
     * Generated from protobuf field <code>string id = 1;</code>
     * @param string $var
     * @return $this
     */
    public function setId($var)
    {
        GPBUtil::checkString($var, True);
        $this->id = $var;

        return $this;
    }

    /**
     * Whether this entity is to be deleted. Relevant only for incremental
     * fetches.
     * optional bool is_deleted = 2 [default = false];
     *
     * Generated from protobuf field <code>bool is_deleted = 2;</code>
     * @return bool
     */
    public function getIsDeleted()
    {
        return $this->is_deleted;
    }

    /**
     * Whether this entity is to be deleted. Relevant only for incremental
     * fetches.
     * optional bool is_deleted = 2 [default = false];
     *
     * Generated from protobuf field <code>bool is_deleted = 2;</code>
     * @param bool $var
     * @return $this
     */
    public function setIsDeleted($var)
    {
        GPBUtil::checkBool($var);
        $this->is_deleted = $var;

        return $this;
    }

    /**
     * Data about the entity itself. Exactly one of the following fields must be
     * present (unless the entity is being deleted).
     * optional TripUpdate trip_update = 3;
     *
     * Generated from protobuf field <code>.FelixINX.TransitRealtime.TripUpdate trip_update = 3;</code>
     * @return \FelixINX\TransitRealtime\TripUpdate
     */
    public function getTripUpdate()
    {
        return $this->trip_update;
    }

    /**
     * Data about the entity itself. Exactly one of the following fields must be
     * present (unless the entity is being deleted).
     * optional TripUpdate trip_update = 3;
     *
     * Generated from protobuf field <code>.FelixINX.TransitRealtime.TripUpdate trip_update = 3;</code>
     * @param \FelixINX\TransitRealtime\TripUpdate $var
     * @return $this
     */
    public function setTripUpdate($var)
    {
        GPBUtil::checkMessage($var, \FelixINX\TransitRealtime\TripUpdate::class);
        $this->trip_update = $var;

        return $this;
    }

    /**
     * optional VehiclePosition vehicle = 4;
     *
     * Generated from protobuf field <code>.FelixINX.TransitRealtime.VehiclePosition vehicle = 4;</code>
     * @return \FelixINX\TransitRealtime\VehiclePosition
     */
    public function getVehicle()
    {
        return $this->vehicle;
    }

    /**
     * optional VehiclePosition vehicle = 4;
     *
     * Generated from protobuf field <code>.FelixINX.TransitRealtime.VehiclePosition vehicle = 4;</code>
     * @param \FelixINX\TransitRealtime\VehiclePosition $var
     * @return $this
     */
    public function setVehicle($var)
    {
        GPBUtil::checkMessage($var, \FelixINX\TransitRealtime\VehiclePosition::class);
        $this->vehicle = $var;

        return $this;
    }

    /**
     * optional Alert alert = 5;
     *
     * Generated from protobuf field <code>.FelixINX.TransitRealtime.Alert alert = 5;</code>
     * @return \FelixINX\TransitRealtime\Alert
     */
    public function getAlert()
    {
        return $this->alert;
    }

    /**
     * optional Alert alert = 5;
     *
     * Generated from protobuf field <code>.FelixINX.TransitRealtime.Alert alert = 5;</code>
     * @param \FelixINX\TransitRealtime\Alert $var
     * @return $this
     */
    public function setAlert($var)
    {
        GPBUtil::checkMessage($var, \FelixINX\TransitRealtime\Alert::class);
        $this->alert = $var;

        return $this;
    }

}

