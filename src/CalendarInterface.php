<?php

namespace Gzhegow\Calendar;

use Gzhegow\Calendar\Parser\CalendarParserInterface;
use Gzhegow\Calendar\Manager\CalendarManagerInterface;
use Gzhegow\Calendar\Formatter\CalendarFormatterInterface;


interface CalendarInterface
{
    public function getParser() : CalendarParserInterface;

    public function getManager() : CalendarManagerInterface;

    public function getFormatter() : CalendarFormatterInterface;


    public function dateTime($from = '', $dateTimeZone = '', array $formats = null) : \DateTime;

    public function dateTimeImmutable($from = '', $dateTimeZone = '', array $formats = null) : \DateTimeImmutable;

    public function dateTimeZone($from = '') : \DateTimeZone;

    public function dateInterval($from = '', array $formats = null) : \DateInterval;


    public function now($dateTimeZone = '') : \DateTime;

    public function nowImmutable($dateTimeZone = '') : \DateTimeImmutable;


    public function nowMidnight($dateTimeZone = '') : \DateTime;

    public function nowMidnightImmutable($dateTimeZone = '') : \DateTimeImmutable;


    public function parseDateTime($from, array $formats = null, $dateTimeZoneIfParsed = null) : ?\DateTime;

    public function parseDateTimeImmutable($from, array $formats = null, $dateTimeZoneIfParsed = null) : ?\DateTimeImmutable;

    public function parseDateTimeZone($from) : ?\DateTimeZone;

    public function parseDateInterval($from, array $formats = null) : ?\DateInterval;


    public function formatTimestamp(\DateTimeInterface $dateTime) : string;

    public function formatTimestampUTC(\DateTimeInterface $dateTime) : string;

    public function formatMilliseconds(\DateTimeInterface $dateTime) : string;

    public function formatMillisecondsUTC(\DateTimeInterface $dateTime) : string;

    public function formatMicroseconds(\DateTimeInterface $dateTime) : string;

    public function formatMicrosecondsUTC(\DateTimeInterface $dateTime) : string;

    public function formatSql(\DateTimeInterface $dateTime) : string;

    public function formatSqlUTC(\DateTimeInterface $dateTime) : string;

    public function formatSqlMicroseconds(\DateTimeInterface $dateTime) : string;

    public function formatSqlMicrosecondsUTC(\DateTimeInterface $dateTime) : string;

    public function formatSqlMilliseconds(\DateTimeInterface $dateTime) : string;

    public function formatSqlMillisecondsUTC(\DateTimeInterface $dateTime) : string;

    public function formatJavascript(\DateTimeInterface $dateTime) : string;

    public function formatJavascriptUTC(\DateTimeInterface $dateTime) : string;

    public function formatJavascriptMilliseconds(\DateTimeInterface $dateTime) : string;

    public function formatJavascriptMillisecondsUTC(\DateTimeInterface $dateTime) : string;

    public function formatJavascriptMicroseconds(\DateTimeInterface $dateTime) : string;

    public function formatJavascriptMicrosecondsUTC(\DateTimeInterface $dateTime) : string;

    public function formatHumanDate(\DateTimeInterface $dateTime) : string;

    public function formatHumanDay(\DateTimeInterface $dateTime) : string;

    public function formatIntervalISO(\DateInterval $dateInterval) : string;

    public function formatIntervalAgo(\DateInterval $dateInterval) : string;

    public function formatAgo(\DateTimeInterface $dateTime, \DateTimeInterface $dateTimeFrom = null) : string;
}
