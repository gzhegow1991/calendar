<?php

namespace Gzhegow\Calendar;

/**
 * @template-covariant TDateTime of \DateTime
 * @template-covariant TDateTimeImmutable of \DateTimeImmutable
 * @template-covariant TDateInterval of \DateInterval
 * @template-covariant TDateTimeZone of \DateTimeZone
 */
interface CalendarFactoryInterface
{
    /**
     * @return TDateTime
     */
    public function newDateTime($from = 'now', \DateTimeZone $dateTimeZone = null) : \DateTime;

    /**
     * @return TDateTime
     */
    public function newDateTimeFromInterface(\DateTimeInterface $object) : \DateTime;

    /**
     * @return TDateTime
     */
    public function newDateTimeFromFormat(string $format, string $datetimeStringFormatted, \DateTimeZone $dateTimeZoneIfParsed = null) : \DateTime;


    /**
     * @return TDateTimeImmutable
     */
    public function newDateTimeImmutable($from = 'now', \DateTimeZone $dateTimeZone = null) : \DateTimeImmutable;

    /**
     * @return TDateTimeImmutable
     */
    public function newDateTimeImmutableFromInterface(\DateTimeInterface $object) : \DateTimeImmutable;

    /**
     * @return TDateTimeImmutable
     */
    public function newDateTimeImmutableFromFormat(string $format, string $dateTimeStringFormatted, \DateTimeZone $dateTimeZoneIfParsed = null) : \DateTimeImmutable;


    /**
     * @return TDateTimeZone
     */
    public function newDateTimeZone($from = 'UTC') : \DateTimeZone;

    /**
     * @return TDateTimeZone
     */
    public function newDateTimeZoneFromInstance(\DateTimeZone $instance) : \DateTimeZone;


    /**
     * @return TDateInterval
     */
    public function newDateInterval($from = 'P0D') : \DateInterval;

    /**
     * @return TDateInterval
     */
    public function newDateIntervalFromInstance(\DateInterval $instance) : \DateInterval;

    /**
     * @return TDateInterval
     */
    public function newDateIntervalFromDateString(string $dateString) : \DateInterval;
}
