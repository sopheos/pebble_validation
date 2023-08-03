<?php

namespace Pebble\Validation\Fields;

use Pebble\Validation\Rules as R;

/**
 * Boolean
 *
 * @author mathieu
 */
class Boolean extends Field
{
    protected $prepare = 'default';

    /**
     * @param mixed $value
     * @return string
     */
    protected function prepare(mixed $value): mixed
    {
        if ($value === null) {
            return null;
        }

        if (is_bool($value)) {
            return $value;
        }

        if (is_numeric($value)) {
            $value = (int) $value;
            if ($value === 0) {
                return false;
            } elseif ($value === 1) {
                return true;
            }

            $this->error = $this->prepare;
            return null;
        }

        if (is_string($value)) {
            $value = trim($value);
            if ($value === '') {
                return null;
            }
            $value = filter_var($value, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
            if ($value !== null) {
                return $value;
            }
        }

        $this->error = $this->prepare;
        return null;
    }

    // -------------------------------------------------------------------------
    // Rules
    // -------------------------------------------------------------------------

    /**
     * @param string $val
     * @return static
     */
    public function isTrue(): static
    {
        return $this->addRule(R\Exact::create(true));
    }

    /**
     * @param string $val
     * @return static
     */
    public function isFalse(): static
    {
        return $this->addRule(R\Exact::create(false));
    }

    // -------------------------------------------------------------------------
}
