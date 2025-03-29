<?php

namespace Gzhegow\Calendar\Formatter;

use Gzhegow\Calendar\Calendar;
use Gzhegow\Calendar\Struct\DateTime;
use Gzhegow\Calendar\CalendarFactoryInterface;
use Gzhegow\Calendar\Struct\PHP7\DateTime as DateTimePHP7;


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
        return (string) $dateTime->getTimestamp();
    }

    public function formatMilliseconds(\DateTimeInterface $dateTime) : string
    {
        $seconds = (string) $dateTime->getTimestamp();

        $milliseconds = $dateTime->format('v');
        $milliseconds = str_pad($milliseconds, 3, '0', STR_PAD_RIGHT);

        return "{$seconds}.{$milliseconds}";
    }

    public function formatMicroseconds(\DateTimeInterface $dateTime) : string
    {
        $seconds = (string) $dateTime->getTimestamp();

        $microseconds = $dateTime->format('u');
        $microseconds = str_pad($microseconds, 6, '0', STR_PAD_RIGHT);

        return "{$seconds}.{$microseconds}";
    }


    public function formatSql(\DateTimeInterface $dateTime) : string
    {
        $formattedSql = $dateTime->format(Calendar::FORMAT_SQL);

        return $formattedSql;
    }

    public function formatSqlMilliseconds(?\DateTimeInterface $dateTime) : string
    {
        $formattedSql = $dateTime->format(Calendar::FORMAT_SQL);

        $milliseconds = $dateTime->format('v');
        $milliseconds = str_pad($milliseconds, 3, '0', STR_PAD_RIGHT);

        return "{$formattedSql}.{$milliseconds}";
    }

    public function formatSqlMicroseconds(\DateTimeInterface $dateTime) : string
    {
        $formattedSql = $dateTime->format(Calendar::FORMAT_SQL);

        $microseconds = $dateTime->format('v');
        $microseconds = str_pad($microseconds, 6, '0', STR_PAD_RIGHT);

        return "{$formattedSql}.{$microseconds}";
    }


    public function formatJavascript(\DateTimeInterface $dateTime) : string
    {
        $formatted = $dateTime->format(Calendar::FORMAT_JAVASCRIPT);

        return $formatted;
    }

    public function formatJavascriptMilliseconds(\DateTimeInterface $dateTime) : string
    {
        $formattedJavascript = $dateTime->format(Calendar::FORMAT_JAVASCRIPT);

        $milliseconds = $dateTime->format('v');
        $milliseconds = str_pad($milliseconds, 3, '0', STR_PAD_RIGHT);

        return "{$formattedJavascript}.{$milliseconds}";
    }

    public function formatJavascriptMicroseconds(\DateTimeInterface $dateTime) : string
    {
        $formattedJavascript = $dateTime->format(Calendar::FORMAT_JAVASCRIPT);

        $microseconds = $dateTime->format('u');
        $microseconds = str_pad($microseconds, 6, '0', STR_PAD_RIGHT);

        return "{$formattedJavascript}.{$microseconds}";
    }


    public function formatAgo(
        \DateTimeInterface $dateTime,
        \DateTimeInterface $dateTimeFrom = null
    ) : string
    {
        $dateTimeFrom = $dateTimeFrom ?? $this->factory->newDateTimeImmutable('now');

        $dateInterval = $dateTimeFrom->diff($dateTime);

        $formatted = $this->formatIntervalAgo($dateInterval);

        return $formatted;
    }


    public function formatDateHuman(\DateTimeInterface $dateTime) : string
    {
        return $this->config->dateTimeFormatter->formatHuman($dateTime);
    }

    public function formatDateHumanDay(\DateTimeInterface $dateTime) : string
    {
        return $this->config->dateTimeFormatter->formatHumanDay($dateTime);
    }


    public function formatIntervalISO8601(\DateInterval $dateInterval) : string
    {
        return $this->config->dateIntervalFormatter->formatIntervalISO8601($dateInterval);
    }

    public function formatIntervalAgo(\DateInterval $dateInterval) : string
    {
        return $this->config->dateIntervalFormatter->formatIntervalAgo($dateInterval);
    }
}
