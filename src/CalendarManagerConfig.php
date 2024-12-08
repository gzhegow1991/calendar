<?php

namespace Gzhegow\Calendar;

use Gzhegow\Calendar\Lib\Lib;
use Gzhegow\Calendar\Config\AbstractConfig;
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


    public function validate()
    {
        $dateTimeDefault = null
            ?? Lib::parse_astring($this->dateTimeDefault)
            ?? (is_a($this->dateTimeDefault, \DateTimeInterface::class) ? $this->dateTimeDefault : null);

        $dateTimeZoneDefault = null
            ?? Lib::parse_astring($this->dateTimeZoneDefault)
            ?? (is_a($this->dateTimeZoneDefault, \DateTimeZone::class) ? $this->dateTimeZoneDefault : null);

        $dateIntervalDefault = null
            ?? Lib::parse_astring($this->dateIntervalDefault)
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
    }
}
