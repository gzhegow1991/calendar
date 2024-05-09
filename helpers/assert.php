<?php

namespace Gzhegow\Calendar;


/**
 * > gzhegow, вызывает произвольный колбэк с аргументами, если результат NULL - исключение
 * > бросает исключение, позволяет указать ошибку для исключения
 * > _assert('_filter_strlen', [ $input ], 'Переменная `input` должна быть не-пустой строкой')
 *
 * @param callable   $fn
 * @param array      $args
 * @param mixed|null $error
 *
 * @return mixed
 */
function _assert($fn, array $args = [], $error = '')
{
    $_error = null
        ?? ($error ?: null)
        ?? (('0' === $error) ? $error : null)
        ?? (is_string($fn) ? "[ ASSERT ] {$fn}" : null);

    $result = call_user_func_array($fn, $args);

    if (null === $result) {
        throw _php_throw($_error);
    }

    return $result;
}

/**
 * > gzhegow, вызывает произвольный колбэк с аргументами, преобразует результат в bool
 * > бросает исключение, позволяет указать ошибку для исключения
 * > _assert_true('is_int', [ $input ], 'Переменная `input` должна быть числом')
 *
 * @param callable   $fn
 * @param array      $args
 * @param mixed|null $error
 *
 * @return bool
 */
function _assert_true($fn, array $args = [], $error = '') : bool
{
    $_error = null
        ?? ($error ?: null)
        ?? (('0' === $error) ? $error : null)
        ?? (is_string($fn) ? "[ ASSERT ] {$fn}" : null);

    $bool = (bool) call_user_func_array($fn, $args);

    if (false === $bool) {
        throw _php_throw($_error);
    }

    return true;
}


function _filter_int($value) : ?int
{
    if (is_int($value)) {
        return $value;
    }

    if (is_string($value)) {
        if (! is_numeric($value)) {
            return null;
        }
    }

    $valueOriginal = $value;

    if (! is_scalar($valueOriginal)) {
        if (null === ($_valueOriginal = _filter_str($valueOriginal))) {
            return null;
        }

        if (! is_numeric($_valueOriginal)) {
            return null;
        }

        $valueOriginal = $_valueOriginal;
    }

    $_value = $valueOriginal;
    $status = @settype($_value, 'integer');

    if ($status) {
        if ((float) $valueOriginal !== (float) $_value) {
            return null;
        }

        return $_value;
    }

    return null;
}

function _filter_num($value) // : ?int|float
{
    if (is_int($value)) {
        return $value;
    }

    if (is_float($value)) {
        if (! is_finite($value)) {
            return null;

        } else {
            return $value;
        }
    }

    if (is_string($value)) {
        if (! is_numeric($value)) {
            return null;
        }
    }

    $valueOriginal = $value;

    if (! is_scalar($valueOriginal)) {
        if (null === ($_valueOriginal = _filter_str($valueOriginal))) {
            return null;
        }

        if (! is_numeric($_valueOriginal)) {
            return null;
        }

        $valueOriginal = $_valueOriginal;
    }

    $_value = $valueOriginal;

    $_valueInt = $_value;
    $statusInt = @settype($_valueInt, 'integer');

    $_valueFloat = $_value;
    $statusFloat = @settype($_valueFloat, 'float');

    if ($statusInt) {
        if ($_valueFloat === (float) $_valueInt) {
            return $_valueInt;
        }
    }

    if ($statusFloat) {
        return $_valueFloat;
    }

    return null;
}

function _filter_str($value) : ?string
{
    if (is_string($value)) {
        return $value;
    }

    if (
        is_null($value)
        || is_array($value)
        || is_resource($value)
    ) {
        return null;
    }

    if (is_object($value)) {
        if (method_exists($value, '__toString')) {
            $_value = (string) $value;

            return $_value;
        }

        return null;
    }

    $_value = $value;
    $status = @settype($_value, 'string');

    if ($status) {
        return $_value;
    }

    return null;
}

function _filter_string($value) : ?string
{
    if (null === ($_value = _filter_str($value))) {
        return null;
    }

    if ('' === $_value) {
        return null;
    }

    return $_value;
}

function _filter_trim($value) : ?string
{
    if (null === ($_value = _filter_str($value))) {
        return null;
    }

    $_value = trim($_value);

    if ('' === $_value) {
        return null;
    }

    return $_value;
}

function _filter_word($value) : ?string
{
    if (null === ($_value = _filter_trim($value))) {
        return null;
    }

    if (false !== strpos($_value, ' ')) {
        return null;
    }

    if (false === preg_match('/[^\p{L}\d_]/u', $_value, $m)) {
        return null;
    }

    if ($m) {
        return null;
    }

    return $_value;
}
