# Calendar

## Что это

Этот пакет сделан, чтобы сделать работу с датами более удобной.

- Позволяет передавать в конструкторы дат и временных зон строки без необходимости создавать объект ради объекта
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
    // require_once getenv('COMPOSER_HOME') . '/vendor/autoload.php';
    // dd();

    $current = $e;
    do {
        echo "\n";

        echo \Gzhegow\Lib\Lib::debug_var_dump($current) . PHP_EOL;
        echo $current->getMessage() . PHP_EOL;

        foreach ( $e->getTrace() as $traceItem ) {
            echo "{$traceItem['file']} : {$traceItem['line']}" . PHP_EOL;
        }

        echo PHP_EOL;
    } while ( $current = $current->getPrevious() );

    die();
});


// > добавляем несколько функция для тестирования
function _dump(...$values) : void
{
    echo implode(' | ', array_map([ \Gzhegow\Lib\Lib::class, 'debug_value' ], $values));
}

function _dump_ln(...$values) : void
{
    echo implode(' | ', array_map([ \Gzhegow\Lib\Lib::class, 'debug_value' ], $values)) . PHP_EOL;
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

    $status = \Gzhegow\Lib\Lib::assert_call($trace, $fn, $expect, $error, STDOUT);

    if (! $status) {
        throw new \Gzhegow\Calendar\Exception\LogicException();
    }
}


// >>> ЗАПУСКАЕМ!

// > сначала всегда фабрика
$factory = new \Gzhegow\Calendar\CalendarFactory();

// > создаем конфигурацию
$config = new \Gzhegow\Calendar\CalendarConfig();
$config->configure(function (\Gzhegow\Calendar\CalendarConfig $config) {
    // > можно указать форматы для разбора даты, если таковые не переданы прямо в функцию
    $config->parser->parseDateTimeFormatsDefault = [
        \Gzhegow\Calendar\Calendar::FORMAT_SQL,
        \Gzhegow\Calendar\Calendar::FORMAT_JAVASCRIPT,
    ];
    // > можно указать форматы для разбора интервалов, если таковые не переданы прямо в функцию
    $config->parser->parseDateIntervalFormatsDefault = [
        \Gzhegow\Calendar\Calendar::FORMAT_SQL_TIME,
    ];

    // > можно указать "дату по-умолчанию", которая будет создана, если не передать аргументов вовсе
    $config->manager->dateTimeDefault = '1970-01-01 midnight';
    // > можно указать "временную зону по-умолчанию", которая будет установлена, если при разборе даты не удалось определить временную зону
    $config->manager->dateTimeZoneDefault = 'Europe/Minsk';
    // > можно указать "интервал по-умолчанию", который будет создаваться, если не передать аргументов
    $config->manager->dateIntervalDefault = 'P0D';

    // > использовать ли INTL, если такое расширение подключено (в целях тестирования установлено в FALSE)
    $config->formatter->useIntl = false;
});

// > можно изменить классы дат на свои собственные реализации
// $calendarType = new \Gzhegow\Calendar\CalendarType();
// \Gzhegow\Calendar\CalendarType::setInstance($calendarType);

// > создаем парсер
$parser = new \Gzhegow\Calendar\Parser\Parser($factory, $config->parser);

// > создаем менеджер
$manager = new \Gzhegow\Calendar\Manager\Manager($factory, $parser, $config->manager);

// > создаем форматтер
$formatter = new \Gzhegow\Calendar\Formatter\Formatter($factory, $config->formatter);

// > создаем фасад
$calendar = new \Gzhegow\Calendar\CalendarFacade(
    $factory,
    $parser,
    $manager,
    $formatter
);

// > сохраняем фасад статически (чтобы вызывать без привязки к контейнеру)
\Gzhegow\Calendar\Calendar::setFacade($calendar);


