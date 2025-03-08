<?php

namespace Gzhegow\Calendar\Parser;

use Gzhegow\Lib\Lib;
use Gzhegow\Calendar\Calendar;
use Gzhegow\Calendar\Exception\LogicException;
use Gzhegow\Calendar\CalendarFactoryInterface;
use Gzhegow\Calendar\Manager\CalendarManagerInterface;


class CalendarParser implements CalendarParserInterface
{
    /**
     * @var CalendarFactoryInterface
     */
    protected $factory;
    /**
     * @var CalendarManagerInterface
     */
    protected $manager;

    /**
     * @var CalendarParserConfig
     */
    protected $config;


    public function __construct(
        CalendarFactoryInterface $factory,
        //
        CalendarParserConfig $config
    )
    {
        $this->factory = $factory;

        $this->config = $config;
        $this->config->validate();
    }


    public function parseDateTime($from, array $formats = null, $dateTimeZoneIfParsed = null) : ?\DateTime
    {
        if (null === $from) {
            return null;
        }

        if (is_a($from, \DateTimeInterface::class)) {
            $dateTime = $this->factory->newDateTimeFromInterface($from);

            return $dateTime;
        }

        $dateTime = null
            ?? $this->parseDateTimeFromNum($from, $dateTimeZoneIfParsed)
            ?? $this->parseDateTimeFromString($from, $dateTimeZoneIfParsed)
            ?? $this->parseDateTimeFromStringByFormats($from, $formats, $dateTimeZoneIfParsed);

        if (null !== $dateTime) {
            $dateTime = $this->factory->newDateTimeFromInterface($dateTime);

            return $dateTime;
        }

        return null;
    }

    public function parseDateTimeImmutable($from, array $formats = null, $dateTimeZoneIfParsed = null) : ?\DateTimeImmutable
    {
        if (null === $from) {
            return null;
        }

        if (is_a($from, \DateTimeInterface::class)) {
            $dateTimeImmutable = $this->factory->newDateTimeImmutableFromInterface($from);

            return $dateTimeImmutable;
        }

        $dateTimeImmutable = null
            ?? $this->parseDateTimeFromNum($from, $dateTimeZoneIfParsed)
            ?? $this->parseDateTimeFromString($from, $dateTimeZoneIfParsed)
            ?? $this->parseDateTimeFromStringByFormats($from, $formats, $dateTimeZoneIfParsed);

        if (null !== $dateTimeImmutable) {
            $dateTimeImmutable = $this->factory->newDateTimeImmutableFromInterface($dateTimeImmutable);

            return $dateTimeImmutable;
        }

        return null;
    }


    protected function parseDateTimeFromNum($num, $dateTimeZoneIfParsed = null) : ?\DateTime
    {
        if (! Lib::type()->num($_num, $num)) {
            return null;
        }

        if ($_num < 0) {
            return null;
        }

        $int = (int) $_num;
        $frac = $_num - $int;

        $_dateTimeZoneIfParsed = null;
        if (null !== $dateTimeZoneIfParsed) {
            $_dateTimeZoneIfParsed = $this->parseDateTimeZone($dateTimeZoneIfParsed);

            if (null === $_dateTimeZoneIfParsed) {
                return null;
            }
        }

        $dateTime = $this->factory->newDateTime(
            'now',
            $_dateTimeZoneIfParsed
        );

        $dateTime->setTimestamp((int) $_num);

        if ($frac) {
            $frac *= 1000000;
            $frac = (int) $frac;
            $frac = str_pad($frac, 6, 0);

            $dateTime->modify("+ {$frac} microseconds");
        }

        return $dateTime;
    }

    protected function parseDateTimeFromString($string, $dateTimeZoneIfParsed = null) : ?\DateTime
    {
        if (! Lib::type()->string_not_empty($_string, $string)) {
            return null;
        }

        $_dateTimeZoneIfParsed = null;
        if (null !== $dateTimeZoneIfParsed) {
            $_dateTimeZoneIfParsed = $this->parseDateTimeZone($dateTimeZoneIfParsed);

            if (null === $_dateTimeZoneIfParsed) {
                return null;
            }
        }

        try {
            // > gzhegow, timezone will be ignored if format contains one
            // https://www.php.net/manual/en/datetimeimmutable.createfromformat.php
            $dateTime = $this->factory->newDateTime($_string, $_dateTimeZoneIfParsed);
        }
        catch ( \Throwable $e ) {
            return null;
        }

        return $dateTime;
    }

    protected function parseDateTimeFromStringByFormats($string, array $formats = null, $dateTimeZoneIfParsed = null) : ?\DateTime
    {
        if (! Lib::type()->string_not_empty($_string, $string)) {
            return null;
        }

        $formats = $formats ?? $this->config->parseDateTimeFormatsDefault;

        $dateTime = null;
        foreach ( $formats as $format ) {
            $dateTime = $this->parseDateTimeFromStringByFormat(
                $_string,
                $format,
                $dateTimeZoneIfParsed
            );

            if (null !== $dateTime) {
                break;
            }
        }

        return $dateTime;
    }

