<?php

namespace Gzhegow\Calendar\Formatter\DateInterval;

interface DateIntervalFormatterInterface
{
    public function formatIntervalISO8601(\DateInterval $dateInterval) : string;

    public function formatIntervalAgo(\DateInterval $dateInterval) : string;
}
