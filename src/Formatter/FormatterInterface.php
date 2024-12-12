<?php

namespace Gzhegow\Calendar\Formatter;

interface FormatterInterface
{
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

    public function formatSqlMilliseconds(?\DateTimeInterface $dateTime) : string;

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
