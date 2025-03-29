<?php

namespace Gzhegow\Calendar;


/**
 * @template-covariant TDateTime of \DateTime
 * @template-covariant TDateTimeImmutable of \DateTimeImmutable
 * @template-covariant TDateInterval of \DateInterval
 * @template-covariant TDateTimeZone of \DateTimeZone
 */
interface CalendarInterface
{
    /**
     * @return class-string<TDateTime>
     */
    public function classDateTime() : string;

    /**
     * @return class-string<TDateTimeImmutable>
     */
    public function classDateTimeImmutable() : string;

    /**
     * @return class-string<TDateInterval>
     */
    public function classDateInterval() : string;

    /**
     * @return class-string<TDateTimeZone>
     */
    public function classDateTimeZone() : string;


    /**
     * @return TDateTime
     */
    public function dateTime($from = '', $dateTimeZone = '', array $formats = null) : \DateTime;

    /**
     * @return TDateTimeImmutable
     */
    public function dateTimeImmutable($from = '', $dateTimeZone = '', array $formats = null) : \DateTimeImmutable;

    /**
     * @return TDateTimeZone
     */
    public function dateTimeZone($from = '') : \DateTimeZone;

    /**
     * @return TDateInterval
     */
    public function dateInterval($from = '', array $formats = null) : \DateInterval;


    /**
     * @return TDateTime
     */
    public function now($dateTimeZone = '') : \DateTime;

    /**
     * @return TDateTimeImmutable
     */
    public function nowImmutable($dateTimeZone = '') : \DateTimeImmutable;


    /**
     * @return TDateTime
     */
    public function nowMidnight($dateTimeZone = '') : \DateTime;

    /**
     * @return TDateTimeImmutable
     */
    public function nowMidnightImmutable($dateTimeZone = '') : \DateTimeImmutable;


    /**
     * @return TDateTime
     */
    public function epoch($dateTimeZone = '') : \DateTime;

    /**
     * @return TDateTimeImmutable
     */
    public function epochImmutable($dateTimeZone = '') : \DateTimeImmutable;


    /**
     * @return TDateTime
     */
    public function epochMidnight($dateTimeZone = '') : \DateTime;

    /**
     * @return TDateTimeImmutable
     */
    public function epochMidnightImmutable($dateTimeZone = '') : \DateTimeImmutable;


    /**
     * @return TDateTime|null
     */
    public function parseDateTime($from, array $formats = null, $dateTimeZoneIfParsed = null) : ?\DateTime;

    /**
     * @return TDateTime|null
     */
    public function parseDateTimeFromNumeric($from, $dateTimeZoneIfParsed = null) : ?\DateTime;


    /**
     * @return TDateTimeImmutable|null
     */
    public function parseDateTimeImmutable($from, array $formats = null, $dateTimeZoneIfParsed = null) : ?\DateTimeImmutable;

    /**
     * @return TDateTimeImmutable|null
     */
    public function parseDateTimeImmutableFromNumeric($from, $dateTimeZoneIfParsed = null) : ?\DateTimeImmutable;


    /**
     * @return TDateTimeZone|null
     */
    public function parseDateTimeZone($from) : ?\DateTimeZone;


    /**
     * @return TDateInterval|null
     */
    public function parseDateInterval($from, array $formats = null) : ?\DateInterval;

    /**
     * @return TDateInterval|null
     */
    public function parseDateIntervalFromNumeric($from) : ?\DateInterval;


    public function formatTimestamp(\DateTimeInterface $dateTime) : string;

    public function formatMilliseconds(\DateTimeInterface $dateTime) : string;

    public function formatMicroseconds(\DateTimeInterface $dateTime) : string;


    public function formatSql(\DateTimeInterface $dateTime) : string;

    public function formatSqlMicroseconds(\DateTimeInterface $dateTime) : string;

    public function formatSqlMilliseconds(\DateTimeInterface $dateTime) : string;


    public function formatJavascript(\DateTimeInterface $dateTime) : string;

    public function formatJavascriptMilliseconds(\DateTimeInterface $dateTime) : string;

    public function formatJavascriptMicroseconds(\DateTimeInterface $dateTime) : string;


    public function formatAgo(\DateTimeInterface $dateTime, \DateTimeInterface $dateTimeFrom = null) : string;


    public function formatDateHuman(\DateTimeInterface $dateTime) : string;

    public function formatDateHumanDay(\DateTimeInterface $dateTime) : string;


    public function formatIntervalAgo(\DateInterval $dateInterval) : string;

    public function formatIntervalISO8601(\DateInterval $dateInterval) : string;
}
