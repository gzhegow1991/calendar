<?php
/**
 * @noinspection PhpFullyQualifiedNameUsageInspection
 */

namespace Gzhegow\Calendar\Type;


class CalendarType implements CalendarTypeInterface
{
    /**
     * @return class-string<\DateTime>
     */
    public function classDateTime() : string
    {
        return PHP_VERSION_ID >= 80000
            ? \Gzhegow\Calendar\Struct\PHP8\DateTime::class
            : \Gzhegow\Calendar\Struct\PHP7\DateTime::class;
    }

    /**
     * @return class-string<\DateTimeImmutable>
     */
    public function classDateTimeImmutable() : string
    {
        return PHP_VERSION_ID >= 80000
            ? \Gzhegow\Calendar\Struct\PHP8\DateTimeImmutable::class
            : \Gzhegow\Calendar\Struct\PHP7\DateTimeImmutable::class;
    }

    /**
     * @return class-string<\DateInterval>
     */
    public function classDateInterval() : string
    {
        return PHP_VERSION_ID >= 80000
            ? \Gzhegow\Calendar\Struct\PHP8\DateInterval::class
            : \Gzhegow\Calendar\Struct\PHP7\DateInterval::class;
    }

    /**
     * @return class-string<\DateTimeZone>
     */
    public function classDateTimeZone() : string
    {
        return PHP_VERSION_ID >= 80000
            ? \Gzhegow\Calendar\Struct\PHP8\DateTimeZone::class
            : \Gzhegow\Calendar\Struct\PHP7\DateTimeZone::class;
    }
}
