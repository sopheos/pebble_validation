<?php

namespace Pebble\Validation\Fields;

use Exception;

/**
 * Timestamp
 *
 * @author mathieu
 */
class Timestamp extends Integer
{
    protected $prepare = 'default';

    /**
     * @param mixed $value
     * @return string
     */
    protected function prepare(mixed $value): mixed
    {
        try {
            return self::sanitize($value);
        } catch (Exception) {
            $this->error = $this->prepare;
        }

        return null;
    }

    public static function sanitize(mixed $value): mixed
    {
        if ($value === null) {
            return null;
        }

        if (is_string($value)) {
            $value = trim($value);
        }

        if ($value === '') {
            return null;
        }

        if (is_numeric($value)) {
            return (int)$value;
        }

        if (is_string($value) && self::isISO($value)) {
            return strtotime($value);
        }

        throw new Exception();
    }

    // -------------------------------------------------------------------------
    // Helpers
    // -------------------------------------------------------------------------

    /**
     * @param string $str
     * @param array $matches
     * @return boolean
     */
    public static function isISO(string $str, array &$matches = []): bool
    {
        return !!preg_match('/^([\+-]?\d{4}(?!\d{2}\b))((-?)((0[1-9]|1[0-2])(\3([12]\d|0[1-9]|3[01]))?|W([0-4]\d|5[0-2])(-?[1-7])?|(00[1-9]|0[1-9]\d|[12]\d{2}|3([0-5]\d|6[1-6])))([T\s]((([01]\d|2[0-3])((:?)[0-5]\d)?|24\:?00)([\.,]\d+(?!:))?)?(\17[0-5]\d([\.,]\d+)?)?([zZ]|([\+-])([01]\d|2[0-3]):?([0-5]\d)?)?)?)?$/', $str, $matches);
    }

    // -------------------------------------------------------------------------
}
