<?php

namespace Gzhegow\Calendar\Formatter;

interface CalendarFormatterInterface
{
    public function formatTimestamp(\DateTimeInterface $dateTime) : string;

    public function formatMilliseconds(\DateTimeInterface $dateTime) : string;

    public function formatMicroseconds(\DateTimeInterface $dateTime) : string;


    public function formatSql(\DateTimeInterface $dateTime) : string;

    public function formatSqlMicroseconds(\DateTimeInterface $dateTime) : string;

    public function formatSqlMilliseconds(?\DateTimeInterface $dateTime) : string;


    public function formatJavascript(\DateTimeInterface $dateTime) : string;

    public function formatJavascriptMilliseconds(\DateTimeInterface $dateTime) : string;

    public function formatJavascriptMicroseconds(\DateTimeInterface $dateTime) : string;


    public function formatAgo(\DateTimeInterface $dateTime, \DateTimeInterface $dateTimeFrom = null) : string;


    public function formatDateHuman(\DateTimeInterface $dateTime) : string;

    public function formatDateHumanDay(\DateTimeInterface $dateTime) : string;


    public function formatIntervalISO8601(\DateInterval $dateInterval) : string;

    public function formatIntervalAgo(\DateInterval $dateInterval) : string;
}
