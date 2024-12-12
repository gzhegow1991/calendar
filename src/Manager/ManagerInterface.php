<?php

namespace Gzhegow\Calendar\Manager;

interface ManagerInterface
{
    public function dateTime($from = '', $dateTimeZone = '', array $formats = null) : ?\DateTime;

    public function dateTimeImmutable($from = '', $dateTimeZone = '', array $formats = null) : ?\DateTimeImmutable;

    public function dateTimeZone($from = '') : ?\DateTimeZone;

    public function dateInterval($from = '', array $formats = null) : ?\DateInterval;


    public function now($dateTimeZone = '') : \DateTime;

    public function nowImmutable($dateTimeZone = '') : \DateTimeImmutable;


    public function nowMidnight($dateTimeZone = '') : \DateTime;

    public function nowMidnightImmutable($dateTimeZone = '') : \DateTimeImmutable;
}
