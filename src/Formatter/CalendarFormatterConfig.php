<?php

namespace Gzhegow\Calendar\Formatter;

use Gzhegow\Lib\Config\AbstractConfig;


/**
 * @property bool $useIntl
 */
class CalendarFormatterConfig extends AbstractConfig
{
    protected $useIntl = true;


    protected function validation(array &$context = []) : bool
    {
        $this->useIntl = (bool) $this->useIntl;

        return true;
    }
}
