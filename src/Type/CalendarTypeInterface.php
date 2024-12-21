<?php

namespace Gzhegow\Calendar\Type;

interface CalendarTypeInterface
{
    /**
     * @return class-string<\DateTime>
     */
    public function classDateTime() : string;

    /**
     * @return class-string<\DateTimeImmutable>
     */
    public function classDateTimeImmutable() : string;

    /**
     * @return class-string<\DateInterval>
     */
    public function classDateInterval() : string;

    /**
     * @return class-string<\DateTimeZone>
     */
    public function classDateTimeZone() : string;
}
