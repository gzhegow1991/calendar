<?php

namespace Gzhegow\Calendar;

interface CalendarManagerInterface
{
    public function dateTime($from = '', $dateTimeZone = '') : ?\DateTime;

    public function dateTimeImmutable($from = '', $dateTimeZone = '') : ?\DateTimeImmutable;

    public function dateTimeZone($from = '') : ?\DateTimeZone;

    public function dateInterval($from = '') : ?\DateInterval;


    public function now($dateTimeZone = '') : \DateTime;

    public function nowImmutable($dateTimeZone = '') : \DateTimeImmutable;


    public function nowMidnight($dateTimeZone = '') : \DateTime;

    public function nowMidnightImmutable($dateTimeZone = '') : \DateTimeImmutable;
}
