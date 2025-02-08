<?php

namespace Gzhegow\Calendar;


trait CalendarAwareTrait
{
    /**
     * @var CalendarFacade
     */
    protected $calendar;


    public function setCalendar(?CalendarInterface $calendar) : void
    {
        $this->calendar = $calendar;
    }
}
