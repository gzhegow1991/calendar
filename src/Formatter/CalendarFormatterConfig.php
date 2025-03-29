<?php

namespace Gzhegow\Calendar\Formatter;

use Gzhegow\Lib\Config\AbstractConfig;
use Gzhegow\Calendar\Exception\LogicException;
use Gzhegow\Calendar\Formatter\DateTime\DateTimeFormatter;
use Gzhegow\Calendar\Formatter\DateInterval\DateIntervalFormatter;
use Gzhegow\Calendar\Formatter\DateTime\DateTimeFormatterInterface;
use Gzhegow\Calendar\Formatter\DateInterval\DateIntervalFormatterInterface;


/**
 * @property DateTimeFormatterInterface     $dateTimeFormatter
 * @property DateIntervalFormatterInterface $dateIntervalFormatter
 */
class CalendarFormatterConfig extends AbstractConfig
{
    /**
     * @var DateTimeFormatterInterface
     */
    protected $dateTimeFormatter;
    /**
     * @var DateIntervalFormatterInterface
     */
    protected $dateIntervalFormatter;


    public function __construct()
    {
        $this->dateTimeFormatter = new DateTimeFormatter();
        $this->dateIntervalFormatter = new DateIntervalFormatter();

        parent::__construct();
    }


    protected function validation(array &$context = []) : bool
    {
        if (! ($this->dateTimeFormatter instanceof DateTimeFormatterInterface)) {
            throw new LogicException(
                [
                    'The `dateTimeFormatter` should be instance of: ' . DateTimeFormatterInterface::class,
                    $this->dateTimeFormatter,
                ]
            );
        }

        if (! ($this->dateIntervalFormatter instanceof DateIntervalFormatterInterface)) {
            throw new LogicException(
                [
                    'The `dateIntervalFormatter` should be instance of: ' . DateIntervalFormatterInterface::class,
                    $this->dateIntervalFormatter,
                ]
            );
        }

        return true;
    }
}
