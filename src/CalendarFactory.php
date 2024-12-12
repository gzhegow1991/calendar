<?php

namespace Gzhegow\Calendar;

use Gzhegow\Calendar\Struct\PHP7\DateTime;
use Gzhegow\Calendar\Exception\LogicException;
use Gzhegow\Calendar\Struct\PHP7\DateTimeZone;
use Gzhegow\Calendar\Struct\PHP7\DateInterval;


class CalendarFactory implements CalendarFactoryInterface
{
    public function newDateTime($from = 'now', \DateTimeZone $dateTimeZone = null) : \DateTime
    {
        if (null === $from) {
            throw new LogicException('The `from` should be not null');
        }

        $dateTimeClass = CalendarType::dateTime();

        try {
            $dateTime = new $dateTimeClass($from, $dateTimeZone);
        }
        catch ( \Throwable $previous ) {
            throw new LogicException(
                [
                    'Unable to create instance of: ' . $dateTimeClass,
                    $from,
                    $dateTimeZone,
                ],
                $previous
            );
        }

        return $dateTime;
    }

    public function newDateTimeFromInterface(\DateTimeInterface $object) : \DateTime
    {
        $dateTimeClass = CalendarType::dateTime();

        try {
            /** @see \DateTime::createFromInterface() */
            $dateTime = $dateTimeClass::{'createFromInterface'}($object);

            $dateTime = $dateTime ?: null;
        }
        catch ( \Throwable $previous ) {
            throw new LogicException(
                [
                    'Invalid input',
                    $object,
                ],
                $previous
            );
        }

        if (null === $dateTime) {
            throw new LogicException(
                [
                    'Unable to create instance of: ' . $dateTimeClass,
                    $object,
                ]
            );
        }

        return $dateTime;
    }

    public function newDateTimeFromFormat(string $format, string $datetimeStringFormatted, \DateTimeZone $dateTimeZoneIfParsed = null) : \DateTime
    {
        $dateTimeClass = CalendarType::dateTime();

        try {
            /** @see \DateTime::createFromFormat() */
            $dateTime = $dateTimeClass::{'createFromFormat'}($format, $datetimeStringFormatted, $dateTimeZoneIfParsed);

            $dateTime = $dateTime ?: null;
        }
        catch ( \Throwable $previous ) {
            throw new LogicException(
                [
                    'Invalid input',
                    $format,
                    $datetimeStringFormatted,
                    $dateTimeZoneIfParsed,
                ],
                $previous
            );
        }

        if (null === $dateTime) {
            throw new LogicException(
                [
                    'Unable to create instance of: ' . $dateTimeClass,
                    $format,
                    $datetimeStringFormatted,
                    $dateTimeZoneIfParsed,
                ]
            );
        }

        return $dateTime;
    }


    public function newDateTimeImmutable($from = 'now', \DateTimeZone $dateTimeZone = null) : \DateTimeImmutable
    {
        if (null === $from) {
            throw new LogicException('The `datetime` should be not null');
        }

        $dateTimeClass = CalendarType::dateTimeImmutable();

        try {
            $dateTime = new $dateTimeClass($from, $dateTimeZone);
        }
        catch ( \Throwable $previous ) {
            throw new LogicException(
                [
                    'Unable to create instance of: ' . $dateTimeClass,
                    $from,
                    $dateTimeZone,
                ],
                $previous
            );
        }

        return $dateTime;
    }

    public function newDateTimeImmutableFromInterface(\DateTimeInterface $object) : \DateTimeImmutable
    {
        $dateTimeImmutableClass = CalendarType::dateTimeImmutable();

        try {
            /** @see \DateTimeImmutable::createFromInterface() */
            $dateTime = $dateTimeImmutableClass::{'createFromInterface'}($object);

            $dateTime = $dateTime ?: null;
        }
        catch ( \Throwable $previous ) {
            throw new LogicException(
                [
                    'Invalid input',
                    $object,
                ],
                $previous
            );
        }

        if (null === $dateTime) {
            throw new LogicException(
                [
                    'Unable to create instance of: ' . $dateTimeImmutableClass,
                    $object,
                ]
            );
        }

        return $dateTime;
    }

