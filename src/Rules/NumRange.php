<?php

namespace Pebble\Validation\Rules;

class NumRange extends Rule
{
    /**
     * @param int|float $min
     */
    public function __construct(int|float $min, int|float $max)
    {
        $this->name = 'num_range';
        $this->properties['min'] = $min;
        $this->properties['max'] = $max;
    }

    /**
     * @param int|float $min
     * @return static
     */
    public static function create(int|float $min, int|float $max): static
    {
        return new static($min, $max);
    }

    /**
     * @param mixed $value
     * @return bool
     */
    public function validate(mixed $value): bool
    {
        $this->value = $value;
        return $this->value >= $this->properties['min'] && $this->value <= $this->properties['max'];
    }
}
