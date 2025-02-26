<?php

namespace Gzhegow\Calendar\Struct;

use Gzhegow\Lib\Lib;
use Gzhegow\Calendar\Exception\LogicException;


class DateInterval extends \DateInterval implements
    \JsonSerializable
{
    public static function createFromInstance($object) : \DateInterval
    {
        if (is_a($object, static::class)) {
            return clone $object;
        }

        if (! is_a($object, \DateInterval::class)) {
            throw new LogicException(
                [
                    'The `object` should be instance of: ' . \DateInterval::class,
                    $object,
                ]
            );
        }

        $instance = new static('P0D');

        $newState = (array) $object;

        // > gzhegow, the `days` property is explained in docs, but dont exists
        // > since PHP 8.2 it triggers deprecation warning ignoring that property is public
        // > btw, ReflectionClass returns that \DateInterval has no properties at all, so...
        if (PHP_VERSION_ID >= 80200) {
            unset($newState[ 'days' ]);
        }

        $fn = (function ($newState) {
            foreach ( $newState as $key => $value ) {
                if (property_exists($this, $key)) {
                    $this->{$key} = $value;
                }
            }
        })->bindTo($instance, $instance);

        call_user_func($fn, $newState);

        return $instance;
    }

    public static function createFromDateString($datetime) : \DateInterval|false
    {
        if (null === Lib::parse()->string_not_empty($datetime)) {
            throw new LogicException(
                [
                    'The `datetime` should be a non-empty string',
                    $datetime,
                ]
            );
        }

        $intervalFromDateString = parent::createFromDateString($datetime);

        $interval = new static('P0D');

        (function ($state) {
            foreach ( $state as $key => $value ) {
                $this->{$key} = $value;
            }
        })->call($interval, (array) $intervalFromDateString);

        return $interval;
    }


    public function jsonSerialize() : mixed
    {
        // $interval = new \DateInterval();
        // var_dump($interval, $var = json_encode($interval));
        //
        // > string(88) "{"y":0,"m":0,"d":0,"h":0,"i":10,"s":0,"f":0,"invert":0,"days":false,"from_string":false}"
        //
        // vs
        //
        // > string(5) "PT10M"

        $search = [ 'S0F', 'M0S', 'H0M', 'DT0H', 'M0D', 'P0Y', 'Y0M', 'P0M' ];
        $replace = [ 'S', 'M', 'H', 'DT', 'M', 'P', 'Y', 'P' ];

        $result = $this->format('P%yY%mM%dDT%hH%iM%sS%fF');
        $result = str_replace($search, $replace, $result);
        $result = rtrim($result, 'PT') ?: 'P0D';

        return $result ?: null;
    }
}
