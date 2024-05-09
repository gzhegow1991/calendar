<?php

namespace Gzhegow\Calendar;


/**
 * > gzhegow, выводит короткую и наглядную форму содержимого переменной в виде строки
 */
function _php_dump($value) : string
{
    if (! is_iterable($value)) {
        $_value = null
            ?? (($value === null) ? '{ NULL }' : null)
            ?? (($value === false) ? '{ FALSE }' : null)
            ?? (($value === true) ? '{ TRUE }' : null)
            ?? (is_object($value) ? ('{ object(' . get_class($value) . ' # ' . spl_object_id($value) . ') }') : null)
            ?? (is_resource($value) ? ('{ resource(' . gettype($value) . ' # ' . ((int) $value) . ') }') : null)
            //
            ?? (is_int($value) ? (var_export($value, 1)) : null) // INF
            ?? (is_float($value) ? (var_export($value, 1)) : null) // NAN
            ?? (is_string($value) ? ('"' . $value . '"') : null)
            //
            ?? null;

    } else {
        foreach ( $value as $k => $v ) {
            $value[ $k ] = null
                ?? (is_array($v) ? '{ array(' . count($v) . ') }' : null)
                ?? (is_iterable($v) ? '{ iterable(' . get_class($value) . ' # ' . spl_object_id($value) . ') }' : null)
                // > ! recursion
                ?? _php_dump($v);
        }

        $_value = var_export($value, true);

        $_value = str_replace("\n", ' ', $_value);
        $_value = preg_replace('/\s+/', ' ', $_value);
    }

    if (null === $_value) {
        throw new \LogicException('Unable to dump variable');
    }

    return $_value;
}

/**
 * > gzhegow, перебрасывает исключение на "тихое", если из библиотеки внутреннее постоянно подсвечивается в PHPStorm
 *
 * @return \LogicException|null
 */
function _php_throw($error, ...$errors) : ?object
{
    if (
        is_a($error, \LogicException::class)
        || is_a($error, \RuntimeException::class)
    ) {
        return $error;
    }

    array_unshift($errors, $error);

    $throws = _php_throw_errors(...$errors);

    $message = $throws[ 'message' ] ?? 'EXCEPTION';
    $code = $throws[ 'code' ] ?? -1;
    $previous = $throws[ 'previous' ] ?? null;

    return $previous
        ? new \RuntimeException($message, $code, $previous)
        : new \LogicException($message, $code);
}

/**
 * > gzhegow, парсит ошибки для передачи результата в конструктор исключения
 *
 * @return array{
 *     message: string,
 *     code: int,
 *     previous: string,
 *     messageCode: string,
 *     messageData: array,
 *     messageObject: object,
 * }
 */
function _php_throw_errors(...$errors) : array
{
    $_message = null;
    $_code = null;
    $_previous = null;
    $_messageCode = null;
    $_messageObject = null;
    $_messageData = null;

    foreach ( $errors as $error ) {
        if (is_int($error)) {
            $_code = $error;

            continue;
        }

        if (is_a($error, \Throwable::class)) {
            $_previous = $error;

            continue;
        }

        if (null !== ($_string = _filter_string($error))) {
            $_message = $_string;
            $_messageCode = _filter_word($_message);

            continue;
        }

        if (
            is_array($error)
            || is_a($error, \stdClass::class)
        ) {
            $_messageData = (array) $error;

            if (isset($_messageData[ 0 ])) {
                $_message = _filter_string($_messageData[ 0 ]);
                $_messageCode = _filter_word($_message);
            }
        }
    }

    $_message = $_message ?? null;
    $_code = $_code ?? null;
    $_previous = $_previous ?? null;

    $_messageCode = $_messageCode ?? null;

    $_messageObject = null
        ?? (isset($_messageData) ? (object) $_messageData : null)
        ?? (isset($_message) ? (object) [ $_message ] : null);

    if (isset($_messageData)) {
        array_shift($_messageData);

        $_messageData = $_messageData ?: null;
    }

    $result = [];
    $result[ 'message' ] = $_message;
    $result[ 'code' ] = $_code;
    $result[ 'previous' ] = $_previous;
    $result[ 'messageCode' ] = $_messageCode;
    $result[ 'messageData' ] = $_messageData;
    $result[ 'messageObject' ] = $_messageObject;

    return $result;
}
