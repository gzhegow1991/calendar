<?php

namespace Gzhegow\Calendar\Struct;

use Gzhegow\Calendar\Exception\LogicException;


class DateTimeZone extends \DateTimeZone implements
    \JsonSerializable
{
    public static function createFromInstance($object) : \DateTimeZone
    {
        if (is_a($object, static::class)) {
            return clone $object;
        }

        if (! is_a($object, \DateTimeZone::class)) {
            throw new LogicException(
                [
                    'The `object` should be instance of: ' . \DateTimeZone::class,
                    $object,
                ]
            );
        }

        $instance = new static('UTC');

        $newState = (array) $object;

        (function ($newState) {
            foreach ( $newState as $key => $value ) {
                if (property_exists($this, $key)) {
                    $this->{$key} = $value;
                }
            }
        })->call($instance, $newState);

        return $instance;
    }


    public function jsonSerialize() : mixed
    {
        // var_dump($tz, $var = json_encode($tz));
        //
        // > string(72) "{"timezone_type":3,"timezone":"UTC"}"
        //
        // vs
        //
        // > string(29) "UTC"

        return $this->getName();
    }
}
