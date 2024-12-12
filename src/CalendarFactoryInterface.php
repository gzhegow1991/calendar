<?php

namespace Gzhegow\Calendar;

interface CalendarFactoryInterface
{
    public function newDateTime($from = 'now', \DateTimeZone $dateTimeZone = null) : \DateTime;

    public function newDateTimeFromInterface(\DateTimeInterface $object) : \DateTime;

    public function newDateTimeFromFormat(string $format, string $datetimeStringFormatted, \DateTimeZone $dateTimeZoneIfParsed = null) : \DateTime;


    public function newDateTimeImmutable($from = 'now', \DateTimeZone $dateTimeZone = null) : \DateTimeImmutable;

    public function newDateTimeImmutableFromInterface(\DateTimeInterface $object) : \DateTimeImmutable;

    public function newDateTimeImmutableFromFormat(string $format, string $dateTimeStringFormatted, \DateTimeZone $dateTimeZoneIfParsed = null) : \DateTimeImmutable;


    public function newDateTimeZone($from = 'UTC') : \DateTimeZone;

    public function newDateTimeZoneFromInstance(\DateTimeZone $instance) : \DateTimeZone;


    public function newDateInterval($from = 'P0D') : \DateInterval;

    public function newDateIntervalFromInstance(\DateInterval $instance) : \DateInterval;

    public function newDateIntervalFromDateString(string $dateString) : \DateInterval;
}
