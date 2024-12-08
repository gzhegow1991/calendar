<?php

namespace Gzhegow\Calendar;


interface CalendarAwareInterface
{
    /**
     * @param null|CalendarFacadeInterface $calendar
     *
     * @return void
     */
    public function setCalendar(?CalendarFacadeInterface $calendar) : void;
}