    protected function parseDateTimeFromStringByFormat($string, string $format, $dateTimeZoneIfParsed = null) : ?\DateTime
    {
        if (! Lib::type()->string_not_empty($_string, $string)) {
            return null;
        }

        $_dateTimeZoneIfParsed = null;
        if (null !== $dateTimeZoneIfParsed) {
            $_dateTimeZoneIfParsed = $this->parseDateTimeZone($dateTimeZoneIfParsed);

            if (null === $_dateTimeZoneIfParsed) {
                return null;
            }
        }

        try {
            // > gzhegow, timezone will be ignored if format contains one
            // https://www.php.net/manual/en/datetimeimmutable.createfromformat.php
            $dateTime = $this->factory->newDateTimeFromFormat(
                $format,
                $_string,
                $_dateTimeZoneIfParsed
            );
        }
        catch ( \Throwable $e ) {
            return null;
        }

        return $dateTime;
    }


    public function parseDateTimeZone($from) : ?\DateTimeZone
    {
        if (null === $from) {
            return null;
        }

        if (is_a($from, \DateTimeZone::class)) {
            $dateTimeZone = $this->factory->newDateTimeZoneFromInstance($from);

            return $dateTimeZone;
        }

        $dateTimeZone = null
            ?? $this->parseDateTimeZoneFromStringTimezone($from);

        if (null !== $dateTimeZone) {
            return $dateTimeZone;
        }

        return null;
    }

    protected function parseDateTimeZoneFromStringTimezone($timezone) : ?\DateTimeZone
    {
        if (! Lib::type()->string_not_empty($_timezone, $timezone)) {
            return null;
        }

        try {
            $dateTimeZone = $this->factory->newDateTimeZone($_timezone);
        }
        catch ( \Throwable $e ) {
            return null;
        }

        return $dateTimeZone;
    }


    public function parseDateInterval($from, array $formats = null) : ?\DateInterval
    {
        if (null === $from) {
            return null;
        }

        if (is_a($from, \DateInterval::class)) {
            $dateInterval = $this->factory->newDateIntervalFromInstance($from);

            return $dateInterval;
        }

        $dateInterval = null
            ?? $this->parseDateIntervalFromInt($from)
            ?? $this->parseDateIntervalFromStringDuration($from)
            ?? $this->parseDateIntervalFromStringByFormats($from, $formats)
            ?? $this->parseDateIntervalFromStringDatetime($from);

        if (null !== $dateInterval) {
            return $dateInterval;
        }

        return null;
    }

    protected function parseDateIntervalFromInt($int) : ?\DateInterval
    {
        if (! Lib::type()->int($_int, $int)) {
            return null;
        }

        if ($_int < 0) {
            return null;
        }

        $seconds = $_int;

        $days = floor($seconds / Calendar::INTERVAL_DAY);
        $seconds = $seconds % Calendar::INTERVAL_DAY;

        $hours = floor($seconds / Calendar::INTERVAL_HOUR);
        $seconds = $seconds % Calendar::INTERVAL_HOUR;

        $minutes = floor($seconds / Calendar::INTERVAL_MINUTE);
        $seconds = $seconds % Calendar::INTERVAL_MINUTE;

        $from = sprintf('P%dDT%dH%dM%dS', $days, $hours, $minutes, $seconds);

        try {
            $dateInterval = $this->factory->newDateInterval($from);
        }
        catch ( \Throwable $e ) {
            return null;
        }

        return $dateInterval;
    }

    protected function parseDateIntervalFromStringDuration($duration) : ?\DateInterval
    {
        if (! Lib::type()->string_not_empty($_duration, $duration)) {
            return null;
        }

        try {
            $dateInterval = $this->factory->newDateInterval($_duration);
        }
        catch ( \Throwable $e ) {
            return null;
        }

        return $dateInterval;
    }

    protected function parseDateIntervalFromStringByFormats($string, array $formats = null) : ?\DateInterval
    {
        if (! Lib::type()->string_not_empty($_string, $string)) {
            return null;
        }

        $formats = $formats ?? $this->config->parseDateIntervalFormatsDefault;

        $dateInterval = null;
        foreach ( $formats as $format ) {
            $dateInterval = $this->parseDateIntervalFromStringByFormat(
                $_string,
                $format
            );

            if (null !== $dateInterval) {
                break;
            }
        }

        return $dateInterval;
    }

    protected function parseDateIntervalFromStringByFormat($string, string $format) : ?\DateInterval
    {
        if (! Lib::type()->string_not_empty($_string, $string)) {
            return null;
        }

        try {
            // > gzhegow, timezone will be ignored if format contains one
            // https://www.php.net/manual/en/datetimeimmutable.createfromformat.php
            $dateTime = $this->factory->newDateTimeFromFormat($format, $_string, null);
        }
        catch ( \Throwable $e ) {
            return null;
        }

        $now = $this->factory->newDateTime('now midnight', null);

        $dateInterval = $dateTime->diff($now, true);

        return $dateInterval;
    }

    protected function parseDateIntervalFromStringDatetime($datetime) : ?\DateInterval
    {
        if (! Lib::type()->string_not_empty($_datetime, $datetime)) {
            return null;
        }

        try {
            $dateInterval = $this->factory->newDateIntervalFromDateString($_datetime);
        }
        catch ( \Throwable $e ) {
            return null;
        }

        return $dateInterval;
    }
}
