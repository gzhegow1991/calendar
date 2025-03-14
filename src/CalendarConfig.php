<?php

namespace Gzhegow\Calendar;

use Gzhegow\Lib\Config\AbstractConfig;
use Gzhegow\Calendar\Parser\CalendarParserConfig;
use Gzhegow\Calendar\Manager\CalendarManagerConfig;
use Gzhegow\Calendar\Formatter\CalendarFormatterConfig;


/**
 * @property CalendarParserConfig    $parser
 * @property CalendarManagerConfig   $manager
 * @property CalendarFormatterConfig $formatter
 */
class CalendarConfig extends AbstractConfig
{
    /**
     * @var CalendarParserConfig
     */
    protected $parser;
    /**
     * @var CalendarParserConfig
     */
    protected $manager;
    /**
     * @var CalendarFormatterConfig
     */
    protected $formatter;


    public function __construct()
    {
        $this->parser = new CalendarParserConfig();
        $this->manager = new CalendarManagerConfig();
        $this->formatter = new CalendarFormatterConfig();

        parent::__construct();
    }
}
