<?php

namespace Pebble\Validation\Fields;

use Pebble\Validation\Rules as R;

/**
 * Number
 *
 * @author mathieu
 */
class Number extends Field
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
            return (float)$value;
        }

        if (is_bool($value)) {
            return (float)$value;
        }

        $this->error = $this->prepare;

        return null;
    }

    // -------------------------------------------------------------------------
    // Rules
    // -------------------------------------------------------------------------

    /**
     * @param float $min
     * @return static
     */
    public function min(float $min): static
    {
        return $this->addRule(R\NumMin::create($min));
    }

    /**
     * @param float $max
     * @return static
     */
    public function max(float $max): static
    {
        return $this->addRule(R\NumMax::create($max));
    }

    /**
     * @param float $min
     * @param float $max
     * @return static
     */
    public function range(float $min, float $max): static
    {
        return $this->addRule(R\NumRange::create($min, $max));
    }

    /**
     * @param float $val
     * @return static
     */
    public function equal(float $val): static
    {
        return $this->addRule(R\Exact::create($val));
    }

    /**
     * @param float $val
     * @return static
     */
    public function diff(float $val): static
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
