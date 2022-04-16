<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: gtfs-realtime.proto3

namespace FelixINX\TransitRealtime\TripUpdate;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Realtime update for arrival and/or departure events for a given stop on a
 * trip. Updates can be supplied for both past and future events.
 * The producer is allowed, although not required, to drop past events.
 *
 * Generated from protobuf message <code>FelixINX.TransitRealtime.TripUpdate.StopTimeUpdate</code>
 */
class StopTimeUpdate extends \Google\Protobuf\Internal\Message
{
    /**
     * Must be the same as in stop_times.txt in the corresponding GTFS feed.
     * optional uint32 stop_sequence = 1;
     *
     * Generated from protobuf field <code>uint32 stop_sequence = 1;</code>
     */
    private $stop_sequence = 0;
    /**
     * Must be the same as in stops.txt in the corresponding GTFS feed.
     * optional string stop_id = 4;
     *
     * Generated from protobuf field <code>string stop_id = 4;</code>
     */
    private $stop_id = '';
    /**
     * optional StopTimeEvent arrival = 2;
     *
     * Generated from protobuf field <code>.FelixINX.TransitRealtime.TripUpdate.StopTimeEvent arrival = 2;</code>
     */
    private $arrival = null;
    /**
     * optional StopTimeEvent departure = 3;
     *
     * Generated from protobuf field <code>.FelixINX.TransitRealtime.TripUpdate.StopTimeEvent departure = 3;</code>
     */
    private $departure = null;
    /**
     * optional ScheduleRelationship schedule_relationship = 5
     *    [default = SCHEDULED];
     *
     * Generated from protobuf field <code>.FelixINX.TransitRealtime.TripUpdate.StopTimeUpdate.ScheduleRelationship schedule_relationship = 5;</code>
     */
    private $schedule_relationship = 0;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type int $stop_sequence
     *           Must be the same as in stop_times.txt in the corresponding GTFS feed.
     *           optional uint32 stop_sequence = 1;
     *     @type string $stop_id
     *           Must be the same as in stops.txt in the corresponding GTFS feed.
     *           optional string stop_id = 4;
     *     @type \FelixINX\TransitRealtime\TripUpdate\StopTimeEvent $arrival
     *           optional StopTimeEvent arrival = 2;
     *     @type \FelixINX\TransitRealtime\TripUpdate\StopTimeEvent $departure
     *           optional StopTimeEvent departure = 3;
     *     @type int $schedule_relationship
     *           optional ScheduleRelationship schedule_relationship = 5
     *              [default = SCHEDULED];
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\GtfsRealtime::initOnce();
        parent::__construct($data);
    }

    /**
     * Must be the same as in stop_times.txt in the corresponding GTFS feed.
     * optional uint32 stop_sequence = 1;
     *
     * Generated from protobuf field <code>uint32 stop_sequence = 1;</code>
     * @return int
     */
    public function getStopSequence()
    {
        return $this->stop_sequence;
    }

    /**
     * Must be the same as in stop_times.txt in the corresponding GTFS feed.
     * optional uint32 stop_sequence = 1;
     *
     * Generated from protobuf field <code>uint32 stop_sequence = 1;</code>
     * @param int $var
     * @return $this
     */
    public function setStopSequence($var)
    {
        GPBUtil::checkUint32($var);
        $this->stop_sequence = $var;

        return $this;
    }

    /**
     * Must be the same as in stops.txt in the corresponding GTFS feed.
     * optional string stop_id = 4;
     *
     * Generated from protobuf field <code>string stop_id = 4;</code>
     * @return string
     */
    public function getStopId()
    {
        return $this->stop_id;
    }

    /**
     * Must be the same as in stops.txt in the corresponding GTFS feed.
     * optional string stop_id = 4;
     *
     * Generated from protobuf field <code>string stop_id = 4;</code>
     * @param string $var
     * @return $this
     */
    public function setStopId($var)
    {
        GPBUtil::checkString($var, True);
        $this->stop_id = $var;

        return $this;
    }

    /**
     * optional StopTimeEvent arrival = 2;
     *
     * Generated from protobuf field <code>.FelixINX.TransitRealtime.TripUpdate.StopTimeEvent arrival = 2;</code>
     * @return \FelixINX\TransitRealtime\TripUpdate\StopTimeEvent
     */
    public function getArrival()
    {
        return $this->arrival;
    }

    /**
     * optional StopTimeEvent arrival = 2;
     *
     * Generated from protobuf field <code>.FelixINX.TransitRealtime.TripUpdate.StopTimeEvent arrival = 2;</code>
     * @param \FelixINX\TransitRealtime\TripUpdate\StopTimeEvent $var
     * @return $this
     */
    public function setArrival($var)
    {
        GPBUtil::checkMessage($var, \FelixINX\TransitRealtime\TripUpdate_StopTimeEvent::class);
        $this->arrival = $var;

        return $this;
    }

    /**
     * optional StopTimeEvent departure = 3;
     *
     * Generated from protobuf field <code>.FelixINX.TransitRealtime.TripUpdate.StopTimeEvent departure = 3;</code>
     * @return \FelixINX\TransitRealtime\TripUpdate\StopTimeEvent
     */
    public function getDeparture()
    {
        return $this->departure;
    }

    /**
     * optional StopTimeEvent departure = 3;
     *
     * Generated from protobuf field <code>.FelixINX.TransitRealtime.TripUpdate.StopTimeEvent departure = 3;</code>
     * @param \FelixINX\TransitRealtime\TripUpdate\StopTimeEvent $var
     * @return $this
     */
    public function setDeparture($var)
    {
        GPBUtil::checkMessage($var, \FelixINX\TransitRealtime\TripUpdate_StopTimeEvent::class);
        $this->departure = $var;

        return $this;
    }

    /**
     * optional ScheduleRelationship schedule_relationship = 5
     *    [default = SCHEDULED];
     *
     * Generated from protobuf field <code>.FelixINX.TransitRealtime.TripUpdate.StopTimeUpdate.ScheduleRelationship schedule_relationship = 5;</code>
     * @return int
     */
    public function getScheduleRelationship()
    {
        return $this->schedule_relationship;
    }

    /**
     * optional ScheduleRelationship schedule_relationship = 5
     *    [default = SCHEDULED];
     *
     * Generated from protobuf field <code>.FelixINX.TransitRealtime.TripUpdate.StopTimeUpdate.ScheduleRelationship schedule_relationship = 5;</code>
     * @param int $var
     * @return $this
     */
    public function setScheduleRelationship($var)
    {
        GPBUtil::checkEnum($var, \FelixINX\TransitRealtime\TripUpdate_StopTimeUpdate_ScheduleRelationship::class);
        $this->schedule_relationship = $var;

        return $this;
    }

}