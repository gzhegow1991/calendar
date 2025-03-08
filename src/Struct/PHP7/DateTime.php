<?php

namespace Gzhegow\Calendar\Struct\PHP7;

use Gzhegow\Lib\Lib;
use Gzhegow\Calendar\Calendar;
use Gzhegow\Calendar\Exception\LogicException;
use Gzhegow\Calendar\Exception\RuntimeException;


class DateTime extends \DateTime implements DateTimeInterface,
    \JsonSerializable
{
    /**
     * @return static
     */
    public static function createFromInterface($object)
    {
        if (is_a($object, static::class)) {
            return clone $object;
        }

        if (! is_a($object, \DateTimeInterface::class)) {
            throw new LogicException(
                [
                    'The `object` should be instance of: ' . \DateTimeInterface::class,
                    $object,
                ]
            );
        }

        $microseconds = str_pad($object->format('u'), 6, '0');

        try {
            $dateTime = (new static('now', $object->getTimezone()))
                ->setTimestamp($object->getTimestamp())
                ->modify("+ {$microseconds} microseconds")
            ;
        }
        catch ( \Throwable $e ) {
            throw new RuntimeException($e->getMessage(), $e->getCode(), $e);
        }

        return $dateTime;
    }


    /**
     * @return static
     */
    public static function createFromFormat($format, $datetime, $timezone = null)
    {
        if (! Lib::type()->string_not_empty($_format, $format)) {
            throw new LogicException(
                [ 'The `format` should be a non-empty string', $format ]
            );
        }

        if (! Lib::type()->string_not_empty($_datetime, $datetime)) {
            throw new LogicException(
                [ 'The `datetime` should be a non-empty string', $datetime ]
            );
        }

        if (null !== $timezone) {
            if (! is_a($timezone, \DateTimeZone::class)) {
                throw new LogicException(
                    [
                        'The `object` should be instance of: ' . \DateTimeZone::class,
                        $timezone,
                    ]
                );
            }
        }

        $dateTime = parent::createFromFormat($_format, $_datetime, $timezone);

        $microseconds = str_pad($dateTime->format('u'), 6, '0');

        try {
            $dateTime = (new static('now', $dateTime->getTimezone()))
                ->setTimestamp($dateTime->getTimestamp())
                ->modify("+ {$microseconds} microseconds")
            ;
        }
        catch ( \Throwable $e ) {
            throw new RuntimeException($e->getMessage(), $e->getCode(), $e);
        }

        return $dateTime;
    }


    public function diff($targetObject, $absolute = false) : \DateInterval
    {
        $interval = parent::diff($targetObject, $absolute);

        $intervalClass = Calendar::classDateInterval();

        $interval = $intervalClass::{'createFromInstance'}($interval);

        return $interval;
    }


    public function jsonSerialize() // : mixed
    {
        // var_dump($date, $var = json_encode($date));
        //
        // > string(72) "{"date":"1970-01-01 00:00:00.000000","timezone_type":3,"timezone":"UTC"}"
        //
        // vs
        //
        // > string(29) "2024-04-08T08:42:04.037+00:00"

        return $this->format(Calendar::FORMAT_JAVASCRIPT_MILLISECONDS);
    }
}
