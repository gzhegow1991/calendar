<?php

namespace Gzhegow\Calendar\Struct\PHP7;


interface DateTimeInterface extends \DateTimeInterface
{
    public function getMilliseconds() : string;

    public function getMicroseconds() : string;
}
