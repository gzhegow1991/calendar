<?php

namespace Gzhegow\Calendar;

/**
 * @template-covariant TDateTime of \DateTime
 * @template-covariant TDateTimeImmutable of \DateTimeImmutable
 * @template-covariant TDateInterval of \DateInterval
 * @template-covariant TDateTimeZone of \DateTimeZone
 */
interface CalendarTypeInterface
{
    /**
     * @param class-string<TDateTime>|null $className
     *
     * @return class-string<TDateTime>
     */
    public function classDateTime(string $className = null) : string;

    /**
     * @param class-string<TDateTimeImmutable>|null $className
     *
     * @return class-string<TDateTimeImmutable>
     */
    public function classDateTimeImmutable(string $className = null) : string;

    /**
     * @param class-string<TDateInterval>|null $className
     *
     * @return class-string<TDateInterval>
     */
    public function classDateInterval(string $className = null) : string;

    /**
     * @param class-string<TDateTimeZone>|null $className
     *
     * @return class-string<TDateTimeZone>
     */
    public function classDateTimeZone(string $className = null) : string;
}
