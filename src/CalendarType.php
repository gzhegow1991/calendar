<?php
/**
 * @noinspection PhpFullyQualifiedNameUsageInspection
 */

namespace Gzhegow\Calendar;

use Gzhegow\Calendar\Exception\LogicException;
use Gzhegow\Calendar\Exception\RuntimeException;


/**
 * @template-covariant TDateTime of \DateTime
 * @template-covariant TDateTimeImmutable of \DateTimeImmutable
 * @template-covariant TDateInterval of \DateInterval
 * @template-covariant TDateTimeZone of \DateTimeZone
 */
class CalendarType implements CalendarTypeInterface
{
    /**
     * @var class-string<TDateTime>
     */
    protected $classDateTime;
    /**
     * @var class-string<TDateTimeImmutable>
     */
    protected $classDateTimeImmutable;
    /**
     * @var class-string<TDateInterval>
     */
    protected $classDateInterval;
    /**
     * @var class-string<TDateTimeZone>
     */
    protected $classDateTimeZone;


    /**
     * @param class-string<TDateTime>|null $className
     *
     * @return class-string<TDateTime>
     */
    public function classDateTime(string $className = null) : string
    {
        if (null !== $className) {
            if (null !== $this->classDateTime) {
                throw new RuntimeException(
                    [
                        'The `classDateTime` already been set',
                        $this->classDateTime,
                    ]
                );
            }

            if (! is_a($className, \DateTime::class, true)) {
                throw new LogicException(
                    [
                        'The `className` should be class-string of: ' . \DateTime::class,
                        $className,
                    ]
                );
            }

            $this->classDateTime = $className;
        }

        if (null === $this->classDateTime) {
            $this->classDateTime = PHP_VERSION_ID >= 80000
                ? \Gzhegow\Calendar\Struct\DateTime::class
                : \Gzhegow\Calendar\Struct\PHP7\DateTime::class;
        }

        return $this->classDateTime;
    }

    /**
     * @param class-string<TDateTimeImmutable>|null $className
     *
     * @return class-string<TDateTimeImmutable>
     */
    public function classDateTimeImmutable(string $className = null) : string
    {
        if (null !== $className) {
            if (null !== $this->classDateTimeImmutable) {
                throw new RuntimeException(
                    [
                        'The `classDateTimeImmutable` already been set',
                        $this->classDateTimeImmutable,
                    ]
                );
            }

            if (! is_a($className, \DateTimeImmutable::class, true)) {
                throw new LogicException(
                    [
                        'The `className` should be class-string of: ' . \DateTimeImmutable::class,
                        $className,
                    ]
                );
            }

            $this->classDateTimeImmutable = $className;
        }

        if (null === $this->classDateTimeImmutable) {
            $this->classDateTimeImmutable = PHP_VERSION_ID >= 80000
                ? \Gzhegow\Calendar\Struct\DateTimeImmutable::class
                : \Gzhegow\Calendar\Struct\PHP7\DateTimeImmutable::class;
        }

        return $this->classDateTimeImmutable;
    }

    /**
     * @param class-string<TDateInterval>|null $className
     *
     * @return class-string<TDateInterval>
     */
    public function classDateInterval(string $className = null) : string
    {
        if (null !== $className) {
            if (null !== $this->classDateInterval) {
                throw new RuntimeException(
                    [
                        'The `classDateInterval` already been set',
                        $this->classDateInterval,
                    ]
                );
            }

            if (! is_a($className, \DateInterval::class, true)) {
                throw new LogicException(
                    [
                        'The `className` should be class-string of: ' . \DateInterval::class,
                        $className,
                    ]
                );
            }

            $this->classDateInterval = $className;
        }

        if (null === $this->classDateInterval) {
            $this->classDateInterval = PHP_VERSION_ID >= 80000
                ? \Gzhegow\Calendar\Struct\DateInterval::class
                : \Gzhegow\Calendar\Struct\PHP7\DateInterval::class;
        }

        return $this->classDateInterval;
    }

    /**
     * @param class-string<TDateTimeZone>|null $className
     *
     * @return class-string<TDateTimeZone>
     */
    public function classDateTimeZone(string $className = null) : string
    {
        if (null !== $className) {
            if (null !== $this->classDateTimeZone) {
                throw new RuntimeException(
                    [
                        'The `classDateTimeZone` already been set',
                        $this->classDateTimeZone,
                    ]
                );
            }

            if (! is_a($className, \DateTimeZone::class, true)) {
                throw new LogicException(
                    [
                        'The `className` should be class-string of: ' . \DateTimeZone::class,
                        $className,
                    ]
                );
            }

            $this->classDateTimeZone = $className;
        }

        if (null === $this->classDateTimeZone) {
            $this->classDateTimeZone = PHP_VERSION_ID >= 80000
                ? \Gzhegow\Calendar\Struct\DateTimeZone::class
                : \Gzhegow\Calendar\Struct\PHP7\DateTimeZone::class;
        }

        return $this->classDateTimeZone;
    }
}
