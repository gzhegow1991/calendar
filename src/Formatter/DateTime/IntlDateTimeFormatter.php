<?php

namespace Gzhegow\Calendar\Formatter\DateTime;

use Gzhegow\Calendar\Exception\RuntimeException;


class IntlDateTimeFormatter implements DateTimeFormatterInterface
{
    public function formatHuman(\DateTimeInterface $dateTime) : string
    {
        if (! extension_loaded('intl')) {
            throw new RuntimeException(
                'Extension `ext-intl` is required'
            );
        }

        $intlDateFormatter = new \IntlDateFormatter(
            'ru_RU',
            \IntlDateFormatter::NONE,
            \IntlDateFormatter::NONE,
            null,
            \IntlDateFormatter::GREGORIAN,
            'dd MMMM yyyy HH:mm:SS'
        );

        $formatted = $intlDateFormatter->format($dateTime);

        return $formatted;
    }

    public function formatHumanDay(\DateTimeInterface $dateTime) : string
    {
        if (! extension_loaded('intl')) {
            throw new RuntimeException(
                'Extension `ext-intl` is required'
            );
        }

        $intlDateFormatter = new \IntlDateFormatter(
            'ru_RU',
            \IntlDateFormatter::NONE,
            \IntlDateFormatter::NONE,
            null,
            \IntlDateFormatter::GREGORIAN,
            'dd MMMM yyyy'
        );

        $formatted = $intlDateFormatter->format($dateTime);

        return $formatted;
    }
}
