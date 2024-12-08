<?php

namespace Gzhegow\Calendar\Lib\Traits;

trait ParseTrait
{
    public static function parse_string($value) : ?string
    {
        if (is_string($value)) {
            return $value;
        }

        if (
            (null === $value)
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

    public static function parse_astring($value) : ?string
    {
        if (null === ($_value = static::parse_string($value))) {
            return null;
        }

        if ('' === $_value) {
            return null;
        }

        return $_value;
    }


    public static function parse_int($value) : ?int
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
            if (null === ($_valueOriginal = static::parse_string($valueOriginal))) {
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

    public static function parse_num($value) // : ?int|float
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
            if (null === ($_valueOriginal = static::parse_string($valueOriginal))) {
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
}
