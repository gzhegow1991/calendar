<?php

namespace Gzhegow\Calendar\Formatter;

use Gzhegow\Calendar\Config\AbstractConfig;


/**
 * @property bool $useIntl
 */
class FormatterConfig extends AbstractConfig
{
    protected $useIntl = true;


    public function validate()
    {
        $this->useIntl = (bool) $this->useIntl;
    }
}
