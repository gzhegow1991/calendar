<?php

namespace Gzhegow\Calendar;


/**
 * @template-covariant TDateTime of \DateTime
 * @template-covariant TDateTimeImmutable of \DateTimeImmutable
 * @template-covariant TDateInterval of \DateInterval
 * @template-covariant TDateTimeZone of \DateTimeZone
 */
class Calendar
{
    const INTERVAL_MINUTE = 60;
    const INTERVAL_HOUR   = 3600;
    const INTERVAL_DAY    = 86400;
    const INTERVAL_WEEK   = 604800;
    const INTERVAL_MONTH  = 2592000;
    const INTERVAL_YEAR   = 31536000;

    const FORMAT_FILENAME_DATE                  = 'ymd';
    const FORMAT_FILENAME_DATETIME              = 'ymd_His';
    const FORMAT_FILENAME_DATETIME_MICROSECONDS = 'ymd_His_u';
    const FORMAT_FILENAME_DATETIME_MILLISECONDS = 'ymd_His_v';
    const FORMAT_FILENAME_DAY                   = 'ymd_000000';
    const FORMAT_FILENAME_HOUR                  = 'ymd_H0000';
    const FORMAT_FILENAME_MINUTE                = 'ymd_Hi00';

    const FORMAT_HUMAN      = DATE_RSS;
    const FORMAT_HUMAN_DATE = "D, d M Y H:i:s O";
    const FORMAT_HUMAN_DAY  = "D, d M Y O";

    const FORMAT_JAVASCRIPT              = DATE_ATOM;
    const FORMAT_JAVASCRIPT_MICROSECONDS = "Y-m-d\TH:i:s.uP";
    const FORMAT_JAVASCRIPT_MILLISECONDS = "Y-m-d\TH:i:s.vP";

    const FORMAT_SQL                       = self::FORMAT_SQL_DATETIME;
    const FORMAT_SQL_DATE                  = 'Y-m-d';
    const FORMAT_SQL_DATETIME              = 'Y-m-d H:i:s';
    const FORMAT_SQL_DATETIME_MICROSECONDS = 'Y-m-d H:i:s.u';
    const FORMAT_SQL_DATETIME_MILLISECONDS = 'Y-m-d H:i:s.v';
    const FORMAT_SQL_DAY                   = 'Y-m-d 00:00:00';
    const FORMAT_SQL_HOUR                  = 'Y-m-d H:00:00';
    const FORMAT_SQL_MINUTE                = 'Y-m-d H:i:00';
    const FORMAT_SQL_MICROSECONDS          = self::FORMAT_SQL_DATETIME_MICROSECONDS;
    const FORMAT_SQL_MILLISECONDS          = self::FORMAT_SQL_DATETIME_MILLISECONDS;
    const FORMAT_SQL_TIME                  = 'H:i:s';
    const FORMAT_SQL_TIME_MICROSECONDS     = 'H:i:s.u';
    const FORMAT_SQL_TIME_MILLISECONDS     = 'H:i:s.v';


    const LIST_INTERVAL = [
        self::INTERVAL_MINUTE => true,
        self::INTERVAL_HOUR   => true,
        self::INTERVAL_DAY    => true,
        self::INTERVAL_WEEK   => true,
        self::INTERVAL_MONTH  => true,
        self::INTERVAL_YEAR   => true,
    ];

    const LIST_FORMAT = [
        // self::FORMAT_HUMAN      => true,

        // self::FORMAT_SQL                            => true,
        // self::FORMAT_SQL_MICROSECONDS               => true,
        // self::FORMAT_SQL_MILLISECONDS               => true,

        self::FORMAT_FILENAME_DATE                  => true,
        self::FORMAT_FILENAME_DATETIME              => true,
        self::FORMAT_FILENAME_DATETIME_MICROSECONDS => true,
        self::FORMAT_FILENAME_DATETIME_MILLISECONDS => true,
        self::FORMAT_FILENAME_DAY                   => true,
        self::FORMAT_FILENAME_HOUR                  => true,

        self::FORMAT_HUMAN_DATE => true,
        self::FORMAT_HUMAN_DAY  => true,

        self::FORMAT_JAVASCRIPT              => true,
        self::FORMAT_JAVASCRIPT_MILLISECONDS => true,

        self::FORMAT_SQL_DATE                  => true,
        self::FORMAT_SQL_DATETIME              => true,
        self::FORMAT_SQL_DATETIME_MICROSECONDS => true,
        self::FORMAT_SQL_DATETIME_MILLISECONDS => true,
        self::FORMAT_SQL_DAY                   => true,
        self::FORMAT_SQL_HOUR                  => true,
        self::FORMAT_SQL_TIME                  => true,
    ];


