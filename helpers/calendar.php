<?php

namespace Gzhegow\Calendar;

use Gzhegow\Calendar\Struct\DateTime;
use Gzhegow\Calendar\Struct\DateTimeZone;
use Gzhegow\Calendar\Struct\DateInterval;
use Gzhegow\Calendar\Struct\DateTimeImmutable;


/**
 * @return Calendar
 */
function _calendar(CalendarInterface $calendar = null) : CalendarInterface
{
    static $instance;

    $instance = $instance ?? $calendar;

    return $instance;
}


function _calendar_date($datetime = 'now', array $formats = null, $timezoneIfParsed = null) : ?DateTime
{
    return _calendar()->parseDateTime($datetime, $formats, $timezoneIfParsed);
}

function _calendar_date_immutable($datetime = 'now', array $formats = null, $timezoneIfParsed = null) : ?DateTimeImmutable
{
    return _calendar()->parseDateTimeImmutable($datetime, $formats, $timezoneIfParsed);
}


function _calendar_now($timezone = null) : ?DateTime
{
    return _calendar()->now($timezone);
}

function _calendar_now_immutable($timezone = null) : ?DateTimeImmutable
{
    return _calendar()->nowImmutable($timezone);
}


function _calendar_now_fixed($datetime = null, $timezone = null) : ?DateTimeImmutable
{
    return _calendar()->nowFixed($datetime, $timezone);
}

function _calendar_now_fixed_clear() : ?DateTimeImmutable
{
    return _calendar()->clearNowFixed();
}


function _calendar_timezone($timezone = 'UTC') : ?DateTimeZone
{
    return _calendar()->parseDateTimeZone($timezone);
}


function _calendar_interval($interval = 'P0D', array $formats = null) : ?DateInterval
{
    return _calendar()->parseDateInterval($interval, $formats);
}


function _calendar_diff(\DateTimeInterface $from, \DateTimeInterface $to, $absolute = false) : ?DateInterval
{
    return _calendar()->diff($from, $to, $absolute);
}
