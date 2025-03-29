<?php

namespace Gzhegow\Calendar\Manager;

interface CalendarManagerInterface
{
    public function dateTime($from = '', $dateTimeZone = '', array $formats = null) : ?\DateTime;

    public function dateTimeImmutable($from = '', $dateTimeZone = '', array $formats = null) : ?\DateTimeImmutable;

    public function dateTimeZone($from = '') : ?\DateTimeZone;

    public function dateInterval($from = '', array $formats = null) : ?\DateInterval;


    public function now($dateTimeZone = '') : \DateTime;

    public function nowImmutable($dateTimeZone = '') : \DateTimeImmutable;


    public function nowMidnight($dateTimeZone = '') : \DateTime;

    public function nowMidnightImmutable($dateTimeZone = '') : \DateTimeImmutable;


    public function epoch($dateTimeZone = '') : \DateTime;

    public function epochImmutable($dateTimeZone = '') : \DateTimeImmutable;


    public function epochMidnight($dateTimeZone = '') : \DateTime;

    public function epochMidnightImmutable($dateTimeZone = '') : \DateTimeImmutable;
}
