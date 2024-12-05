<?php

namespace Gzhegow\Calendar;

interface CalendarInterface
{
    /**
     * @param callable|null $fnDateFormatter
     */
    public function setFnDateFormatter(?callable $fnDateFormatter) : void;

    /**
     * @param callable|null $fnDateIntervalFormatter
     */
    public function setFnDateIntervalFormatter(?callable $fnDateIntervalFormatter) : void;


    /**
     * @param string|\DateTimeZone $timezoneDefault
     */
    public function setTimezoneDefault($timezoneDefault) : void;

    /**
     * @param array|string[] $parseFormatsDefault
     */
    public function setParseFormatsDefault(array $parseFormatsDefault) : void;



    public function dateTime($datetime = 'now', $timezone = null) : \DateTime;

    public function dateTimeImmutable($datetime = 'now', $timezone = null) : \DateTimeImmutable;

    public function dateTimeZone($timezone = 'UTC') : \DateTimeZone;

    public function dateInterval($duration = 'P0D') : \DateInterval;


    public function now($timezone = null) : \DateTime;

    public function nowImmutable($timezone = null) : \DateTimeImmutable;


    public function parseDateTime($datetime, array $formats = null, $timezoneIfParsed = null) : ?\DateTime;

    public function parseDateTimeImmutable($datetime, array $formats = null, $timezoneIfParsed = null) : ?\DateTimeImmutable;

    public function parseDateTimeZone($timezone) : ?\DateTimeZone;

    public function parseDateInterval($interval, array $formats = null) : ?\DateInterval;


    public function diff(\DateTimeInterface $from, \DateTimeInterface $to, bool $absolute = null) : \DateInterval;


    public function formatHuman(?\DateTimeInterface $dateTime) : ?string;

    public function formatDay(?\DateTimeInterface $dateTime) : ?string;

    public function formatAgo(?\DateTimeInterface $dateTime, \DateTimeInterface $from = null) : ?string;


    public function formatTimestamp(?\DateTimeInterface $dateTime) : ?string;

    public function formatTimestampUTC(?\DateTimeInterface $dateTime) : ?string;


    public function formatMilliseconds(?\DateTimeInterface $dateTime) : ?string;

    public function formatMillisecondsUTC(?\DateTimeInterface $dateTime) : ?string;


    public function formatMicroseconds(?\DateTimeInterface $dateTime) : ?string;

    public function formatMicrosecondsUTC(?\DateTimeInterface $dateTime) : ?string;


    public function formatSql(?\DateTimeInterface $dateTime) : ?string;

    public function formatSqlUTC(?\DateTimeInterface $dateTime) : ?string;


    public function formatSqlMicroseconds(?\DateTimeInterface $dateTime) : ?string;

    public function formatSqlMicrosecondsUTC(?\DateTimeInterface $dateTime) : ?string;


    public function formatSqlMilliseconds(?\DateTimeInterface $dateTime) : ?string;

    public function formatSqlMillisecondsUTC(?\DateTimeInterface $dateTime) : ?string;


    public function formatJavascript(?\DateTimeInterface $dateTime) : ?string;

    public function formatJavascriptUTC(?\DateTimeInterface $dateTime) : ?string;


    public function formatJavascriptMilliseconds(?\DateTimeInterface $dateTime) : ?string;

    public function formatJavascriptMillisecondsUTC(?\DateTimeInterface $dateTime) : ?string;


    public function formatIntervalISO(?\DateInterval $dateInterval) : ?string;
}
