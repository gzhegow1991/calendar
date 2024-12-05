<?php

namespace Gzhegow\Calendar;

interface CalendarFactoryInterface
{
    public function newCalendar() : CalendarInterface;
}
