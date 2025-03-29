<?php

namespace Gzhegow\Calendar\Formatter\DateInterval;

class DateIntervalFormatter implements DateIntervalFormatterInterface
{
    public function formatIntervalISO8601(\DateInterval $dateInterval) : string
    {
        $search = [ 'M0S', 'H0M', 'DT0H', 'M0D', 'P0Y', 'Y0M', 'P0M' ];
        $replace = [ 'M', 'H', 'DT', 'M', 'P', 'Y', 'P' ];

        if ($dateInterval->f) {
            $microseconds = sprintf('%.6f', $dateInterval->f);
            $microseconds = substr($microseconds, 2);
            $microseconds = rtrim($microseconds, '0.');
            $microseconds = (int) $microseconds;

            $result = $dateInterval->format("P%yY%mM%dDT%hH%iM%s.{$microseconds}S");

        } else {
            $result = $dateInterval->format('P%yY%mM%dDT%hH%iM%sS');
        }

        $result = str_replace($search, $replace, $result);
        $result = rtrim($result, 'PT') ?: 'P0D';

        return $result;
    }

    public function formatIntervalAgo(\DateInterval $dateInterval) : string
    {
        $formatted = null
            ?? ($dateInterval->y ? $dateInterval->format('%y г.') : null)
            ?? ($dateInterval->m ? $dateInterval->format('%m мес.') : null)
            ?? ($dateInterval->d ? $dateInterval->format('%d дн.') : null)
            ?? ($dateInterval->h ? $dateInterval->format('%h час.') : null)
            ?? ($dateInterval->i ? $dateInterval->format('%i мин.') : null)
            ?? ($dateInterval->s ? $dateInterval->format('%s сек.') : null);

        $formatted = $dateInterval->invert
            ? "{$formatted} назад"
            : "через {$formatted}";

        return $formatted;
    }
}
