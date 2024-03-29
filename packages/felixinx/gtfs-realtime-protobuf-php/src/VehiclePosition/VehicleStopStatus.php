<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: gtfs-realtime.proto3

namespace FelixINX\TransitRealtime\VehiclePosition;

/**
 * Protobuf type <code>FelixINX.TransitRealtime.VehiclePosition.VehicleStopStatus</code>
 */
class VehicleStopStatus
{
    /**
     * The vehicle is just about to arrive at the stop (on a stop
     * display, the vehicle symbol typically flashes).
     *
     * Generated from protobuf enum <code>INCOMING_AT = 0;</code>
     */
    const INCOMING_AT = 0;
    /**
     * The vehicle is standing at the stop.
     *
     * Generated from protobuf enum <code>STOPPED_AT = 1;</code>
     */
    const STOPPED_AT = 1;
    /**
     * The vehicle has departed and is in transit to the next stop.
     *
     * Generated from protobuf enum <code>IN_TRANSIT_TO = 2;</code>
     */
    const IN_TRANSIT_TO = 2;
}
