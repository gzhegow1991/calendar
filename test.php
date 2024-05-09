<?php

use Gzhegow\Calendar\Calendar;
use function Gzhegow\Calendar\_calendar;
use function Gzhegow\Calendar\_assert_true;
use function Gzhegow\Calendar\_calendar_now;
use function Gzhegow\Calendar\_calendar_diff;
use function Gzhegow\Calendar\_calendar_date;
use function Gzhegow\Calendar\_calendar_interval;
use function Gzhegow\Calendar\_calendar_timezone;
use function Gzhegow\Calendar\_calendar_now_fixed;
use function Gzhegow\Calendar\_calendar_now_immutable;
use function Gzhegow\Calendar\_calendar_date_immutable;
use function Gzhegow\Calendar\_calendar_now_fixed_clear;


require_once __DIR__ . '/vendor/autoload.php';


error_reporting(E_ALL);
set_error_handler(function ($errno, $errstr, $errfile, $errline) {
    if (error_reporting() & $errno) {
        throw new \ErrorException($errstr, -1, $errno, $errfile, $errline);
    }
});
set_exception_handler('dd');


function main()
{
    _calendar($calendar = new Calendar());

    $tests[ '_calendar_date' ] = _calendar_date($datetime = 'now', $formats = null, $timezoneIfParsed = null);
    _assert_true('is_a', [ $tests[ '_calendar_date' ], DateTime::class ]);

    $tests[ '_calendar_date_immutable' ] = _calendar_date_immutable($datetime = 'now', $formats = null, $timezoneIfParsed = null);
    _assert_true('is_a', [ $tests[ '_calendar_date_immutable' ], DateTimeImmutable::class ]);

    $tests[ '_calendar_now' ] = _calendar_now($timezone = null);
    _assert_true('is_a', [ $tests[ '_calendar_now' ], DateTime::class ]);

    $tests[ '_calendar_now_immutable' ] = _calendar_now_immutable($timezone = null);
    _assert_true('is_a', [ $tests[ '_calendar_now_immutable' ], DateTimeImmutable::class ]);

    $tests[ '_calendar_now_fixed0' ] = _calendar_now_fixed($datetime = null, $timezone = null);
    _assert_true('is_a', [ $tests[ '_calendar_now_fixed0' ], DateTimeImmutable::class ]);
    _calendar_now_fixed_clear();
    $tests[ '_calendar_now_fixed1' ] = _calendar_now_fixed($datetime = null, $timezone = null);
    $tests[ '_calendar_now_fixed2' ] = _calendar_now_fixed($datetime = null, $timezone = null);
    _assert_true('is_a', [ $tests[ '_calendar_now_fixed1' ], DateTimeImmutable::class ]);
    _assert_true('is_a', [ $tests[ '_calendar_now_fixed2' ], DateTimeImmutable::class ]);
    _assert_true(static function () use ($tests) {
        return $tests[ '_calendar_now_fixed1' ] === $tests[ '_calendar_now_fixed2' ];
    });

    $tests[ '_calendar_timezone' ] = _calendar_timezone($timezone = 'UTC');
    _assert_true('is_a', [ $tests[ '_calendar_timezone' ], DateTimeZone::class ]);
    _assert_true(function () use ($tests) {
        return 'UTC' === $tests[ '_calendar_timezone' ]->getName();
    });

    $tests[ '_calendar_interval' ] = _calendar_interval($interval = 'P0D', $formats = null);
    _assert_true('is_a', [ $tests[ '_calendar_interval' ], DateInterval::class ]);
    _assert_true(function () use ($tests) {
        return 'P0D' === $tests[ '_calendar_interval' ]->jsonSerialize();
    });

    $now = _calendar_now_immutable();
    $past = $now->modify('- 10 hours');
    $tests[ '_calendar_diff' ] = _calendar_diff($now, $past, $absolute = false); // : ?DateInterval;
    _assert_true('is_a', [ $tests[ '_calendar_diff' ], DateInterval::class ]);
    _assert_true(function () use ($tests) {
        return 'PT10H' === $tests[ '_calendar_diff' ]->jsonSerialize();
    });

    var_dump($tests);

    // array(10) {
    //   ["_calendar_date"]=>
    //   object(Gzhegow\Calendar\Struct\DateTime)#7 (3) {
    //     ["date"]=>
    //     string(26) "2024-05-09 19:12:16.183649"
    //     ["timezone_type"]=>
    //     int(3)
    //     ["timezone"]=>
    //     string(13) "Europe/Moscow"
    //   }
    //   ["_calendar_date_immutable"]=>
    //   object(Gzhegow\Calendar\Struct\DateTimeImmutable)#8 (3) {
    //     ["date"]=>
    //     string(26) "2024-05-09 19:12:16.183667"
    //     ["timezone_type"]=>
    //     int(3)
    //     ["timezone"]=>
    //     string(13) "Europe/Moscow"
    //   }
    //   ["_calendar_now"]=>
    //   object(Gzhegow\Calendar\Struct\DateTime)#6 (3) {
    //     ["date"]=>
    //     string(26) "2024-05-09 19:12:16.183785"
    //     ["timezone_type"]=>
    //     int(3)
    //     ["timezone"]=>
    //     string(13) "Europe/Moscow"
    //   }
    //   ["_calendar_now_immutable"]=>
    //   object(Gzhegow\Calendar\Struct\DateTimeImmutable)#9 (3) {
    //     ["date"]=>
    //     string(26) "2024-05-09 19:12:16.183788"
    //     ["timezone_type"]=>
    //     int(3)
    //     ["timezone"]=>
    //     string(13) "Europe/Moscow"
    //   }
    //   ["_calendar_now_fixed0"]=>
    //   object(Gzhegow\Calendar\Struct\DateTimeImmutable)#10 (3) {
    //     ["date"]=>
    //     string(26) "2024-05-09 19:12:16.183790"
    //     ["timezone_type"]=>
    //     int(3)
    //     ["timezone"]=>
    //     string(13) "Europe/Moscow"
    //   }
    //   ["_calendar_now_fixed1"]=>
    //   object(Gzhegow\Calendar\Struct\DateTimeImmutable)#11 (3) {
    //     ["date"]=>
    //     string(26) "2024-05-09 19:12:16.183793"
    //     ["timezone_type"]=>
    //     int(3)
    //     ["timezone"]=>
    //     string(13) "Europe/Moscow"
    //   }
    //   ["_calendar_now_fixed2"]=>
    //   object(Gzhegow\Calendar\Struct\DateTimeImmutable)#11 (3) {
    //     ["date"]=>
    //     string(26) "2024-05-09 19:12:16.183793"
    //     ["timezone_type"]=>
    //     int(3)
    //     ["timezone"]=>
    //     string(13) "Europe/Moscow"
    //   }
    //   ["_calendar_timezone"]=>
    //   object(Gzhegow\Calendar\Struct\DateTimeZone)#12 (2) {
    //     ["timezone_type"]=>
    //     int(3)
    //     ["timezone"]=>
    //     string(3) "UTC"
    //   }
    //   ["_calendar_interval"]=>
    //   object(Gzhegow\Calendar\Struct\DateInterval)#13 (16) {
    //     ["y"]=>
    //     int(0)
    //     ["m"]=>
    //     int(0)
    //     ["d"]=>
    //     int(0)
    //     ["h"]=>
    //     int(0)
    //     ["i"]=>
    //     int(0)
    //     ["s"]=>
    //     int(0)
    //     ["f"]=>
    //     float(0)
    //     ["weekday"]=>
    //     int(0)
    //     ["weekday_behavior"]=>
    //     int(0)
    //     ["first_last_day_of"]=>
    //     int(0)
    //     ["invert"]=>
    //     int(0)
    //     ["days"]=>
    //     bool(false)
    //     ["special_type"]=>
    //     int(0)
    //     ["special_amount"]=>
    //     int(0)
    //     ["have_weekday_relative"]=>
    //     int(0)
    //     ["have_special_relative"]=>
    //     int(0)
    //   }
    //   ["_calendar_diff"]=>
    //   object(Gzhegow\Calendar\Struct\DateInterval)#16 (16) {
    //     ["weekday"]=>
    //     int(0)
    //     ["weekday_behavior"]=>
    //     int(0)
    //     ["first_last_day_of"]=>
    //     int(0)
    //     ["days"]=>
    //     bool(false)
    //     ["special_type"]=>
    //     int(0)
    //     ["special_amount"]=>
    //     int(0)
    //     ["have_weekday_relative"]=>
    //     int(0)
    //     ["have_special_relative"]=>
    //     int(0)
    //     ["y"]=>
    //     int(0)
    //     ["m"]=>
    //     int(0)
    //     ["d"]=>
    //     int(0)
    //     ["h"]=>
    //     int(10)
    //     ["i"]=>
    //     int(0)
    //     ["s"]=>
    //     int(0)
    //     ["f"]=>
    //     float(0)
    //     ["invert"]=>
    //     int(1)
    //   }
    // }
}

main();
