<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: gtfs-realtime.proto3

namespace FelixINX\TransitRealtime\FeedHeader;

/**
 * Determines whether the current fetch is incremental.  Currently,
 * DIFFERENTIAL mode is unsupported and behavior is unspecified for feeds
 * that use this mode.  There are discussions on the GTFS-realtime mailing
 * list around fully specifying the behavior of DIFFERENTIAL mode and the
 * documentation will be updated when those discussions are finalized.
 *
 * Protobuf type <code>FelixINX.TransitRealtime.FeedHeader.Incrementality</code>
 */
class Incrementality
{
    /**
     * Generated from protobuf enum <code>FULL_DATASET = 0;</code>
     */
    const FULL_DATASET = 0;
    /**
     * Generated from protobuf enum <code>DIFFERENTIAL = 1;</code>
     */
    const DIFFERENTIAL = 1;
}
