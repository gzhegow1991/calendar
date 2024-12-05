# Calendar

## Что это

Этот пакет сделан, чтобы сделать работу с датами более удобной.

- Позволяет передавать в конструкторы дат строки без необходимости создавать объект ради объекта
- В нем можно посмотреть, как сделать грамотное наследование имеющищегося в коробке PHP ужаса, чтобы этим управлять или добавить своё.

## Установка

```
composer require gzhegow/calendar;
```

## Пример

```php
<?php

require_once __DIR__ . '/vendor/autoload.php';


// > настраиваем PHP
ini_set('memory_limit', '32M');


// > настраиваем обработку ошибок
error_reporting(E_ALL);
set_error_handler(function ($errno, $errstr, $errfile, $errline) {
    if (error_reporting() & $errno) {
        throw new \ErrorException($errstr, -1, $errno, $errfile, $errline);
    }
});
set_exception_handler(function (\Throwable $e) {
    $current = $e;
    do {
        echo "\n";

        echo \Gzhegow\Calendar\Lib::debug_var_dump($current) . PHP_EOL;
        echo $current->getMessage() . PHP_EOL;

        foreach ( $e->getTrace() as $traceItem ) {
            echo "{$traceItem['file']} : {$traceItem['line']}" . PHP_EOL;
        }

        echo PHP_EOL;
    } while ( $current = $current->getPrevious() );

    die();
});


// > добавляем несколько функция для тестирования
function _dump($value, ...$values) : void
{
    echo \Gzhegow\Calendar\Lib::debug_line([ 'with_ids' => false, 'with_objects' => false ], $value, ...$values);
}

function _dump_ln($value, ...$values) : void
{
    echo \Gzhegow\Calendar\Lib::debug_line([ 'with_ids' => false, 'with_objects' => false ], $value, ...$values) . PHP_EOL;
}

function _assert_call(\Closure $fn, array $expectResult = [], string $expectOutput = null) : void
{
    $trace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 1);

    $expect = (object) [];

    if (count($expectResult)) {
        $expect->result = $expectResult[ 0 ];
    }

    if (null !== $expectOutput) {
        $expect->output = $expectOutput;
    }

    $status = \Gzhegow\Calendar\Lib::assert_call($trace, $fn, $expect, $error, STDOUT);

    if (! $status) {
        throw new \Gzhegow\Calendar\Exception\LogicException();
    }
}


// >>> ЗАПУСКАЕМ!

// > сначала всегда фабрика
$factory = new \Gzhegow\Calendar\CalendarFactory();

// > создаем календарь
$calendar = $factory->newCalendar();

// > можно изменить классы дат на свои собственные реализации
// $calendarType = new \Gzhegow\Calendar\CalendarType();
// \Gzhegow\Calendar\CalendarType::setInstance($calendarType);


// > TEST
// > создаем дату, временную зону и интервал
$fn = function () use ($calendar) {
    _dump_ln('TEST 1');

    $result = $calendar->dateTime($datetime = 'now', $timezone = null);
    _dump_ln(get_class($result));

    $result = $calendar->dateTimeImmutable($datetime = 'now', $timezone = null);
    _dump_ln(get_class($result));

    $result = $calendar->dateTimeZone($timezone = 'UTC');
    _dump_ln(get_class($result));

    $result = $calendar->dateInterval($duration = 'P1D');
    _dump_ln(get_class($result));

    _dump('');
};
_assert_call($fn, [], PHP_VERSION_ID >= 80000
    ? <<<HEREDOC
"TEST 1"
"Gzhegow\Calendar\Struct\PHP8\DateTime"
"Gzhegow\Calendar\Struct\PHP8\DateTimeImmutable"
"Gzhegow\Calendar\Struct\PHP8\DateTimeZone"
"Gzhegow\Calendar\Struct\PHP8\DateInterval"
""
HEREDOC
    : <<<HEREDOC
"TEST 1"
"Gzhegow\Calendar\Struct\PHP7\DateTime"
"Gzhegow\Calendar\Struct\PHP7\DateTimeImmutable"
"Gzhegow\Calendar\Struct\PHP7\DateTimeZone"
"Gzhegow\Calendar\Struct\PHP7\DateInterval"
""
HEREDOC
);


// > TEST
// > распознаем дату, временную зону и интервал
$fn = function () use ($calendar) {
    _dump_ln('TEST 2');

    $result = $calendar->parseDateTime($datetime = '1970-01-01 00:00:00', $formats = [ 'Y-m-d H:i:s' ], $timezoneIfParsed = 'UTC');
    _dump_ln(get_class($result));

    $result = $calendar->parseDateTimeImmutable($datetime = '1970-01-01 00:00:00', $formats = [ 'Y-m-d H:i:s' ], $timezoneIfParsed = 'UTC');
    _dump_ln(get_class($result));

    $result = $calendar->parseDateTimeZone($timezone = 'UTC');
    _dump_ln(get_class($result));

    $result = $calendar->parseDateInterval($interval = 'P0D', $formats = null);
    _dump_ln(get_class($result));

    _dump('');
};
_assert_call($fn, [], PHP_VERSION_ID >= 80000
    ? <<<HEREDOC
"TEST 2"
"Gzhegow\Calendar\Struct\PHP8\DateTime"
"Gzhegow\Calendar\Struct\PHP8\DateTimeImmutable"
"Gzhegow\Calendar\Struct\PHP8\DateTimeZone"
"Gzhegow\Calendar\Struct\PHP8\DateInterval"
""
HEREDOC
    : <<<HEREDOC
"TEST 2"
"Gzhegow\Calendar\Struct\PHP7\DateTime"
"Gzhegow\Calendar\Struct\PHP7\DateTimeImmutable"
"Gzhegow\Calendar\Struct\PHP7\DateTimeZone"
"Gzhegow\Calendar\Struct\PHP7\DateInterval"
""
HEREDOC
);


// > TEST
// > проводим действия над датой
$fn = function () use ($calendar) {
    _dump_ln('TEST 3');

    $dt = $calendar->parseDateTimeImmutable($datetime = 'now', $formats = null, $timezoneIfParsed = null);
    _dump_ln(get_class($dt));

    $result = $dt->modify('+ 10 hours');
    _dump_ln(get_class($result));
    $result = $result->diff($dt);
    _dump_ln(get_class($result));
    _dump_ln(json_encode($result));

    $result = $dt->add(new \DateInterval('P1D'));
    _dump_ln(get_class($result));
    $result = $result->diff($dt);
    _dump_ln(get_class($result));
    _dump_ln(json_encode($result));
    _dump_ln((bool) $result->invert);

    $result = $dt->sub(new \DateInterval('P1D'));
    _dump_ln(get_class($result));
    $result = $result->diff($dt);
    _dump_ln(get_class($result));
    _dump_ln(json_encode($result));
    _dump_ln((bool) $result->invert);

    _dump('');
};
_assert_call($fn, [], PHP_VERSION_ID >= 80000
    ? <<<HEREDOC
"TEST 3"
"Gzhegow\Calendar\Struct\PHP8\DateTimeImmutable"
"Gzhegow\Calendar\Struct\PHP8\DateTimeImmutable"
"Gzhegow\Calendar\Struct\PHP8\DateInterval"
""PT10H""
"Gzhegow\Calendar\Struct\PHP8\DateTimeImmutable"
"Gzhegow\Calendar\Struct\PHP8\DateInterval"
""P1D""
TRUE
"Gzhegow\Calendar\Struct\PHP8\DateTimeImmutable"
"Gzhegow\Calendar\Struct\PHP8\DateInterval"
""P1D""
FALSE
""
HEREDOC
    : <<<HEREDOC
"TEST 3"
"Gzhegow\Calendar\Struct\PHP7\DateTimeImmutable"
"Gzhegow\Calendar\Struct\PHP7\DateTimeImmutable"
"Gzhegow\Calendar\Struct\PHP7\DateInterval"
""PT10H""
"Gzhegow\Calendar\Struct\PHP7\DateTimeImmutable"
"Gzhegow\Calendar\Struct\PHP7\DateInterval"
""P1D""
TRUE
"Gzhegow\Calendar\Struct\PHP7\DateTimeImmutable"
"Gzhegow\Calendar\Struct\PHP7\DateInterval"
""P1D""
FALSE
""
HEREDOC
);


// > TEST
// > считаем разницу времени
$fn = function () use ($calendar) {
    _dump_ln('TEST 4');

    $now = $calendar->nowImmutable();

    $past = $now->modify('- 10 hours');

    $result = $calendar->diff($now, $past, $absolute = false);
    _dump_ln(get_class($result));
    _dump_ln('"PT10H"' === json_encode($result));

    _dump('');
};
_assert_call($fn, [], PHP_VERSION_ID >= 80000
    ? <<<HEREDOC
"TEST 4"
"Gzhegow\Calendar\Struct\PHP8\DateInterval"
TRUE
""
HEREDOC
    : <<<HEREDOC
"TEST 4"
"Gzhegow\Calendar\Struct\PHP7\DateInterval"
TRUE
""
HEREDOC
);
```