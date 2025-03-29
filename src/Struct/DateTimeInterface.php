<?php

namespace Gzhegow\Calendar\Struct;


interface DateTimeInterface extends \DateTimeInterface
{
    public function getMilliseconds() : string;

    public function getMicroseconds() : string;
}
