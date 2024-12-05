<?php

namespace Gzhegow\Calendar;

class CalendarFactory implements CalendarFactoryInterface
{
    public function newCalendar() : CalendarInterface
    {
        return new Calendar();
    }
}
