<?php

namespace Pebble\Validation\Fields;

use Pebble\Validation\Rules as R;

/**
 * Integer
 *
 * @author mathieu
 */
class Integer extends Field
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

        if (is_string($value)) {
            $value = trim($value);
        }

        if ($value === '') {
            return null;
        }

        if (is_numeric($value)) {
            return (int)$value;
        }

        if (is_bool($value)) {
            return (int)$value;
        }

        $this->error = $this->prepare;

        return null;
    }

    // -------------------------------------------------------------------------
    // Rules
    // -------------------------------------------------------------------------

    /**
     * @param int $min
     * @return static
     */
    public function min(int $min): static
    {
        return $this->addRule(R\NumMin::create($min));
    }

    /**
     * @param int $max
     * @return static
     */
    public function max(int $max): static
    {
        return $this->addRule(R\NumMax::create($max));
    }

    /**
     * @param int $min
     * @param int $max
     * @return static
     */
    public function range(int $min, int $max): static
    {
        return $this->addRule(R\NumRange::create($min, $max));
    }

    /**
     * @param int $val
     * @return static
     */
    public function equal(int $val): static
    {
        return $this->addRule(R\Exact::create($val));
    }

    /**
     * @param int $val
     * @return static
     */
    public function diff(int $val): static
    {
        return $this->addRule(R\Differ::create($val));
    }

    /**
     * @param array $items
     * @return static
     */
    public function includes(array $items): static
    {
        return $this->addRule(R\Includes::create($items));
    }

    /**
     * @param array $items
     * @return static
     */
    public function excludes(array $items): static
    {
        return $this->addRule(R\Excludes::create($items));
    }

    // -------------------------------------------------------------------------
}
