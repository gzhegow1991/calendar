<?php

namespace Gzhegow\Calendar\Formatter;

use Gzhegow\Calendar\Calendar;
use Gzhegow\Calendar\CalendarFactoryInterface;


class CalendarFormatter implements CalendarFormatterInterface
{
    /**
     * @var CalendarFactoryInterface
     */
    protected $factory;

    /**
     * @var CalendarFormatterConfig
     */
    protected $config;


    public function __construct(
        CalendarFactoryInterface $factory,
        //
        CalendarFormatterConfig $config
    )
    {
        $this->factory = $factory;

        $this->config = $config;
        $this->config->validate();
    }


    public function formatTimestamp(\DateTimeInterface $dateTime) : string
    {
        $timestamp = (string) $dateTime->getTimestamp();

        return $timestamp;
    }

    public function formatTimestampUTC(\DateTimeInterface $dateTime) : string
    {
        $clone = (clone $dateTime)
            ->setTimezone(
                $this->factory->newDateTimeZone('UTC')
            )
        ;

        return (string) $clone->getTimestamp();
    }


    public function formatMilliseconds(\DateTimeInterface $dateTime) : string
    {
        $timestamp = $dateTime->getTimestamp();

        $milliseconds = $dateTime->format('u');
        $milliseconds = substr($milliseconds, 0, -3);

        return "{$timestamp}.{$milliseconds}";
    }

    public function formatMillisecondsUTC(\DateTimeInterface $dateTime) : string
    {
        $clone = (clone $dateTime)
            ->setTimezone(
                $this->factory->newDateTimeZone('UTC')
            )
        ;

        $timestamp = $clone->getTimestamp();

        $milliseconds = $clone->format('u');
        $milliseconds = substr($milliseconds, 0, -3);

        return "{$timestamp}.{$milliseconds}";
    }


    public function formatMicroseconds(\DateTimeInterface $dateTime) : string
    {
        $timestamp = $dateTime->getTimestamp();

        $microseconds = $dateTime->format('u');
        $microseconds = str_pad($microseconds, 6, '0', STR_PAD_RIGHT);

        return "{$timestamp}.{$microseconds}";
    }

    public function formatMicrosecondsUTC(\DateTimeInterface $dateTime) : string
    {
        $clone = (clone $dateTime)
            ->setTimezone(
                $this->factory->newDateTimeZone('UTC')
            )
        ;

        $timestamp = $clone->getTimestamp();

        $microseconds = $clone->format('u');
        $microseconds = str_pad($microseconds, 6, '0', STR_PAD_RIGHT);

        return "{$timestamp}.{$microseconds}";
    }


    public function formatSql(\DateTimeInterface $dateTime) : string
    {
        $formattedSql = $dateTime->format(Calendar::FORMAT_SQL);

        return $formattedSql;
    }

    public function formatSqlUTC(\DateTimeInterface $dateTime) : string
    {
        $clone = (clone $dateTime)
            ->setTimezone(
                $this->factory->newDateTimeZone('UTC')
            )
        ;

        $formattedSql = $clone->format(Calendar::FORMAT_SQL);

        return $formattedSql;
    }


    public function formatSqlMicroseconds(\DateTimeInterface $dateTime) : string
    {
        $formattedSql = $dateTime->format(Calendar::FORMAT_SQL);

        $microseconds = $dateTime->format('u');
        $microseconds = str_pad($microseconds, 6, '0', STR_PAD_RIGHT);

        return "{$formattedSql}.{$microseconds}";
    }

    public function formatSqlMicrosecondsUTC(\DateTimeInterface $dateTime) : string
    {
        $clone = (clone $dateTime)
            ->setTimezone(
                $this->factory->newDateTimeZone('UTC')
            )
        ;

        $formattedSql = $clone->format(Calendar::FORMAT_SQL);

        $microseconds = $clone->format('u');
        $microseconds = str_pad($microseconds, 6, '0', STR_PAD_RIGHT);

        return "{$formattedSql}.{$microseconds}";
    }


    public function formatSqlMilliseconds(?\DateTimeInterface $dateTime) : string
    {
        $formattedSql = $dateTime->format(Calendar::FORMAT_SQL);

        $milliseconds = $dateTime->format('u');
        $milliseconds = substr($milliseconds, 0, -3);

        return "{$formattedSql}.{$milliseconds}";
    }

    public function formatSqlMillisecondsUTC(\DateTimeInterface $dateTime) : string
    {
        $clone = (clone $dateTime)
            ->setTimezone(
                $this->factory->newDateTimeZone('UTC')
            )
        ;

        $formattedSql = $clone->format(Calendar::FORMAT_SQL);

        $milliseconds = $clone->format('u');
        $milliseconds = substr($milliseconds, 0, -3);

        return "{$formattedSql}.{$milliseconds}";
    }


