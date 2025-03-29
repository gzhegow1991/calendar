<?php

namespace Gzhegow\Calendar;

use Gzhegow\Calendar\Parser\CalendarParserInterface;
use Gzhegow\Calendar\Manager\CalendarManagerInterface;
use Gzhegow\Calendar\Formatter\CalendarFormatterInterface;


/**
 * @template-covariant TDateTime of \DateTime
 * @template-covariant TDateTimeImmutable of \DateTimeImmutable
 * @template-covariant TDateInterval of \DateInterval
 * @template-covariant TDateTimeZone of \DateTimeZone
 */
class CalendarFacade implements CalendarInterface
{
    /**
     * @var CalendarFactoryInterface
     */
    protected $factory;
    /**
     * @var CalendarType
     */
    protected $type;

    /**
     * @var CalendarParserInterface
     */
    protected $parser;
    /**
     * @var CalendarManagerInterface
     */
    protected $manager;
    /**
     * @var CalendarFormatterInterface
     */
    protected $formatter;

    /**
     * @var CalendarConfig
     */
    protected $config;


    public function __construct(
        CalendarFactoryInterface $factory,
        CalendarType $type,
        //
        CalendarParserInterface $parser,
        CalendarManagerInterface $manager,
        CalendarFormatterInterface $formatter,
        //
        CalendarConfig $config
    )
    {
        $this->factory = $factory;
        $this->type = $type;

        $this->parser = $parser;
        $this->manager = $manager;
        $this->formatter = $formatter;

        $this->config = $config;
        $this->config->validate();
    }


    /**
     * @param class-string<TDateTime>|null $className
     *
     * @return class-string<TDateTime>
     */
    public function classDateTime(string $className = null) : string
    {
        return $this->type->classDateTime($className);
    }

    /**
     * @param class-string<TDateTimeImmutable>|null $className
     *
     * @return class-string<TDateTimeImmutable>
     */
    public function classDateTimeImmutable(string $className = null) : string
    {
        return $this->type->classDateTimeImmutable($className);
    }

    /**
     * @param class-string<TDateInterval>|null $className
     *
     * @return class-string<TDateInterval>
     */
    public function classDateInterval(string $className = null) : string
    {
        return $this->type->classDateInterval($className);
    }

    /**
     * @param class-string<TDateTimeZone>|null $className
     *
     * @return class-string<TDateTimeZone>
     */
    public function classDateTimeZone(string $className = null) : string
    {
        return $this->type->classDateTimeZone($className);
    }


    /**
     * @return TDateTime
     */
    public function dateTime($from = '', $dateTimeZone = '', array $formats = null) : \DateTime
    {
        return $this->manager->dateTime($from, $dateTimeZone, $formats);
    }

    /**
     * @return TDateTimeImmutable
     */
    public function dateTimeImmutable($from = '', $dateTimeZone = '', array $formats = null) : \DateTimeImmutable
    {
        return $this->manager->dateTimeImmutable($from, $dateTimeZone, $formats);
    }

    /**
     * @return TDateTimeZone
     */
    public function dateTimeZone($from = '') : \DateTimeZone
    {
        return $this->manager->dateTimeZone($from);
    }

    /**
     * @return TDateInterval
     */
    public function dateInterval($from = '', array $formats = null) : \DateInterval
    {
        return $this->manager->dateInterval($from, $formats);
    }


    /**
     * @return TDateTime
     */
    public function now($dateTimeZone = '') : \DateTime
    {
        return $this->manager->now($dateTimeZone);
    }

    /**
     * @return TDateTimeImmutable
     */
    public function nowImmutable($dateTimeZone = '') : \DateTimeImmutable
    {
        return $this->manager->nowImmutable($dateTimeZone);
    }


    /**
     * @return TDateTime
     */
    public function nowMidnight($dateTimeZone = '') : \DateTime
    {
        return $this->manager->nowMidnight($dateTimeZone);
    }

    /**
     * @return TDateTimeImmutable
     */
    public function nowMidnightImmutable($dateTimeZone = '') : \DateTimeImmutable
    {
        return $this->manager->nowMidnightImmutable($dateTimeZone);
    }


    /**
     * @return TDateTime
     */
    public function epoch($dateTimeZone = '') : \DateTime
    {
        return $this->manager->epoch($dateTimeZone);
    }

    /**
     * @return TDateTimeImmutable
     */
    public function epochImmutable($dateTimeZone = '') : \DateTimeImmutable
    {
        return $this->manager->epochImmutable($dateTimeZone);
    }