    public function newDateTimeImmutableFromFormat(string $format, string $dateTimeStringFormatted, \DateTimeZone $dateTimeZoneIfParsed = null) : \DateTimeImmutable
    {
        $dateTimeImmutableClass = CalendarType::dateTimeImmutable();

        try {
            /** @see \DateTimeImmutable::createFromFormat() */
            $dateTime = $dateTimeImmutableClass::{'createFromFormat'}($format, $dateTimeStringFormatted, $dateTimeZoneIfParsed);

            $dateTime = $dateTime ?: null;
        }
        catch ( \Throwable $previous ) {
            throw new LogicException(
                [
                    'Invalid input',
                    $format,
                    $dateTimeStringFormatted,
                    $dateTimeZoneIfParsed,
                ],
                $previous
            );
        }

        if (null === $dateTime) {
            throw new LogicException(
                [
                    'Unable to create instance of: ' . $dateTimeImmutableClass,
                    $format,
                    $dateTimeStringFormatted,
                    $dateTimeZoneIfParsed,
                ]
            );
        }

        return $dateTime;
    }


    public function newDateTimeZone($from = 'UTC') : \DateTimeZone
    {
        if (null === $from) {
            throw new LogicException('The `from` should be not null');
        }

        $dateTimeZoneClass = CalendarType::dateTimeZone();

        try {
            $dateTimeZone = new $dateTimeZoneClass($from);
        }
        catch ( \Throwable $previous ) {
            throw new LogicException(
                [
                    'Unable to create instance of: ' . $dateTimeZoneClass,
                    $from,
                ],
                $previous
            );
        }

        return $dateTimeZone;
    }

    public function newDateTimeZoneFromInstance(\DateTimeZone $instance) : \DateTimeZone
    {
        $dateTimeZoneClass = CalendarType::dateTimeZone();

        try {
            /** @see DateTimeZone::createFromInstance() */
            $dateTimeZone = $dateTimeZoneClass::{'createFromInstance'}($instance);

            $dateTimeZone = $dateTimeZone ?: null;
        }
        catch ( \Throwable $previous ) {
            throw new LogicException(
                [
                    'Invalid input',
                    $instance,
                ],
                $previous
            );
        }

        if (null === $dateTimeZone) {
            throw new LogicException(
                [
                    'Unable to create instance of: ' . $dateTimeZoneClass,
                    $instance,
                ]
            );
        }

        return $dateTimeZone;
    }


    public function newDateInterval($from = 'P0D') : \DateInterval
    {
        if (null === $from) {
            throw new LogicException('The `from` should be not null');
        }

        $dateIntervalClass = CalendarType::dateInterval();

        try {
            $dateInterval = new $dateIntervalClass($from);
        }
        catch ( \Throwable $previous ) {
            throw new LogicException(
                [
                    'Unable to create instance of: ' . $dateIntervalClass,
                    $from,
                ],
                $previous
            );
        }

        return $dateInterval;
    }

    public function newDateIntervalFromInstance(\DateInterval $instance) : \DateInterval
    {
        $dateIntervalClass = CalendarType::dateInterval();

        try {
            /** @see DateInterval::createFromInstance() */
            $dateInterval = $dateIntervalClass::{'createFromInstance'}($instance);

            // > gzhegow, convert false to null
            $dateInterval = $dateInterval ?: null;
        }
        catch ( \Throwable $previous ) {
            throw new LogicException(
                [
                    'Invalid input',
                    $instance,
                ],
                $previous
            );
        }

        if (null === $dateInterval) {
            throw new LogicException(
                [
                    'Unable to create instance of: ' . $dateIntervalClass,
                    $instance,
                ]
            );
        }

        return $dateInterval;
    }

    public function newDateIntervalFromDateString(string $dateString) : \DateInterval
    {
        $dateIntervalClass = CalendarType::dateInterval();

        try {
            /** @see DateInterval::createFromDateString() */
            $dateInterval = $dateIntervalClass::{'createFromDateString'}($dateString);

            // > gzhegow, convert false to null
            $dateInterval = $dateInterval ?: null;
        }
        catch ( \Throwable $previous ) {
            throw new LogicException(
                [
                    'Invalid input',
                    $dateString,
                ],
                $previous
            );
        }

        if (null === $dateInterval) {
            throw new LogicException(
                [
                    'Unable to create instance of: ' . $dateIntervalClass,
                    $dateString,
                ]
            );
        }

        return $dateInterval;
    }
}
