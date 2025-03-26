<?php

namespace Gzhegow\Calendar\Struct\PHP7;

use Gzhegow\Lib\Lib;
use Gzhegow\Calendar\Calendar;
use Gzhegow\Calendar\Exception\LogicException;


class DateInterval extends \DateInterval implements
    \JsonSerializable
{
    public function __construct($duration)
    {
        $theStr = Lib::str();

        if (! (is_string($duration) && ('' !== $duration))) {
            throw new LogicException(
                [ 'The `duration` should be non-empty string', $duration ]
            );
        }

        $regex = '/(\d+\.\d+)([YMWDHS])/';

        $hasDecimalValue = preg_match_all($regex, $duration, $matches);

        $decimalValueFrac = null;
        $decimalLetter = null;
        if ($hasDecimalValue) {
            if (count($matches[ 0 ]) > 1) {
                throw new LogicException(
                    [
                        'The `duration` can contain only one decimal separator in smallest period (according ISO 8601)',
                        $duration,
                    ]
                );
            }

            $decimalSubstr = $matches[ 0 ][ 0 ];
            $decimalValue = $matches[ 1 ][ 0 ];
            $decimalLetter = $matches[ 2 ][ 0 ];

            if (! $theStr->ends($duration, $decimalSubstr, false)) {
                throw new LogicException(
                    [
                        'The `duration` can contain only one decimal separator in smallest period (according ISO 8601)',
                        $duration,
                    ]
                );
            }

            $decimalValueFloat = (float) $decimalValue;
            $decimalValueFloor = floor($decimalValue);

            $decimalValueFrac = $decimalValueFloat - $decimalValueFloor;

            $duration = str_replace($decimalValue, $decimalValueFloor, $duration);
        }

        parent::__construct($duration);

        if ($hasDecimalValue) {
            $now = new \DateTime('now');
            $nowModified = clone $now;

            $nowModified->add($this);

            $seconds = null;
            switch ( $decimalLetter ):
                case 'Y':
                    $seconds = floor($decimalValueFrac * Calendar::INTERVAL_YEAR);

                    break;

                case 'W':
                    $seconds = floor($decimalValueFrac * Calendar::INTERVAL_WEEK);

                    break;

                case 'D':
                    $seconds = floor($decimalValueFrac * Calendar::INTERVAL_DAY);

                    break;

                case 'H':
                    $seconds = floor($decimalValueFrac * Calendar::INTERVAL_HOUR);

                    break;

                case 'M':
                    if (false === strpos($duration, 'T')) {
                        $seconds = ceil($decimalValueFrac * Calendar::INTERVAL_MONTH);

                    } else {
                        $seconds = ceil($decimalValueFrac * Calendar::INTERVAL_MINUTE);
                    }

                    break;

            endswitch;

            if (null !== $seconds) {
                $nowModified->modify("+{$seconds} seconds");
            }

            $interval = $nowModified->diff($now);

            $this->y = $interval->y;
            $this->m = $interval->m;
            $this->d = $interval->d;
            $this->h = $interval->h;
            $this->i = $interval->i;
            $this->s = $interval->s;

            if ($decimalLetter === 'S') {
                $this->f = $decimalValueFrac;
            }
        }
    }


    /**
     * @return static
     */
    public static function createFromInstance($object)
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

        (function ($newState) {
            foreach ( $newState as $key => $value ) {
                if (property_exists($this, $key)) {
                    $this->{$key} = $value;
                }
            }
        })->call($instance, $newState);

        return $instance;
    }

    /**
     * @return static
     */
    public static function createFromDateString($datetime)
    {
        if (! Lib::type()->string_not_empty($_datetime, $datetime)) {
            throw new LogicException(
                [ 'The `datetime` should be a non-empty string', $datetime ]
            );
        }

        $intervalFromDateString = parent::createFromDateString($_datetime);

        $interval = new static('P0D');

        (function ($state) {
            foreach ( $state as $key => $value ) {
                $this->{$key} = $value;
            }
        })->call($interval, (array) $intervalFromDateString);

        return $interval;
    }


    public function getISO8601Duration() : string
    {
        $search = [ 'M0S', 'H0M', 'DT0H', 'M0D', 'P0Y', 'Y0M', 'P0M' ];
        $replace = [ 'M', 'H', 'DT', 'M', 'P', 'Y', 'P' ];

        if ($this->f) {
            $fString = sprintf('%.6f', $this->f);
            $fString = substr($fString, 2);
            $fString = rtrim($fString, '0.');

            $result = $this->format("P%yY%mM%dDT%hH%iM%s.{$fString}S");

        } else {
            $result = $this->format('P%yY%mM%dDT%hH%iM%sS');
        }

        $result = str_replace($search, $replace, $result);
        $result = rtrim($result, 'PT') ?: 'P0D';

        return $result;
    }


    public function jsonSerialize() // : mixed
    {
        // $interval = new \DateInterval();
        // var_dump($interval, $var = json_encode($interval));
        //
        // > string(88) "{"y":0,"m":0,"d":0,"h":0,"i":10,"s":0,"f":0,"invert":0,"days":false,"from_string":false}"
        //
        // vs
        //
        // > string(5) "PT10M"

        return $this->getISO8601Duration();
    }
}
