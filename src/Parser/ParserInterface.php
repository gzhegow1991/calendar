<?php

namespace Gzhegow\Calendar\Parser;

interface ParserInterface
{
    public function parseDateTime($from, array $formats = null, $dateTimeZoneIfParsed = null) : ?\DateTime;

    public function parseDateTimeImmutable($from, array $formats = null, $dateTimeZoneIfParsed = null) : ?\DateTimeImmutable;

    public function parseDateTimeZone($from) : ?\DateTimeZone;

    public function parseDateInterval($from, array $formats = null) : ?\DateInterval;
}
