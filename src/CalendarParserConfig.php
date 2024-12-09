<?php

namespace Gzhegow\Calendar;

use Gzhegow\Lib\Lib;
use Gzhegow\Calendar\Config\AbstractConfig;
use Gzhegow\Calendar\Exception\LogicException;


/**
 * @property string[] $parseDateTimeFormatsDefault
 * @property string[] $parseDateIntervalFormatsDefault
 */
class CalendarParserConfig extends AbstractConfig
{
    protected $parseDateTimeFormatsDefault = [
        Calendar::FORMAT_SQL,
        Calendar::FORMAT_JAVASCRIPT,
    ];

    protected $parseDateIntervalFormatsDefault = [
        Calendar::FORMAT_SQL_TIME,
    ];


    public function validate()
    {
        foreach ( $this->parseDateTimeFormatsDefault as $format ) {
            if (null === Lib::parse_string_not_empty($format)) {
                throw new LogicException(
                    [
                        'Each of `parseDateTimeFormatsDefault` should be non-empty string',
                        $format,
                    ]
                );
            }
        }

        foreach ( $this->parseDateIntervalFormatsDefault as $format ) {
            if (null === Lib::parse_string_not_empty($format)) {
                throw new LogicException(
                    [
                        'Each of `parseDateIntervalFormatsDefault` should be non-empty string',
                        $format,
                    ]
                );
            }
        }
    }
}
