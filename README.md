# Calendar

## Что это

Этот пакет сделан, чтобы сделать работу с датами более удобной.

- Позволяет передавать в конструкторы дат и временных зон строки без необходимости создавать объект ради объекта
- В нем можно посмотреть, как сделать грамотное наследование имеющищегося в коробке PHP ужаса, чтобы этим управлять или добавить своё.

## Установка

```
composer require gzhegow/calendar;
```

## Примеры и тесты

```php
<?php

require_once __DIR__ . '/vendor/autoload.php';


// > настраиваем PHP
ini_set('memory_limit', '32M');


// > настраиваем обработку ошибок
(new \Gzhegow\Lib\Exception\ErrorHandler())
    ->useErrorReporting()
    ->useErrorHandler()
    ->useExceptionHandler()
;


// > добавляем несколько функция для тестирования
function _values($separator = null, ...$values) : string
{
    return \Gzhegow\Lib\Lib::debug()->values($separator, [], ...$values);
}

function _print(...$values) : void
{
    echo _values(' | ', ...$values) . PHP_EOL;
}

function _assert_stdout(
    \Closure $fn, array $fnArgs = [],
    string $expectedStdout = null
) : void
{
    $trace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 1);

    \Gzhegow\Lib\Lib::test()->assertStdout(
        $trace,
        $fn, $fnArgs,
        $expectedStdout
    );
}


// >>> ЗАПУСКАЕМ!

// > сначала всегда фабрика
$factory = new \Gzhegow\Calendar\CalendarFactory();

// > создаем конфигурацию
$config = new \Gzhegow\Calendar\CalendarConfig();
$config->configure(function (\Gzhegow\Calendar\CalendarConfig $config) {
    // > использовать ли INTL, если такое расширение подключено (в целях тестирования установлено в FALSE)
    $config->formatter->useIntl = false;

    // > можно указать "дату по-умолчанию", которая будет создана, если не передать аргументов вовсе
    $config->manager->dateTimeDefault = '1970-01-01 midnight';
    // > можно указать "временную зону по-умолчанию", которая будет установлена, если при разборе даты не удалось определить временную зону
    $config->manager->dateTimeZoneDefault = 'Europe/Minsk';
    // > можно указать "интервал по-умолчанию", который будет создаваться, если не передать аргументов
    $config->manager->dateIntervalDefault = 'P0D';

    // > можно указать форматы для разбора даты, если таковые не переданы прямо в функцию
    $config->parser->parseDateTimeFormatsDefault = [
        \Gzhegow\Calendar\Calendar::FORMAT_SQL,
        \Gzhegow\Calendar\Calendar::FORMAT_JAVASCRIPT,
    ];
    // > можно указать форматы для разбора интервалов, если таковые не переданы прямо в функцию
    $config->parser->parseDateIntervalFormatsDefault = [
        \Gzhegow\Calendar\Calendar::FORMAT_SQL_TIME,
    ];
});
$configFormatter = new \Gzhegow\Calendar\Formatter\CalendarFormatterConfig();
$configManager = new \Gzhegow\Calendar\Manager\CalendarManagerConfig();
$configParser = new \Gzhegow\Calendar\Parser\CalendarParserConfig();


// > можно изменить классы дат на свои собственные реализации
$type = new \Gzhegow\Calendar\Type\CalendarType();

// > создаем парсер
$parser = new \Gzhegow\Calendar\Parser\CalendarParser(
    $factory,
    //
    $config->parser
);

// > создаем менеджер
$manager = new \Gzhegow\Calendar\Manager\CalendarManager(
    $factory,
    //
    $parser,
    //
    $config->manager
);

// > создаем форматтер
$formatter = new \Gzhegow\Calendar\Formatter\CalendarFormatter(
    $factory,
    //
    $config->formatter
);

// > создаем фасад
$calendar = new \Gzhegow\Calendar\CalendarFacade(
    $factory,
    $type,
    //
    $parser,
    $manager,
    $formatter,
    //
    $config
);

// > сохраняем фасад статически (чтобы вызывать без привязки к контейнеру)
\Gzhegow\Calendar\Calendar::setFacade($calendar);


// > TEST
// > создаем дату, временную зону и интервал
$fn = function () use ($calendar) {
    _print('TEST 1');
    echo PHP_EOL;

    $result = $calendar->dateTime($from = '', $dateTimeZone = null);
    _print($result, json_encode($result));

    $result = $calendar->dateTime($from = '1970-01-01 00:00:00', $dateTimeZone = null);
    _print($result, json_encode($result));
    echo PHP_EOL;


    $result = $calendar->dateTimeImmutable($from = '', $dateTimeZone = null);
    _print($result, json_encode($result));

    $result = $calendar->dateTimeImmutable($from = '1970-01-01 00:00:00', $dateTimeZone = null);
    _print($result, json_encode($result));
    echo PHP_EOL;


    $result = $calendar->dateTimeZone($from = '');
    _print($result, json_encode($result));

    $result = $calendar->dateTimeZone($from = 'UTC');
    _print($result, json_encode($result));
    echo PHP_EOL;


    $result = $calendar->dateInterval($from = '');
    _print($result, json_encode($result));

    $result = $calendar->dateInterval($from = 'P1D');
    _print($result, json_encode($result));

    $result = $calendar->dateInterval($from = 'P1.5D');
    _print($result, json_encode($result));
};
_assert_stdout($fn, [], PHP_VERSION_ID >= 80000
    ? '
"TEST 1"

{ object # Gzhegow\Calendar\Struct\DateTime } | "\"1970-01-01T00:00:00.000+03:00\""
{ object # Gzhegow\Calendar\Struct\DateTime } | "\"1970-01-01T00:00:00.000+03:00\""

{ object # Gzhegow\Calendar\Struct\DateTimeImmutable } | "\"1970-01-01T00:00:00.000+03:00\""
{ object # Gzhegow\Calendar\Struct\DateTimeImmutable } | "\"1970-01-01T00:00:00.000+03:00\""

{ object # Gzhegow\Calendar\Struct\DateTimeZone } | "\"Europe\/Minsk\""
{ object # Gzhegow\Calendar\Struct\DateTimeZone } | "\"UTC\""

{ object # Gzhegow\Calendar\Struct\DateInterval } | "\"P0D\""
{ object # Gzhegow\Calendar\Struct\DateInterval } | "\"P1D\""
{ object # Gzhegow\Calendar\Struct\DateInterval } | "\"P1DT12H\""
'
    : '
"TEST 1"

{ object # Gzhegow\Calendar\Struct\PHP7\DateTime } | "\"1970-01-01T00:00:00.000+03:00\""
{ object # Gzhegow\Calendar\Struct\PHP7\DateTime } | "\"1970-01-01T00:00:00.000+03:00\""

{ object # Gzhegow\Calendar\Struct\PHP7\DateTimeImmutable } | "\"1970-01-01T00:00:00.000+03:00\""
{ object # Gzhegow\Calendar\Struct\PHP7\DateTimeImmutable } | "\"1970-01-01T00:00:00.000+03:00\""

{ object # Gzhegow\Calendar\Struct\PHP7\DateTimeZone } | "\"Europe\/Minsk\""
{ object # Gzhegow\Calendar\Struct\PHP7\DateTimeZone } | "\"UTC\""

{ object # Gzhegow\Calendar\Struct\PHP7\DateInterval } | "\"P0D\""
{ object # Gzhegow\Calendar\Struct\PHP7\DateInterval } | "\"P1D\""
{ object # Gzhegow\Calendar\Struct\PHP7\DateInterval } | "\"P1DT12H\""
');

// > TEST
// > распознаем дату, временную зону и интервал
$fn = function () use ($calendar) {
    _print('TEST 2');
    echo PHP_EOL;

    $result = $calendar->parseDateTime($from = '1970-01-01 00:00:00', $formats = [ 'Y-m-d H:i:s' ], $dateTimeZoneIfParsed = 'UTC');
    _print($result, json_encode($result));

    $result = $calendar->parseDateTimeFromNumeric($from = 1.5, $dateTimeZoneIfParsed = 'UTC');
    _print($result, json_encode($result));
    echo PHP_EOL;


    $result = $calendar->parseDateTimeImmutable($from = '1970-01-01 00:00:00', $formats = [ 'Y-m-d H:i:s' ], $dateTimeZoneIfParsed = 'UTC');
    _print($result, json_encode($result));

    $result = $calendar->parseDateTimeImmutableFromNumeric($from = 1.5, $dateTimeZoneIfParsed = 'UTC');
    _print($result, json_encode($result));
    echo PHP_EOL;


    $result = $calendar->parseDateTimeZone($from = 'UTC');
    _print($result, json_encode($result));
    echo PHP_EOL;


    $result = $calendar->parseDateInterval($from = 'P0D', $formats = null);
    _print($result, json_encode($result));

    $result = $calendar->parseDateIntervalFromNumeric($from = 1.5);
    _print($result, json_encode($result));
};
_assert_stdout($fn, [], PHP_VERSION_ID >= 80000
    ? '
"TEST 2"

{ object # Gzhegow\Calendar\Struct\DateTime } | "\"1970-01-01T00:00:00.000+00:00\""
{ object # Gzhegow\Calendar\Struct\DateTime } | "\"1970-01-01T00:00:01.500+00:00\""

{ object # Gzhegow\Calendar\Struct\DateTimeImmutable } | "\"1970-01-01T00:00:00.000+00:00\""
{ object # Gzhegow\Calendar\Struct\DateTimeImmutable } | "\"1970-01-01T00:00:01.500+00:00\""

{ object # Gzhegow\Calendar\Struct\DateTimeZone } | "\"UTC\""

{ object # Gzhegow\Calendar\Struct\DateInterval } | "\"P0D\""
{ object # Gzhegow\Calendar\Struct\DateInterval } | "\"PT1.5S\""
'
    : '
"TEST 2"

{ object # Gzhegow\Calendar\Struct\PHP7\DateTime } | "\"1970-01-01T00:00:00.000+00:00\""
{ object # Gzhegow\Calendar\Struct\PHP7\DateTime } | "\"1970-01-01T00:00:01.500+00:00\""

{ object # Gzhegow\Calendar\Struct\PHP7\DateTimeImmutable } | "\"1970-01-01T00:00:00.000+00:00\""
{ object # Gzhegow\Calendar\Struct\PHP7\DateTimeImmutable } | "\"1970-01-01T00:00:01.500+00:00\""

{ object # Gzhegow\Calendar\Struct\PHP7\DateTimeZone } | "\"UTC\""

{ object # Gzhegow\Calendar\Struct\PHP7\DateInterval } | "\"P0D\""
{ object # Gzhegow\Calendar\Struct\PHP7\DateInterval } | "\"PT1.5S\""
');


// > TEST
// > проводим действия над датой
$fn = function () use ($calendar) {
    _print('TEST 3');
    echo PHP_EOL;

    $dateTimeImmutable11 = $calendar->parseDateTimeImmutable($datetime = '2000-01-01 midnight', $formats = null, $timezoneIfParsed = null);
    $dateTimeImmutable12 = $dateTimeImmutable11->modify('+ 10 hours');
    $dateTimeImmutableDiff13 = $dateTimeImmutable11->diff($dateTimeImmutable12);
    _print($dateTimeImmutable11, json_encode($dateTimeImmutable11));
    _print($dateTimeImmutable12, json_encode($dateTimeImmutable12));
    _print($dateTimeImmutableDiff13, $calendar->formatIntervalAgo($dateTimeImmutableDiff13));

    $dateTimeImmutable21 = $calendar->parseDateTimeImmutable($datetime = '2000-01-01 midnight', $formats = null, $timezoneIfParsed = null);
    $dateTimeImmutable22 = $dateTimeImmutable21->add(new \DateInterval('PT10H'));
    $dateTimeImmutableDiff23 = $dateTimeImmutable21->diff($dateTimeImmutable22);
    _print($dateTimeImmutable21, json_encode($dateTimeImmutable21));
    _print($dateTimeImmutable22, json_encode($dateTimeImmutable22));
    _print($dateTimeImmutableDiff23, $calendar->formatIntervalAgo($dateTimeImmutableDiff23));

    $dateTimeImmutable31 = $calendar->parseDateTimeImmutable($datetime = '2000-01-01 midnight', $formats = null, $timezoneIfParsed = null);
    $dateTimeImmutable32 = $dateTimeImmutable31->sub(new \DateInterval('PT10H'));
    $dateTimeImmutableDiff33 = $dateTimeImmutable31->diff($dateTimeImmutable32);
    _print($dateTimeImmutable31, json_encode($dateTimeImmutable31));
    _print($dateTimeImmutable32, json_encode($dateTimeImmutable32));
    _print($dateTimeImmutableDiff33, $calendar->formatIntervalAgo($dateTimeImmutableDiff33));
};
_assert_stdout($fn, [], PHP_VERSION_ID >= 80000
    ? '
"TEST 3"

{ object # Gzhegow\Calendar\Struct\DateTimeImmutable } | "\"2000-01-01T00:00:00.000+03:00\""
{ object # Gzhegow\Calendar\Struct\DateTimeImmutable } | "\"2000-01-01T10:00:00.000+03:00\""
{ object # Gzhegow\Calendar\Struct\DateInterval } | "через 10 час."
{ object # Gzhegow\Calendar\Struct\DateTimeImmutable } | "\"2000-01-01T00:00:00.000+03:00\""
{ object # Gzhegow\Calendar\Struct\DateTimeImmutable } | "\"2000-01-01T10:00:00.000+03:00\""
{ object # Gzhegow\Calendar\Struct\DateInterval } | "через 10 час."
{ object # Gzhegow\Calendar\Struct\DateTimeImmutable } | "\"2000-01-01T00:00:00.000+03:00\""
{ object # Gzhegow\Calendar\Struct\DateTimeImmutable } | "\"1999-12-31T14:00:00.000+03:00\""
{ object # Gzhegow\Calendar\Struct\DateInterval } | "10 час. назад"
'
    : '
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
');


// > TEST
// > проводим действия над датой
$fn = function () use ($calendar) {
    _print('TEST 4');
    echo PHP_EOL;

    $dateTime = $calendar->dateTime();
    $formatted = $calendar->formatHumanDate($dateTime);
    _print($dateTime, json_encode($dateTime), $formatted);

    $dateTime = $calendar->dateTime();
    $formatted = $calendar->formatHumanDay($dateTime);
    _print($dateTime, json_encode($dateTime), $formatted);
};
_assert_stdout($fn, [], PHP_VERSION_ID >= 80000
    ? '
"TEST 4"

{ object # Gzhegow\Calendar\Struct\DateTime } | "\"1970-01-01T00:00:00.000+03:00\"" | "Thu, 01 Jan 1970 00:00:00 +0300"
{ object # Gzhegow\Calendar\Struct\DateTime } | "\"1970-01-01T00:00:00.000+03:00\"" | "Thu, 01 Jan 1970 +0300"
'
    : '
"TEST 4"

{ object # Gzhegow\Calendar\Struct\PHP7\DateTime } | "\"1970-01-01T00:00:00.000+03:00\"" | "Thu, 01 Jan 1970 00:00:00 +0300"
{ object # Gzhegow\Calendar\Struct\PHP7\DateTime } | "\"1970-01-01T00:00:00.000+03:00\"" | "Thu, 01 Jan 1970 +0300"
'); 
```