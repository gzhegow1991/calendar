<?php

namespace Gzhegow\Calendar;

use Gzhegow\Calendar\Parser\ParserConfig;
use Gzhegow\Calendar\Manager\ManagerConfig;
use Gzhegow\Calendar\Config\AbstractConfig;
use Gzhegow\Calendar\Formatter\FormatterConfig;


/**
 * @property ParserConfig    $parser
 * @property ManagerConfig   $manager
 * @property FormatterConfig $formatter
 */
class CalendarConfig extends AbstractConfig
{
    /**
     * @var ParserConfig
     */
    protected $parser;
    /**
     * @var ParserConfig
     */
    protected $manager;
    /**
     * @var FormatterConfig
     */
    protected $formatter;


    public function __construct()
    {
        $this->__sections[ 'parser' ] = $this->parser = new ParserConfig();
        $this->__sections[ 'manager' ] = $this->manager = new ManagerConfig();
        $this->__sections[ 'formatter' ] = $this->formatter = new FormatterConfig();
    }
}
