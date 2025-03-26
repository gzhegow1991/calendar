<?php

namespace Gzhegow\Calendar;

use Gzhegow\Calendar\Type\CalendarType;
use Gzhegow\Calendar\Parser\CalendarParserInterface;
use Gzhegow\Calendar\Manager\CalendarManagerInterface;
use Gzhegow\Calendar\Formatter\CalendarFormatterInterface;


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


    public function getParser() : CalendarParserInterface
    {
        return $this->parser;
    }

    public function getManager() : CalendarManagerInterface
    {
        return $this->manager;
    }

    public function getFormatter() : CalendarFormatterInterface
    {
        return $this->formatter;
    }


    /**
     * @return class-string<\DateTime>
     */
    public function classDateTime() : string
    {
        return $this->type->classDateTime();
    }

    /**
     * @return class-string<\DateTimeImmutable>
     */
    public function classDateTimeImmutable() : string
    {
        return $this->type->classDateTimeImmutable();
    }

    /**
     * @return class-string<\DateInterval>
     */
    public function classDateInterval() : string
    {
        return $this->type->classDateInterval();
    }

    /**
     * @return class-string<\DateTimeZone>
     */
    public function classDateTimeZone() : string
    {
        return $this->type->classDateTimeZone();
    }


    public function dateTime($from = '', $dateTimeZone = '', array $formats = null) : \DateTime
    {
        return $this->manager->dateTime($from, $dateTimeZone, $formats);
    }

    public function dateTimeImmutable($from = '', $dateTimeZone = '', array $formats = null) : \DateTimeImmutable
    {
        return $this->manager->dateTimeImmutable($from, $dateTimeZone, $formats);
    }

    public function dateTimeZone($from = '') : \DateTimeZone
    {
        return $this->manager->dateTimeZone($from);
    }

    public function dateInterval($from = '', array $formats = null) : \DateInterval
    {
        return $this->manager->dateInterval($from, $formats);
    }


    public function now($dateTimeZone = '') : \DateTime
    {
        return $this->manager->now($dateTimeZone);
    }

    public function nowImmutable($dateTimeZone = '') : \DateTimeImmutable
    {
        return $this->manager->nowImmutable($dateTimeZone);
    }


    public function nowMidnight($dateTimeZone = '') : \DateTime
    {
        return $this->manager->nowMidnight($dateTimeZone);
    }

    public function nowMidnightImmutable($dateTimeZone = '') : \DateTimeImmutable
    {
        return $this->manager->nowMidnightImmutable($dateTimeZone);
    }


    public function parseDateTime($from, array $formats = null, $dateTimeZoneIfParsed = null) : ?\DateTime
    {
        return $this->parser->parseDateTime($from, $formats, $dateTimeZoneIfParsed);
    }

    public function parseDateTimeFromNumeric($from, $dateTimeZoneIfParsed = null) : ?\DateTime
    {
        return $this->parser->parseDateTimeFromNumeric($from, $dateTimeZoneIfParsed);
    }


    public function parseDateTimeImmutable($from, array $formats = null, $dateTimeZoneIfParsed = null) : ?\DateTimeImmutable
    {
        return $this->parser->parseDateTimeImmutable($from, $formats, $dateTimeZoneIfParsed);
    }

    public function parseDateTimeImmutableFromNumeric($from, $dateTimeZoneIfParsed = null) : ?\DateTimeImmutable
    {
        return $this->parser->parseDateTimeImmutableFromNumeric($from, $dateTimeZoneIfParsed);
    }


    public function parseDateTimeZone($from) : ?\DateTimeZone
    {
        return $this->parser->parseDateTimeZone($from);
    }


    public function parseDateInterval($from, array $formats = null) : ?\DateInterval
    {
        return $this->parser->parseDateInterval($from, $formats);
    }

    public function parseDateIntervalFromNumeric($from) : ?\DateInterval
    {
        return $this->parser->parseDateIntervalFromNumeric($from);
    }


    public function formatTimestamp(\DateTimeInterface $dateTime) : string
    {
        return $this->formatter->formatTimestamp($dateTime);
    }

    public function formatTimestampUTC(\DateTimeInterface $dateTime) : string
    {
        return $this->formatter->formatTimestampUTC($dateTime);
    }


    public function formatMilliseconds(\DateTimeInterface $dateTime) : string
    {
        return $this->formatter->formatMilliseconds($dateTime);
    }

    public function formatMillisecondsUTC(\DateTimeInterface $dateTime) : string
    {
        return $this->formatter->formatMillisecondsUTC($dateTime);
    }


    public function formatMicroseconds(\DateTimeInterface $dateTime) : string
    {
        return $this->formatter->formatMicroseconds($dateTime);
    }

    public function formatMicrosecondsUTC(\DateTimeInterface $dateTime) : string
    {
        return $this->formatter->formatMicrosecondsUTC($dateTime);
    }


    public function formatSql(\DateTimeInterface $dateTime) : string
    {
        return $this->formatter->formatSql($dateTime);
    }

    public function formatSqlUTC(\DateTimeInterface $dateTime) : string
    {
        return $this->formatter->formatSqlUTC($dateTime);
    }


    public function formatSqlMicroseconds(\DateTimeInterface $dateTime) : string
    {
        return $this->formatter->formatSqlMicroseconds($dateTime);
    }

    public function formatSqlMicrosecondsUTC(\DateTimeInterface $dateTime) : string
    {
        return $this->formatter->formatSqlMicrosecondsUTC($dateTime);
    }


    public function formatSqlMilliseconds(\DateTimeInterface $dateTime) : string
    {
        return $this->formatter->formatSqlMilliseconds($dateTime);
    }

    public function formatSqlMillisecondsUTC(\DateTimeInterface $dateTime) : string
    {
        return $this->formatter->formatSqlMillisecondsUTC($dateTime);
    }


    public function formatJavascript(\DateTimeInterface $dateTime) : string
    {
        return $this->formatter->formatJavascript($dateTime);
    }

    public function formatJavascriptUTC(\DateTimeInterface $dateTime) : string
    {
        return $this->formatter->formatJavascriptUTC($dateTime);
    }


    public function formatJavascriptMilliseconds(\DateTimeInterface $dateTime) : string
    {
        return $this->formatter->formatJavascriptMilliseconds($dateTime);
    }

    public function formatJavascriptMillisecondsUTC(\DateTimeInterface $dateTime) : string
    {
        return $this->formatter->formatJavascriptMillisecondsUTC($dateTime);
    }


    public function formatJavascriptMicroseconds(\DateTimeInterface $dateTime) : string
    {
        return $this->formatter->formatJavascriptMicroseconds($dateTime);
    }

    public function formatJavascriptMicrosecondsUTC(\DateTimeInterface $dateTime) : string
    {
        return $this->formatter->formatJavascriptMicrosecondsUTC($dateTime);
    }


    public function formatHumanDate(\DateTimeInterface $dateTime) : string
    {
        return $this->formatter->formatHumanDate($dateTime);
    }

    public function formatHumanDay(\DateTimeInterface $dateTime) : string
    {
        return $this->formatter->formatHumanDay($dateTime);
    }


    public function formatIntervalISO(\DateInterval $dateInterval) : string
    {
        return $this->formatter->formatIntervalISO($dateInterval);
    }

    public function formatIntervalAgo(\DateInterval $dateInterval) : string
    {
        return $this->formatter->formatIntervalAgo($dateInterval);
    }


    public function formatAgo(\DateTimeInterface $dateTime, \DateTimeInterface $dateTimeFrom = null) : string
    {
        return $this->formatter->formatAgo($dateTime, $dateTimeFrom);
    }
}
