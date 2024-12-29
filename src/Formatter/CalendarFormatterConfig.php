<?php

namespace Gzhegow\Calendar\Formatter;

use Gzhegow\Lib\Config\AbstractConfig;


/**
 * @property bool $useIntl
 */
class CalendarFormatterConfig extends AbstractConfig
{
    protected $useIntl = true;


    public function validate()
    {
        $this->useIntl = (bool) $this->useIntl;
    }
}