    /**
     * @param class-string<TDateTime>|null $className
     *
     * @return class-string<TDateTime>
     */
    public static function classDateTime(string $className = null) : string
    {
        return static::$facade->classDateTime($className);
    }

    /**
     * @param class-string<TDateTimeImmutable>|null $className
     *
     * @return class-string<TDateTimeImmutable>
     */
    public static function classDateTimeImmutable(string $className = null) : string
    {
        return static::$facade->classDateTimeImmutable($className);
    }

    /**
     * @param class-string<TDateInterval>|null $className
     *
     * @return class-string<TDateInterval>
     */
    public static function classDateInterval(string $className = null) : string
    {
        return static::$facade->classDateInterval($className);
    }

    /**
     * @param class-string<TDateTimeZone>|null $className
     *
     * @return class-string<TDateTimeZone>
     */
    public static function classDateTimeZone(string $className = null) : string
    {
        return static::$facade->classDateTimeZone($className);
    }


    /**
     * @return TDateTime
     */
    public static function dateTime($from = '', $dateTimeZone = '', array $formats = null) : \DateTime
    {
        return static::$facade->dateTime($from, $dateTimeZone, $formats);
    }

    /**
     * @return TDateTimeImmutable
     */
    public static function dateTimeImmutable($from = '', $dateTimeZone = '', array $formats = null) : \DateTimeImmutable
    {
        return static::$facade->dateTimeImmutable($from, $dateTimeZone, $formats);
    }

    /**
     * @return TDateTimeZone
     */
    public static function dateTimeZone($from = '') : \DateTimeZone
    {
        return static::$facade->dateTimeZone($from);
    }

    /**
     * @return TDateInterval
     */
    public static function dateInterval($from = '', array $formats = null) : \DateInterval
    {
        return static::$facade->dateInterval($from, $formats);
    }


    /**
     * @return TDateTime
     */
    public static function now($dateTimeZone = '') : \DateTime
    {
        return static::$facade->now($dateTimeZone);
    }

    /**
     * @return TDateTimeImmutable
     */
    public static function nowImmutable($dateTimeZone = '') : \DateTimeImmutable
    {
        return static::$facade->nowImmutable($dateTimeZone);
    }


    /**
     * @return TDateTime
     */
    public static function nowMidnight($dateTimeZone = '') : \DateTime
    {
        return static::$facade->nowMidnight($dateTimeZone);
    }

    /**
     * @return TDateTimeImmutable
     */
    public static function nowMidnightImmutable($dateTimeZone = '') : \DateTimeImmutable
    {
        return static::$facade->nowMidnightImmutable($dateTimeZone);
    }


    /**
     * @return TDateTime
     */
    public static function epoch($dateTimeZone = '') : \DateTime
    {
        return static::$facade->now($dateTimeZone);
    }

    /**
     * @return TDateTimeImmutable
     */
    public static function epochImmutable($dateTimeZone = '') : \DateTimeImmutable
    {
        return static::$facade->nowImmutable($dateTimeZone);
    }


    /**
     * @return TDateTime
     */
    public static function epochMidnight($dateTimeZone = '') : \DateTime
    {
        return static::$facade->nowMidnight($dateTimeZone);
    }

    /**
     * @return TDateTimeImmutable
     */
    public static function epochMidnightImmutable($dateTimeZone = '') : \DateTimeImmutable
    {
        return static::$facade->nowMidnightImmutable($dateTimeZone);
    }


