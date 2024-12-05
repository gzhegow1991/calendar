<?php

namespace Gzhegow\Calendar;


class CalendarType
{
    /**
     * @return class-string<\DateInterval>
     */
    public static function dateInterval() : string
    {
        return static::getInstance()->_dateInterval();
    }

    /**
     * @return class-string<\DateTime>
     */
    public static function dateTime() : string
    {
        return static::getInstance()->_dateTime();
    }

    /**
     * @return class-string<\DateTimeImmutable>
     */
    public static function dateTimeImmutable() : string
    {
        return static::getInstance()->_dateTimeImmutable();
    }

    /**
     * @return class-string<\DateTimeZone>
     */
    public static function dateTimeZone() : string
    {
        return static::getInstance()->_dateTimeZone();
    }


    /**
     * @return class-string<\DateInterval>
     */
    protected function _dateInterval() : string
    {
        return PHP_VERSION_ID >= 80000
            ? \Gzhegow\Calendar\Struct\PHP8\DateInterval::class
            : \Gzhegow\Calendar\Struct\PHP7\DateInterval::class;
    }

    /**
     * @return class-string<\DateTime>
     */
    protected function _dateTime() : string
    {
        return PHP_VERSION_ID >= 80000
            ? \Gzhegow\Calendar\Struct\PHP8\DateTime::class
            : \Gzhegow\Calendar\Struct\PHP7\DateTime::class;
    }

    /**
     * @return class-string<\DateTimeImmutable>
     */
    protected function _dateTimeImmutable() : string
    {
        return PHP_VERSION_ID >= 80000
            ? \Gzhegow\Calendar\Struct\PHP8\DateTimeImmutable::class
            : \Gzhegow\Calendar\Struct\PHP7\DateTimeImmutable::class;
    }

    /**
     * @return class-string<\DateTimeZone>
     */
    protected function _dateTimeZone() : string
    {
        return PHP_VERSION_ID >= 80000
            ? \Gzhegow\Calendar\Struct\PHP8\DateTimeZone::class
            : \Gzhegow\Calendar\Struct\PHP7\DateTimeZone::class;
    }


    /**
     * @return static
     */
    public static function getInstance() : self
    {
        return static::$instance = null
            ?? static::$instance
            ?? new static();
    }

    public static function setInstance(self $instance) : void
    {
        static::$instance = static::$instance = $instance;
    }

    protected static $instance;
}
