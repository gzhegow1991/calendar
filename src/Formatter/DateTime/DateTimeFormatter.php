<?php

namespace Gzhegow\Calendar\Formatter\DateTime;

use Gzhegow\Calendar\Calendar;


class DateTimeFormatter implements DateTimeFormatterInterface
{
    public function formatHuman(\DateTimeInterface $dateTime) : string
    {
        $formatted = $dateTime->format(Calendar::FORMAT_HUMAN_DATE);

        return $formatted;
    }

    public function formatHumanDay(\DateTimeInterface $dateTime) : string
    {
        $formatted = $dateTime->format(Calendar::FORMAT_HUMAN_DAY);

        return $formatted;
    }
}