    public function formatJavascript(\DateTimeInterface $dateTime) : string
    {
        $formatted = $dateTime->format(Calendar::FORMAT_JAVASCRIPT);

        return $formatted;
    }

    public function formatJavascriptUTC(\DateTimeInterface $dateTime) : string
    {
        $clone = (clone $dateTime)
            ->setTimezone(
                $this->factory->newDateTimeZone('UTC')
            )
        ;

        $formatted = $clone->format(Calendar::FORMAT_JAVASCRIPT);

        return $formatted;
    }


    public function formatJavascriptMilliseconds(\DateTimeInterface $dateTime) : string
    {
        $formattedJavascript = $dateTime->format(Calendar::FORMAT_JAVASCRIPT);

        $milliseconds = $dateTime->format('u');
        $milliseconds = substr($milliseconds, 0, -3);

        return "{$formattedJavascript}.{$milliseconds}";
    }

    public function formatJavascriptMillisecondsUTC(\DateTimeInterface $dateTime) : string
    {
        $clone = (clone $dateTime)
            ->setTimezone(
                $this->factory->newDateTimeZone('UTC')
            )
        ;

        $formattedJavascript = $clone->format(Calendar::FORMAT_JAVASCRIPT);

        $milliseconds = $clone->format('u');
        $milliseconds = substr($milliseconds, 0, -3);

        return "{$formattedJavascript}.{$milliseconds}";
    }


    public function formatJavascriptMicroseconds(\DateTimeInterface $dateTime) : string
    {
        $formattedJavascript = $dateTime->format(Calendar::FORMAT_JAVASCRIPT);

        $microseconds = $dateTime->format('u');
        $microseconds = str_pad($microseconds, 6, '0', STR_PAD_RIGHT);

        return "{$formattedJavascript}.{$microseconds}";
    }

    public function formatJavascriptMicrosecondsUTC(\DateTimeInterface $dateTime) : string
    {
        $clone = (clone $dateTime)
            ->setTimezone(
                $this->factory->newDateTimeZone('UTC')
            )
        ;

        $formattedJavascript = $clone->format(Calendar::FORMAT_JAVASCRIPT);

        $microseconds = $clone->format('u');
        $microseconds = str_pad($microseconds, 6, '0', STR_PAD_RIGHT);

        return "{$formattedJavascript}.{$microseconds}";
    }


    public function formatHumanDate(\DateTimeInterface $dateTime) : string
    {
        if (! ($this->config->useIntl && extension_loaded('intl'))) {
            $formatted = $dateTime->format(Calendar::FORMAT_HUMAN_DATE);

        } else {
            $intlDateFormatter = new \IntlDateFormatter(
                'ru_RU',
                \IntlDateFormatter::NONE,
                \IntlDateFormatter::NONE,
                null,
                \IntlDateFormatter::GREGORIAN,
                'dd MMMM yyyy HH:mm:SS'
            );

            $formatted = $intlDateFormatter->format($dateTime);
        }

        return $formatted;
    }

    public function formatHumanDay(\DateTimeInterface $dateTime) : string
    {
        if (! ($this->config->useIntl && extension_loaded('intl'))) {
            $formatted = $dateTime->format(Calendar::FORMAT_HUMAN_DAY);

        } else {
            $intlDateFormatter = new \IntlDateFormatter(
                'ru_RU',
                \IntlDateFormatter::NONE,
                \IntlDateFormatter::NONE,
                null,
                \IntlDateFormatter::GREGORIAN,
                'dd MMMM yyyy'
            );

            $formatted = $intlDateFormatter->format($dateTime);
        }

        return $formatted;
    }


    public function formatIntervalISO(\DateInterval $dateInterval) : string
    {
        $search = [ 'S0F', 'M0S', 'H0M', 'DT0H', 'M0D', 'P0Y', 'Y0M', 'P0M' ];
        $replace = [ 'S', 'M', 'H', 'DT', 'M', 'P', 'Y', 'P' ];

        $result = $dateInterval->format('P%yY%mM%dDT%hH%iM%sS%fF');
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


    public function formatAgo(\DateTimeInterface $dateTime, \DateTimeInterface $dateTimeFrom = null) : string
    {
        $dateTimeFrom = $dateTimeFrom ?? $this->factory->newDateTimeImmutable('now');

        $dateInterval = $dateTimeFrom->diff($dateTime);

        $formatted = $this->formatIntervalAgo($dateInterval);

        return $formatted;
    }
}
