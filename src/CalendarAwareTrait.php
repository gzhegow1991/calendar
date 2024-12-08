<?php

namespace Gzhegow\Calendar;


trait CalendarAwareTrait
{
    /**
     * @var CalendarFacade
     */
    protected $calendar;


    public function setCalendar(?CalendarFacadeInterface $calendar) : void
    {
        $this->calendar = $calendar;
    }
}
