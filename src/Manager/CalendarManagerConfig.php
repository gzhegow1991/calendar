<?php

namespace Gzhegow\Calendar\Manager;

use Gzhegow\Lib\Lib;
use Gzhegow\Lib\Config\AbstractConfig;
use Gzhegow\Calendar\Exception\LogicException;


/**
 * @property string|\DateTimeInterface $dateTimeDefault
 * @property string|\DateTimeZone      $dateTimeZoneDefault
 * @property string|\DateInterval      $dateIntervalDefault
 */
class CalendarManagerConfig extends AbstractConfig
{
    /**
     * @var string|\DateTimeInterface
     */
    protected $dateTimeDefault = 'now';
    /**
     * @var string|\DateTimeZone
     */
    protected $dateTimeZoneDefault = 'UTC';
    /**
     * @var string|\DateInterval
     */
    protected $dateIntervalDefault = 'P0D';


    protected function validation(array $context = []) : bool
    {
        $dateTimeDefault = null
            ?? Lib::parse()->string_not_empty($this->dateTimeDefault)
            ?? (is_a($this->dateTimeDefault, \DateTimeInterface::class) ? $this->dateTimeDefault : null);

        $dateTimeZoneDefault = null
            ?? Lib::parse()->string_not_empty($this->dateTimeZoneDefault)
            ?? (is_a($this->dateTimeZoneDefault, \DateTimeZone::class) ? $this->dateTimeZoneDefault : null);

        $dateIntervalDefault = null
            ?? Lib::parse()->string_not_empty($this->dateIntervalDefault)
            ?? (is_a($this->dateIntervalDefault, \DateInterval::class) ? $this->dateIntervalDefault : null);

        if (null === $dateTimeDefault) {
            throw new LogicException(
                [
                    'The `dateTimeDefault` should be string|\DateTimeInterface',
                    $this->dateTimeDefault,
                ]
            );
        }

        if (null === $dateTimeZoneDefault) {
            throw new LogicException(
                [
                    'The `dateTimeZoneDefault` should be string|\DateTimeZone',
                    $this->dateTimeZoneDefault,
                ]
            );
        }

        if (null === $dateIntervalDefault) {
            throw new LogicException(
                [
                    'The `dateIntervalDefault` should be string|\DateInterval',
                    $this->dateIntervalDefault,
                ]
            );
        }

        return true;
    }
}
