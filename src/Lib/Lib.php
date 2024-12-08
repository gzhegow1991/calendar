<?php

namespace Gzhegow\Calendar\Lib;

use Gzhegow\Calendar\Lib\Traits\OsTrait;
use Gzhegow\Calendar\Lib\Traits\PhpTrait;
use Gzhegow\Calendar\Lib\Traits\ParseTrait;
use Gzhegow\Calendar\Lib\Traits\DebugTrait;
use Gzhegow\Calendar\Lib\Traits\AssertTrait;


class Lib
{
    use AssertTrait;
    use DebugTrait;
    use OsTrait;
    use ParseTrait;
    use PhpTrait;
}
