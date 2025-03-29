<?php

namespace Gzhegow\Calendar;

use Gzhegow\Calendar\Struct\PHP7\DateTime;
use Gzhegow\Calendar\Exception\LogicException;
use Gzhegow\Calendar\Struct\PHP7\DateTimeZone;
use Gzhegow\Calendar\Struct\PHP7\DateInterval;


/**
 * @template-covariant TDateTime of \DateTime
 * @template-covariant TDateTimeImmutable of \DateTimeImmutable
 * @template-covariant TDateInterval of \DateInterval
 * @template-covariant TDateTimeZone of \DateTimeZone
 */
class CalendarFactory implements CalendarFactoryInterface
{
    /**
     * @return TDateTime
     */
    public function newDateTime($from = 'now', \DateTimeZone $dateTimeZone = null) : \DateTime
    {
        /**
         * @var class-string<TDateTime> $dateTimeClass
         */

        if (null === $from) {
            throw new LogicException('The `from` should be not null');
        }

        $dateTimeClass = Calendar::classDateTime();

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

    /**
     * @return TDateTime
     */
    public function newDateTimeFromInterface(\DateTimeInterface $object) : \DateTime
    {
        /**
         * @var class-string<TDateTime> $dateTimeClass
         */

        $dateTimeClass = Calendar::classDateTime();

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

    /**
     * @return TDateTime
     */
    public function newDateTimeFromFormat(string $format, string $datetimeStringFormatted, \DateTimeZone $dateTimeZoneIfParsed = null) : \DateTime
    {
        /**
         * @var class-string<TDateTime> $dateTimeClass
         */

        $dateTimeClass = Calendar::classDateTime();

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


    /**
     * @return TDateTimeImmutable
     */
    public function newDateTimeImmutable($from = 'now', \DateTimeZone $dateTimeZone = null) : \DateTimeImmutable
    {
        /**
         * @var class-string<TDateTimeImmutable> $dateTimeImmutableClass
         */

        if (null === $from) {
            throw new LogicException('The `datetime` should be not null');
        }

        $dateTimeImmutableClass = Calendar::classDateTimeImmutable();

        try {
            $dateTime = new $dateTimeImmutableClass($from, $dateTimeZone);
        }
        catch ( \Throwable $previous ) {
            throw new LogicException(
                [
                    'Unable to create instance of: ' . $dateTimeImmutableClass,
                    $from,
                    $dateTimeZone,
                ],
                $previous
            );
        }

        return $dateTime;
    }

    /**
     * @return TDateTimeImmutable
     */
    public function newDateTimeImmutableFromInterface(\DateTimeInterface $object) : \DateTimeImmutable
    {
        /**
         * @var class-string<TDateTimeImmutable> $dateTimeImmutableClass
         */

        $dateTimeImmutableClass = Calendar::classDateTimeImmutable();

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

    /**
     * @return TDateTimeImmutable
     */
    public function newDateTimeImmutableFromFormat(string $format, string $dateTimeStringFormatted, \DateTimeZone $dateTimeZoneIfParsed = null) : \DateTimeImmutable
    {
        /**
         * @var class-string<TDateTimeImmutable> $dateTimeImmutableClass
         */

        $dateTimeImmutableClass = Calendar::classDateTimeImmutable();

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


    /**
     * @return TDateTimeZone
     */
    public function newDateTimeZone($from = 'UTC') : \DateTimeZone
    {
        /**
         * @var class-string<TDateTimeZone> $dateTimeZoneClass
         */

        if (null === $from) {
            throw new LogicException('The `from` should be not null');
        }

        $dateTimeZoneClass = Calendar::classDateTimeZone();

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

    /**
     * @return TDateTimeZone
     */
    public function newDateTimeZoneFromInstance(\DateTimeZone $instance) : \DateTimeZone
    {
        /**
         * @var class-string<TDateTimeZone> $dateTimeZoneClass
         */

        $dateTimeZoneClass = Calendar::classDateTimeZone();

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


    /**
     * @return TDateInterval
     */
    public function newDateInterval($from = 'P0D') : \DateInterval
    {
        /**
         * @var class-string<TDateInterval> $dateIntervalClass
         */

        if (null === $from) {
            throw new LogicException('The `from` should be not null');
        }

        $dateIntervalClass = Calendar::classDateInterval();

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

    /**
     * @return TDateInterval
     */
    public function newDateIntervalFromInstance(\DateInterval $instance) : \DateInterval
    {
        /**
         * @var class-string<TDateInterval> $dateIntervalClass
         */

        $dateIntervalClass = Calendar::classDateInterval();

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

    /**
     * @return TDateInterval
     */
    public function newDateIntervalFromDateString(string $dateString) : \DateInterval
    {
        /**
         * @var class-string<TDateInterval> $dateIntervalClass
         */

        $dateIntervalClass = Calendar::classDateInterval();

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
