<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: transittracker-api.proto

namespace TransitTracker\ProtobufApi\VehiclesCollection;

use Google\Protobuf\Internal\GPBUtil;

/**
 * Generated from protobuf message <code>TransitTracker.ProtobufApi.VehiclesCollection.Geometry</code>
 */
class Geometry extends \Google\Protobuf\Internal\Message
{
    /**
     * Generated from protobuf field <code>string type = 1;</code>
     */
    protected $type = '';
    /**
     * Generated from protobuf field <code>repeated double coordinates = 2;</code>
     */
    private $coordinates;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string $type
     *     @type array<float>|\Google\Protobuf\Internal\RepeatedField $coordinates
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\TransittrackerApi::initOnce();
        parent::__construct($data);
    }

    /**
     * Generated from protobuf field <code>string type = 1;</code>
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Generated from protobuf field <code>string type = 1;</code>
     * @param string $var
     * @return $this
     */
    public function setType($var)
    {
        GPBUtil::checkString($var, True);
        $this->type = $var;

        return $this;
    }

    /**
     * Generated from protobuf field <code>repeated double coordinates = 2;</code>
     * @return \Google\Protobuf\Internal\RepeatedField
     */
    public function getCoordinates()
    {
        return $this->coordinates;
    }

    /**
     * Generated from protobuf field <code>repeated double coordinates = 2;</code>
     * @param array<float>|\Google\Protobuf\Internal\RepeatedField $var
     * @return $this
     */
    public function setCoordinates($var)
    {
        $arr = GPBUtil::checkRepeatedField($var, \Google\Protobuf\Internal\GPBType::DOUBLE);
        $this->coordinates = $arr;

        return $this;
    }

}

// Adding a class alias for backwards compatibility with the previous class name.
class_alias(Geometry::class, \TransitTracker\ProtobufApi\VehiclesCollection_Geometry::class);

