<?php

namespace Gzhegow\Calendar\Parser;

use Gzhegow\Lib\Lib;
use Gzhegow\Calendar\Calendar;
use Gzhegow\Calendar\CalendarFactoryInterface;
use Gzhegow\Calendar\Exception\LogicException;


class CalendarParser implements CalendarParserInterface
{
    /**
     * @var CalendarFactoryInterface
     */
    protected $factory;

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

        $_dateTimeZoneIfParsed = null;
        if (null !== $dateTimeZoneIfParsed) {
            $_dateTimeZoneIfParsed = $this->parseDateTimeZone($dateTimeZoneIfParsed);

            if (null === $_dateTimeZoneIfParsed) {
                throw new LogicException(
                    [
                        'The `dateTimeZoneIfParsed` should be valid timezone',
                        $dateTimeZoneIfParsed,
                    ]
                );
            }
        }

        $dateTime = null
            ?? $this->parseDateTimeFromString($from, $_dateTimeZoneIfParsed)
            ?? $this->parseDateTimeFromStringByFormats($from, $formats, $_dateTimeZoneIfParsed);

        if (null !== $dateTime) {
            $dateTime = $this->factory->newDateTimeFromInterface($dateTime);

            return $dateTime;
        }

        return null;
    }

    public function parseDateTimeFromNumeric($from, $dateTimeZoneIfParsed = null) : ?\DateTime
    {
        if (null === $from) {
            return null;
        }

        if (is_a($from, \DateTimeInterface::class)) {
            $dateTime = $this->factory->newDateTimeFromInterface($from);

            return $dateTime;
        }

        $_dateTimeZoneIfParsed = null;
        if (null !== $dateTimeZoneIfParsed) {
            $_dateTimeZoneIfParsed = $this->parseDateTimeZone($dateTimeZoneIfParsed);

            if (null === $_dateTimeZoneIfParsed) {
                throw new LogicException(
                    [
                        'The `dateTimeZoneIfParsed` should be valid timezone',
                        $dateTimeZoneIfParsed,
                    ]
                );
            }
        }

        $dateTime = $this->parseDateTimeFromNumber($from, $_dateTimeZoneIfParsed);

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

        $_dateTimeZoneIfParsed = null;
        if (null !== $dateTimeZoneIfParsed) {
            $_dateTimeZoneIfParsed = $this->parseDateTimeZone($dateTimeZoneIfParsed);

            if (null === $_dateTimeZoneIfParsed) {
                throw new LogicException(
                    [
                        'The `dateTimeZoneIfParsed` should be valid timezone',
                        $dateTimeZoneIfParsed,
                    ]
                );
            }
        }

        $dateTimeImmutable = null
            ?? $this->parseDateTimeFromString($from, $_dateTimeZoneIfParsed)
            ?? $this->parseDateTimeFromStringByFormats($from, $formats, $_dateTimeZoneIfParsed);

        if (null !== $dateTimeImmutable) {
            $dateTimeImmutable = $this->factory->newDateTimeImmutableFromInterface($dateTimeImmutable);

            return $dateTimeImmutable;
        }

        return null;
    }

    public function parseDateTimeImmutableFromNumeric($from, $dateTimeZoneIfParsed = null) : ?\DateTimeImmutable
    {
        if (null === $from) {
            return null;
        }

        if (is_a($from, \DateTimeInterface::class)) {
            $dateTimeImmutable = $this->factory->newDateTimeImmutableFromInterface($from);

            return $dateTimeImmutable;
        }

        $_dateTimeZoneIfParsed = null;
        if (null !== $dateTimeZoneIfParsed) {
            $_dateTimeZoneIfParsed = $this->parseDateTimeZone($dateTimeZoneIfParsed);

            if (null === $_dateTimeZoneIfParsed) {
                throw new LogicException(
                    [
                        'The `dateTimeZoneIfParsed` should be valid timezone',
                        $dateTimeZoneIfParsed,
                    ]
                );
            }
        }

        $dateTimeImmutable = $this->parseDateTimeFromNumber($from, $_dateTimeZoneIfParsed);

        if (null !== $dateTimeImmutable) {
            $dateTimeImmutable = $this->factory->newDateTimeImmutableFromInterface($dateTimeImmutable);

            return $dateTimeImmutable;
        }

        return null;
    }


    protected function parseDateTimeFromNumber($num, \DateTimeZone $dateTimeZoneIfParsed = null) : ?\DateTime
    {
        if (! Lib::type()->num($_num, $num)) {
            return null;
        }

        if ($_num < 0) {
            return null;
        }

        $int = (int) $_num;
        $frac = $_num - $int;

        $dateTime = $this->factory->newDateTime(
            'now',
            $dateTimeZoneIfParsed
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

    protected function parseDateTimeFromString($string, \DateTimeZone $dateTimeZoneIfParsed = null) : ?\DateTime
    {
        if (! Lib::type()->string_not_empty($_string, $string)) {
            return null;
        }

        try {
            // > gzhegow, timezone will be ignored if format contains one
            // https://www.php.net/manual/en/datetimeimmutable.createfromformat.php
            $dateTime = $this->factory->newDateTime($_string, $dateTimeZoneIfParsed);
        }
        catch ( \Throwable $e ) {
            return null;
        }

        return $dateTime;
    }

    protected function parseDateTimeFromStringByFormats($string, array $formats = null, \DateTimeZone $dateTimeZoneIfParsed = null) : ?\DateTime
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

    protected function parseDateTimeFromStringByFormat($string, string $format, \DateTimeZone $dateTimeZoneIfParsed = null) : ?\DateTime
    {
        if (! Lib::type()->string_not_empty($_string, $string)) {
            return null;
        }

        try {
            // > gzhegow, timezone will be ignored if format contains one
            // https://www.php.net/manual/en/datetimeimmutable.createfromformat.php
            $dateTime = $this->factory->newDateTimeFromFormat(
                $format,
                $_string,
                $dateTimeZoneIfParsed
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

        $dateTimeZone = $this->parseDateTimeZoneFromStringTimezone($from);

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
            ?? $this->parseDateIntervalFromStringDuration($from)
            ?? $this->parseDateIntervalFromStringByFormats($from, $formats)
            ?? $this->parseDateIntervalFromStringDatetime($from);

        if (null !== $dateInterval) {
            return $dateInterval;
        }

        return null;
    }

    public function parseDateIntervalFromNumeric($from) : ?\DateInterval
    {
        if (null === $from) {
            return null;
        }

        if (is_a($from, \DateInterval::class)) {
            $dateInterval = $this->factory->newDateIntervalFromInstance($from);

            return $dateInterval;
        }

        $dateInterval = $this->parseDateIntervalFromNumber($from);

        if (null !== $dateInterval) {
            return $dateInterval;
        }

        return null;
    }

    protected function parseDateIntervalFromNumber($integer) : ?\DateInterval
    {
        if (! Lib::type()->num($_int, $integer)) {
            return null;
        }

        if ($_int < 0) {
            return null;
        }

        $seconds = $_int;

        $days = floor($seconds / Calendar::INTERVAL_DAY);
        $seconds -= ($days * Calendar::INTERVAL_DAY);

        $hours = floor($seconds / Calendar::INTERVAL_HOUR);
        $seconds -= ($days * Calendar::INTERVAL_HOUR);

        $minutes = floor($seconds / Calendar::INTERVAL_MINUTE);
        $seconds -= ($days * Calendar::INTERVAL_HOUR);

        $microseconds = $seconds - floor($seconds);
        $seconds -= $microseconds;

        $hasMicroseconds = ($microseconds > 0);
        if ($hasMicroseconds) {
            $microseconds = round($microseconds, 6);
        }

        $from = sprintf('P%dDT%dH%dM%dS', $days, $hours, $minutes, $seconds);

        try {
            $dateInterval = $this->factory->newDateInterval($from);

            if ($hasMicroseconds) {
                $dateInterval->f = $microseconds;
            }
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
            $dateInterval = $this->parseDateIntervalFromStringByFormatsStep(
                $_string,
                $format
            );

            if (null !== $dateInterval) {
                break;
            }
        }

        return $dateInterval;
    }

    protected function parseDateIntervalFromStringByFormatsStep($string, string $format) : ?\DateInterval
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