    /**
     * @return TDateTime|null
     */
    public static function parseDateTime($from, array $formats = null, $dateTimeZoneIfParsed = null) : ?\DateTime
    {
        return static::$facade->parseDateTime($from, $formats, $dateTimeZoneIfParsed);
    }

    /**
     * @return TDateTime|null
     */
    public function parseDateTimeFromNumeric($from, $dateTimeZoneIfParsed = null) : ?\DateTime
    {
        return static::$facade->parseDateTimeFromNumeric($from, $dateTimeZoneIfParsed);
    }


    /**
     * @return TDateTimeImmutable|null
     */
    public static function parseDateTimeImmutable($from, array $formats = null, $dateTimeZoneIfParsed = null) : ?\DateTimeImmutable
    {
        return static::$facade->parseDateTimeImmutable($from, $formats, $dateTimeZoneIfParsed);
    }

    /**
     * @return TDateTimeImmutable|null
     */
    public function parseDateTimeImmutableFromNumeric($from, $dateTimeZoneIfParsed = null) : ?\DateTimeImmutable
    {
        return static::$facade->parseDateTimeImmutableFromNumeric($from, $dateTimeZoneIfParsed);
    }


    /**
     * @return TDateTimeZone|null
     */
    public static function parseDateTimeZone($from) : ?\DateTimeZone
    {
        return static::$facade->parseDateTimeZone($from);
    }


    /**
     * @return TDateInterval|null
     */
    public static function parseDateInterval($from, array $formats = null) : ?\DateInterval
    {
        return static::$facade->parseDateInterval($from, $formats);
    }

    /**
     * @return TDateInterval|null
     */
    public function parseDateIntervalFromNumeric($from) : ?\DateInterval
    {
        return static::$facade->parseDateIntervalFromNumeric($from);
    }


    public static function formatTimestamp(\DateTimeInterface $dateTime) : string
    {
        return static::$facade->formatTimestamp($dateTime);
    }

    public static function formatMilliseconds(\DateTimeInterface $dateTime) : string
    {
        return static::$facade->formatMilliseconds($dateTime);
    }

    public static function formatMicroseconds(\DateTimeInterface $dateTime) : string
    {
        return static::$facade->formatMicroseconds($dateTime);
    }


    public static function formatSql(\DateTimeInterface $dateTime) : string
    {
        return static::$facade->formatSql($dateTime);
    }

    public static function formatSqlMicroseconds(\DateTimeInterface $dateTime) : string
    {
        return static::$facade->formatSqlMicroseconds($dateTime);
    }

    public static function formatSqlMilliseconds(\DateTimeInterface $dateTime) : string
    {
        return static::$facade->formatSqlMilliseconds($dateTime);
    }


    public static function formatJavascript(\DateTimeInterface $dateTime) : string
    {
        return static::$facade->formatJavascript($dateTime);
    }

    public static function formatJavascriptMilliseconds(\DateTimeInterface $dateTime) : string
    {
        return static::$facade->formatJavascriptMilliseconds($dateTime);
    }

    public static function formatJavascriptMicroseconds(\DateTimeInterface $dateTime) : string
    {
        return static::$facade->formatJavascriptMicroseconds($dateTime);
    }


    public static function formatAgo(\DateTimeInterface $dateTime, \DateTimeInterface $dateTimeFrom = null) : string
    {
        return static::$facade->formatAgo($dateTime, $dateTimeFrom);
    }


    public static function formatHumanDate(\DateTimeInterface $dateTime) : string
    {
        return static::$facade->formatDateHuman($dateTime);
    }

    public static function formatHumanDay(\DateTimeInterface $dateTime) : string
    {
        return static::$facade->formatDateHumanDay($dateTime);
    }


    public static function formatIntervalISO(\DateInterval $dateInterval) : string
    {
        return static::$facade->formatIntervalISO8601($dateInterval);
    }

    public static function formatIntervalAgo(\DateInterval $dateInterval) : string
    {
        return static::$facade->formatIntervalAgo($dateInterval);
    }


    public static function setFacade(CalendarInterface $facade) : ?CalendarInterface
    {
        $last = static::$facade;

        static::$facade = $facade;

        return $last;
    }

    /**
     * @var CalendarInterface
     */
    protected static $facade;
}
