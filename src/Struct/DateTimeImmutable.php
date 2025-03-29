<?php

namespace Gzhegow\Calendar\Struct;

use Gzhegow\Lib\Lib;
use Gzhegow\Calendar\Calendar;
use Gzhegow\Calendar\Exception\LogicException;
use Gzhegow\Calendar\Exception\RuntimeException;


class DateTimeImmutable extends \DateTimeImmutable implements
    DateTimeInterface,
    //
    \JsonSerializable
{
    public static function createFromInterface($object) : \DateTimeImmutable
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

        $seconds = $object->getTimestamp();

        $microseconds = str_pad($object->format('u'), 6, '0');

        try {
            $dateTimeImmutable = (new static('now', $object->getTimezone()))
                ->setTimestamp($seconds)
                ->modify("+ {$microseconds} microseconds")
            ;
        }
        catch ( \Throwable $e ) {
            throw new RuntimeException($e->getMessage(), $e->getCode(), $e);
        }

        return $dateTimeImmutable;
    }

    public static function createFromFormat($format, $datetime, $timezone = null) : \DateTimeImmutable|false
    {
        $theType = Lib::type();

        if (! $theType->string_not_empty($_format, $format)) {
            throw new LogicException(
                [ 'The `format` should be a non-empty string', $format ]
            );
        }

        if (! $theType->string_not_empty($_datetime, $datetime)) {
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

        $dateTimeImmutablePhp = \DateTimeImmutable::createFromFormat(
            $_format,
            $_datetime,
            $timezone
        );

        $microseconds = str_pad($dateTimeImmutablePhp->format('u'), 6, '0');

        try {
            $dateTimeImmutablePhp = (new static('now', $dateTimeImmutablePhp->getTimezone()))
                ->setTimestamp($dateTimeImmutablePhp->getTimestamp())
                ->modify("+ {$microseconds} microseconds")
            ;
        }
        catch ( \Throwable $e ) {
            throw new RuntimeException($e->getMessage(), $e->getCode(), $e);
        }

        return $dateTimeImmutablePhp;
    }


    public function diff($targetObject, $absolute = false) : \DateInterval
    {
        $intervalDiff = parent::diff($targetObject, $absolute);

        $intervalClass = Calendar::classDateInterval();

        $interval = $intervalClass::{'createFromInstance'}($intervalDiff);

        return $interval;
    }


    public function getMilliseconds() : string
    {
        return $this->format('v');
    }

    public function getMicroseconds() : string
    {
        return $this->format('u');
    }


    public function jsonSerialize() : mixed
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