// > TEST
// > создаем дату, временную зону и интервал
$fn = function () use ($calendar) {
    _dump_ln('TEST 1');

    $result = $calendar->dateTime($datetime = '', $timezone = null);
    _dump_ln($result, json_encode($result));

    $result = $calendar->dateTime($datetime = '1970-01-01 00:00:00', $timezone = null);
    _dump_ln($result, json_encode($result));


    $result = $calendar->dateTimeImmutable($datetime = '', $timezone = null);
    _dump_ln($result, json_encode($result));

    $result = $calendar->dateTimeImmutable($datetime = '1970-01-01 00:00:00', $timezone = null);
    _dump_ln($result, json_encode($result));


    $result = $calendar->dateTimeZone($timezone = '');
    _dump_ln($result, json_encode($result));

    $result = $calendar->dateTimeZone($timezone = 'UTC');
    _dump_ln($result, json_encode($result));


    $result = $calendar->dateInterval($duration = '');
    _dump_ln($result, json_encode($result));

    $result = $calendar->dateInterval($duration = 'P1D');
    _dump_ln($result, json_encode($result));

    _dump('');
};
_assert_call($fn, [], PHP_VERSION_ID >= 80000
    ? <<<HEREDOC
"TEST 1"
{ object # Gzhegow\Calendar\Struct\PHP8\DateTime } | "\"1970-01-01T00:00:00.000+03:00\""
{ object # Gzhegow\Calendar\Struct\PHP8\DateTime } | "\"1970-01-01T00:00:00.000+03:00\""
{ object # Gzhegow\Calendar\Struct\PHP8\DateTimeImmutable } | "\"1970-01-01T00:00:00.000+03:00\""
{ object # Gzhegow\Calendar\Struct\PHP8\DateTimeImmutable } | "\"1970-01-01T00:00:00.000+03:00\""
{ object # Gzhegow\Calendar\Struct\PHP8\DateTimeZone } | "\"Europe\/Minsk\""
{ object # Gzhegow\Calendar\Struct\PHP8\DateTimeZone } | "\"UTC\""
{ object # Gzhegow\Calendar\Struct\PHP8\DateInterval } | "\"P0D\""
{ object # Gzhegow\Calendar\Struct\PHP8\DateInterval } | "\"P1D\""
""
HEREDOC
    : <<<HEREDOC
"TEST 1"
{ object # Gzhegow\Calendar\Struct\PHP7\DateTime } | "\"1970-01-01T00:00:00.000+03:00\""
{ object # Gzhegow\Calendar\Struct\PHP7\DateTime } | "\"1970-01-01T00:00:00.000+03:00\""
{ object # Gzhegow\Calendar\Struct\PHP7\DateTimeImmutable } | "\"1970-01-01T00:00:00.000+03:00\""
{ object # Gzhegow\Calendar\Struct\PHP7\DateTimeImmutable } | "\"1970-01-01T00:00:00.000+03:00\""
{ object # Gzhegow\Calendar\Struct\PHP7\DateTimeZone } | "\"Europe\/Minsk\""
{ object # Gzhegow\Calendar\Struct\PHP7\DateTimeZone } | "\"UTC\""
{ object # Gzhegow\Calendar\Struct\PHP7\DateInterval } | "\"P0D\""
{ object # Gzhegow\Calendar\Struct\PHP7\DateInterval } | "\"P1D\""
""
HEREDOC
);


// > TEST
// > распознаем дату, временную зону и интервал
$fn = function () use ($calendar) {
    _dump_ln('TEST 2');

    $result = $calendar->parseDateTime($datetime = '1970-01-01 00:00:00', $formats = [ 'Y-m-d H:i:s' ], $timezoneIfParsed = 'UTC');
    _dump_ln($result, json_encode($result));

    $result = $calendar->parseDateTimeImmutable($datetime = '1970-01-01 00:00:00', $formats = [ 'Y-m-d H:i:s' ], $timezoneIfParsed = 'UTC');
    _dump_ln($result, json_encode($result));

    $result = $calendar->parseDateTimeZone($timezone = 'UTC');
    _dump_ln($result, json_encode($result));

    $result = $calendar->parseDateInterval($interval = 'P0D', $formats = null);
    _dump_ln($result, json_encode($result));

    _dump('');
};
_assert_call($fn, [], PHP_VERSION_ID >= 80000
    ? <<<HEREDOC
"TEST 2"
{ object # Gzhegow\Calendar\Struct\PHP8\DateTime } | "\"1970-01-01T00:00:00.000+00:00\""
{ object # Gzhegow\Calendar\Struct\PHP8\DateTimeImmutable } | "\"1970-01-01T00:00:00.000+00:00\""
{ object # Gzhegow\Calendar\Struct\PHP8\DateTimeZone } | "\"UTC\""
{ object # Gzhegow\Calendar\Struct\PHP8\DateInterval } | "\"P0D\""
""
HEREDOC
    : <<<HEREDOC
"TEST 2"
{ object # Gzhegow\Calendar\Struct\PHP7\DateTime } | "\"1970-01-01T00:00:00.000+00:00\""
{ object # Gzhegow\Calendar\Struct\PHP7\DateTimeImmutable } | "\"1970-01-01T00:00:00.000+00:00\""
{ object # Gzhegow\Calendar\Struct\PHP7\DateTimeZone } | "\"UTC\""
{ object # Gzhegow\Calendar\Struct\PHP7\DateInterval } | "\"P0D\""
""
HEREDOC
);


// > TEST
// > проводим действия над датой
$fn = function () use ($calendar) {
    _dump_ln('TEST 3');

    $dateTimeImmutable11 = $calendar->parseDateTimeImmutable($datetime = '2000-01-01 midnight', $formats = null, $timezoneIfParsed = null);
    $dateTimeImmutable12 = $dateTimeImmutable11->modify('+ 10 hours');
    $dateTimeImmutableDiff13 = $dateTimeImmutable11->diff($dateTimeImmutable12);
    _dump_ln($dateTimeImmutable11, json_encode($dateTimeImmutable11));
    _dump_ln($dateTimeImmutable12, json_encode($dateTimeImmutable12));
    _dump_ln($dateTimeImmutableDiff13, $calendar->formatIntervalAgo($dateTimeImmutableDiff13));

    $dateTimeImmutable21 = $calendar->parseDateTimeImmutable($datetime = '2000-01-01 midnight', $formats = null, $timezoneIfParsed = null);
    $dateTimeImmutable22 = $dateTimeImmutable21->add(new \DateInterval('PT10H'));
    $dateTimeImmutableDiff23 = $dateTimeImmutable21->diff($dateTimeImmutable22);
    _dump_ln($dateTimeImmutable21, json_encode($dateTimeImmutable21));
    _dump_ln($dateTimeImmutable22, json_encode($dateTimeImmutable22));
    _dump_ln($dateTimeImmutableDiff23, $calendar->formatIntervalAgo($dateTimeImmutableDiff23));

    $dateTimeImmutable31 = $calendar->parseDateTimeImmutable($datetime = '2000-01-01 midnight', $formats = null, $timezoneIfParsed = null);
    $dateTimeImmutable32 = $dateTimeImmutable31->sub(new \DateInterval('PT10H'));
    $dateTimeImmutableDiff33 = $dateTimeImmutable31->diff($dateTimeImmutable32);
    _dump_ln($dateTimeImmutable31, json_encode($dateTimeImmutable31));
    _dump_ln($dateTimeImmutable32, json_encode($dateTimeImmutable32));
    _dump_ln($dateTimeImmutableDiff33, $calendar->formatIntervalAgo($dateTimeImmutableDiff33));

    _dump('');
};
_assert_call($fn, [], PHP_VERSION_ID >= 80000
    ? <<<HEREDOC
"TEST 3"
{ object # Gzhegow\Calendar\Struct\PHP8\DateTimeImmutable } | "\"2000-01-01T00:00:00.000+03:00\""
{ object # Gzhegow\Calendar\Struct\PHP8\DateTimeImmutable } | "\"2000-01-01T10:00:00.000+03:00\""
{ object # Gzhegow\Calendar\Struct\PHP8\DateInterval } | "через 10 час."
{ object # Gzhegow\Calendar\Struct\PHP8\DateTimeImmutable } | "\"2000-01-01T00:00:00.000+03:00\""
{ object # Gzhegow\Calendar\Struct\PHP8\DateTimeImmutable } | "\"2000-01-01T10:00:00.000+03:00\""
{ object # Gzhegow\Calendar\Struct\PHP8\DateInterval } | "через 10 час."
{ object # Gzhegow\Calendar\Struct\PHP8\DateTimeImmutable } | "\"2000-01-01T00:00:00.000+03:00\""
{ object # Gzhegow\Calendar\Struct\PHP8\DateTimeImmutable } | "\"1999-12-31T14:00:00.000+03:00\""
{ object # Gzhegow\Calendar\Struct\PHP8\DateInterval } | "10 час. назад"
""
HEREDOC
    : <<<HEREDOC
"TEST 3"
{ object # Gzhegow\Calendar\Struct\PHP7\DateTimeImmutable } | "\"2000-01-01T00:00:00.000+03:00\""
{ object # Gzhegow\Calendar\Struct\PHP7\DateTimeImmutable } | "\"2000-01-01T10:00:00.000+03:00\""
{ object # Gzhegow\Calendar\Struct\PHP7\DateInterval } | "через 10 час."
{ object # Gzhegow\Calendar\Struct\PHP7\DateTimeImmutable } | "\"2000-01-01T00:00:00.000+03:00\""
{ object # Gzhegow\Calendar\Struct\PHP7\DateTimeImmutable } | "\"2000-01-01T10:00:00.000+03:00\""
{ object # Gzhegow\Calendar\Struct\PHP7\DateInterval } | "через 10 час."
{ object # Gzhegow\Calendar\Struct\PHP7\DateTimeImmutable } | "\"2000-01-01T00:00:00.000+03:00\""
{ object # Gzhegow\Calendar\Struct\PHP7\DateTimeImmutable } | "\"1999-12-31T14:00:00.000+03:00\""
{ object # Gzhegow\Calendar\Struct\PHP7\DateInterval } | "10 час. назад"
""
HEREDOC
);


// > TEST
// > проводим действия над датой
$fn = function () use ($calendar) {
    _dump_ln('TEST 4');

    $dateTime = $calendar->dateTime();
    $formatted = $calendar->formatHumanDate($dateTime);
    _dump_ln($dateTime, json_encode($dateTime), $formatted);

    $dateTime = $calendar->dateTime();
    $formatted = $calendar->formatHumanDay($dateTime);
    _dump_ln($dateTime, json_encode($dateTime), $formatted);

    _dump('');
};
_assert_call($fn, [], PHP_VERSION_ID >= 80000
    ? <<<HEREDOC
"TEST 4"
{ object # Gzhegow\Calendar\Struct\PHP8\DateTime } | "\"1970-01-01T00:00:00.000+03:00\"" | "Thu, 01 Jan 1970 00:00:00 +0300"
{ object # Gzhegow\Calendar\Struct\PHP8\DateTime } | "\"1970-01-01T00:00:00.000+03:00\"" | "Thu, 01 Jan 1970 +0300"
""
HEREDOC
    : <<<HEREDOC
"TEST 4"
{ object # Gzhegow\Calendar\Struct\PHP7\DateTime } | "\"1970-01-01T00:00:00.000+03:00\"" | "Thu, 01 Jan 1970 00:00:00 +0300"
{ object # Gzhegow\Calendar\Struct\PHP7\DateTime } | "\"1970-01-01T00:00:00.000+03:00\"" | "Thu, 01 Jan 1970 +0300"
""
HEREDOC
);
```