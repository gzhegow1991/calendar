<?php

namespace Gzhegow\Calendar;

class Lib
{
    /**
     * > gzhegow, выводит короткую и наглядную форму содержимого переменной в виде строки
     */
    public static function php_dump($value, int $maxlen = null) : string
    {
        if (is_string($value)) {
            $_value = ''
                . '{ '
                . 'string(' . strlen($value) . ')'
                . ' "'
                . ($maxlen
                    ? (substr($value, 0, $maxlen) . '...')
                    : $value
                )
                . '"'
                . ' }';

        } elseif (! is_iterable($value)) {
            $_value = null
                ?? (($value === null) ? '{ NULL }' : null)
                ?? (($value === false) ? '{ FALSE }' : null)
                ?? (($value === true) ? '{ TRUE }' : null)
                ?? (is_object($value) ? ('{ object(' . get_class($value) . ' # ' . spl_object_id($value) . ') }') : null)
                ?? (is_resource($value) ? ('{ resource(' . gettype($value) . ' # ' . ((int) $value) . ') }') : null)
                //
                ?? (is_int($value) ? (var_export($value, 1)) : null) // INF
                ?? (is_float($value) ? (var_export($value, 1)) : null) // NAN
                //
                ?? null;

        } else {
            foreach ( $value as $k => $v ) {
                $value[ $k ] = null
                    ?? (is_array($v) ? '{ array(' . count($v) . ') }' : null)
                    ?? (is_iterable($v) ? '{ iterable(' . get_class($value) . ' # ' . spl_object_id($value) . ') }' : null)
                    // ! recursion
                    ?? static::php_dump($v, $maxlen);
            }

            $_value = var_export($value, true);

            $_value = str_replace("\n", ' ', $_value);
            $_value = preg_replace('/\s+/', ' ', $_value);
        }

        if (null === $_value) {
            throw static::php_throw(
                'Unable to dump variable'
            );
        }

        return $_value;
    }

    /**
     * > gzhegow, перебрасывает исключение на "тихое", если из библиотеки внутреннее постоянно подсвечивается в PHPStorm
     *
     * @return \LogicException|null
     */
    public static function php_throw($error = null, ...$errors) : ?object
    {
        if (is_a($error, \Closure::class)) {
            $error = $error(...$errors);
        }

        if (
            is_a($error, \LogicException::class)
            || is_a($error, \RuntimeException::class)
        ) {
            return $error;
        }

        $throwErrors = static::php_throw_errors($error, ...$errors);

        $message = $throwErrors[ 'message' ] ?? __FUNCTION__;
        $code = $throwErrors[ 'code' ] ?? -1;
        $previous = $throwErrors[ 'previous' ] ?? null;

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
     *     messageData: array,
     *     messageObject: object,
     * }
     */
    public static function php_throw_errors($error = null, ...$errors) : array
    {
        $_message = null;
        $_code = null;
        $_previous = null;
        $_messageData = null;
        $_messageObject = null;

        array_unshift($errors, $error);

        foreach ( $errors as $err ) {
            if (is_int($err)) {
                $_code = $err;

                continue;
            }

            if (is_a($err, \Throwable::class)) {
                $_previous = $err;

                continue;
            }

            if (null !== ($_string = static::filter_string($err))) {
                $_message = $_string;

                continue;
            }

            if (
                is_array($err)
                || is_a($err, \stdClass::class)
            ) {
                $_messageData = (array) $err;

                if (isset($_messageData[ 0 ])) {
                    $_message = static::filter_string($_messageData[ 0 ]);
                }
            }
        }

        $_message = $_message ?? null;
        $_code = $_code ?? null;
        $_previous = $_previous ?? null;

        $_messageObject = null
            ?? ((null !== $_messageData) ? (object) $_messageData : null)
            ?? ((null !== $_message) ? (object) [ $_message ] : null);

        if (null !== $_messageData) {
            unset($_messageData[ 0 ]);

            $_messageData = $_messageData ?: null;
        }

        $result = [];
        $result[ 'message' ] = $_message;
        $result[ 'code' ] = $_code;
        $result[ 'previous' ] = $_previous;
        $result[ 'messageData' ] = $_messageData;
        $result[ 'messageObject' ] = $_messageObject;

        return $result;
    }


    /**
     * > gzhegow, вызывает произвольный колбэк с аргументами, если результат NULL - бросает исключение
     * > _assert('_filter_strlen', [ $input ], 'Переменная `input` должна быть не-пустой строкой')
     *
     * @param callable $fn
     */
    public static function assert($fn, array $args = [], $error = '', ...$errors)
    {
        $result = ($fn === null)
            ? $fn
            : call_user_func_array($fn, $args);

        if (null === $result) {
            if (('' === $error) || (null === $error)) {
                if (! $errors) {
                    $error = [ '[ ' . __FUNCTION__ . ' ] ' . static::php_dump($fn), $args ];
                }
            }

            throw static::php_throw($error, ...$errors);
        }

        return $result;
    }

    /**
     * > gzhegow, вызывает произвольный колбэк с аргументами, если колбэк вернул не TRUE, бросает исключение, иначе $args[0]
     * > _assert_true('is_int', [ $input ], 'Переменная `input` должна быть числом')
     *
     * @param callable $fn
     */
    public static function assert_true($fn, array $args = [], $error = '', ...$errors) // : mixed
    {
        $bool = is_bool($fn)
            ? $fn
            : (bool) call_user_func_array($fn, $args);

        if (true !== $bool) {
            if (('' === $error) || (null === $error)) {
                if (! $errors) {
                    $error = [ '[ ' . __FUNCTION__ . ' ] ' . static::php_dump($fn), $args ];
                }
            }

            throw static::php_throw($error, ...$errors);
        }

        return $args[ 0 ] ?? null;
    }


    public static function filter_int($value) : ?int
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
            if (null === ($_valueOriginal = static::filter_str($valueOriginal))) {
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

    public static function filter_num($value) // : ?int|float
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
            if (null === ($_valueOriginal = static::filter_str($valueOriginal))) {
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

    public static function filter_str($value) : ?string
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

    public static function filter_string($value) : ?string
    {
        if (null === ($_value = static::filter_str($value))) {
            return null;
        }

        if ('' === $_value) {
            return null;
        }

        return $_value;
    }

    public static function filter_trim($value) : ?string
    {
        if (null === ($_value = static::filter_str($value))) {
            return null;
        }

        $_value = trim($_value);

        if ('' === $_value) {
            return null;
        }

        return $_value;
    }

    public static function filter_word($value) : ?string
    {
        if (null === ($_value = static::filter_trim($value))) {
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
}