    /**
     * @return TDateTime
     */
    public function epochMidnight($dateTimeZone = '') : \DateTime
    {
        return $this->manager->epochMidnight($dateTimeZone);
    }

    /**
     * @return TDateTimeImmutable
     */
    public function epochMidnightImmutable($dateTimeZone = '') : \DateTimeImmutable
    {
        return $this->manager->epochMidnightImmutable($dateTimeZone);
    }


    /**
     * @return TDateTime|null
     */
    public function parseDateTime($from, array $formats = null, $dateTimeZoneIfParsed = null) : ?\DateTime
    {
        return $this->parser->parseDateTime($from, $formats, $dateTimeZoneIfParsed);
    }

    /**
     * @return TDateTime|null
     */
    public function parseDateTimeFromNumeric($from, $dateTimeZoneIfParsed = null) : ?\DateTime
    {
        return $this->parser->parseDateTimeFromNumeric($from, $dateTimeZoneIfParsed);
    }


    /**
     * @return TDateTimeImmutable|null
     */
    public function parseDateTimeImmutable($from, array $formats = null, $dateTimeZoneIfParsed = null) : ?\DateTimeImmutable
    {
        return $this->parser->parseDateTimeImmutable($from, $formats, $dateTimeZoneIfParsed);
    }

    /**
     * @return TDateTimeImmutable|null
     */
    public function parseDateTimeImmutableFromNumeric($from, $dateTimeZoneIfParsed = null) : ?\DateTimeImmutable
    {
        return $this->parser->parseDateTimeImmutableFromNumeric($from, $dateTimeZoneIfParsed);
    }


    /**
     * @return TDateTimeZone|null
     */
    public function parseDateTimeZone($from) : ?\DateTimeZone
    {
        return $this->parser->parseDateTimeZone($from);
    }


    /**
     * @return TDateInterval|null
     */
    public function parseDateInterval($from, array $formats = null) : ?\DateInterval
    {
        return $this->parser->parseDateInterval($from, $formats);
    }

    /**
     * @return TDateInterval|null
     */
    public function parseDateIntervalFromNumeric($from) : ?\DateInterval
    {
        return $this->parser->parseDateIntervalFromNumeric($from);
    }


    public function formatTimestamp(\DateTimeInterface $dateTime) : string
    {
        return $this->formatter->formatTimestamp($dateTime);
    }

    public function formatMilliseconds(\DateTimeInterface $dateTime) : string
    {
        return $this->formatter->formatMilliseconds($dateTime);
    }

    public function formatMicroseconds(\DateTimeInterface $dateTime) : string
    {
        return $this->formatter->formatMicroseconds($dateTime);
    }


    public function formatSql(\DateTimeInterface $dateTime) : string
    {
        return $this->formatter->formatSql($dateTime);
    }

    public function formatSqlMicroseconds(\DateTimeInterface $dateTime) : string
    {
        return $this->formatter->formatSqlMicroseconds($dateTime);
    }

    public function formatSqlMilliseconds(\DateTimeInterface $dateTime) : string
    {
        return $this->formatter->formatSqlMilliseconds($dateTime);
    }


    public function formatJavascript(\DateTimeInterface $dateTime) : string
    {
        return $this->formatter->formatJavascript($dateTime);
    }

    public function formatJavascriptMilliseconds(\DateTimeInterface $dateTime) : string
    {
        return $this->formatter->formatJavascriptMilliseconds($dateTime);
    }

    public function formatJavascriptMicroseconds(\DateTimeInterface $dateTime) : string
    {
        return $this->formatter->formatJavascriptMicroseconds($dateTime);
    }


    public function formatAgo(
        \DateTimeInterface $dateTime,
        \DateTimeInterface $dateTimeFrom = null
    ) : string
    {
        return $this->formatter->formatAgo($dateTime, $dateTimeFrom);
    }


    public function formatDateHuman(\DateTimeInterface $dateTime) : string
    {
        return $this->formatter->formatDateHuman($dateTime);
    }

    public function formatDateHumanDay(\DateTimeInterface $dateTime) : string
    {
        return $this->formatter->formatDateHumanDay($dateTime);
    }


    public function formatIntervalISO8601(\DateInterval $dateInterval) : string
    {
        return $this->formatter->formatIntervalISO8601($dateInterval);
    }

    public function formatIntervalAgo(\DateInterval $dateInterval) : string
    {
        return $this->formatter->formatIntervalAgo($dateInterval);
    }
}
