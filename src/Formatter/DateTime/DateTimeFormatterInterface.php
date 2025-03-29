<?php

namespace Gzhegow\Calendar\Formatter\DateTime;

interface DateTimeFormatterInterface
{
    public function formatHuman(\DateTimeInterface $dateTime) : string;

    public function formatHumanDay(\DateTimeInterface $dateTime) : string;
}
