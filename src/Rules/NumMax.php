<?php

namespace Pebble\Validation\Rules;

class NumMax extends Rule
{
    /**
     * @param int|float $max
     */
    public function __construct(int|float $max)
    {
        $this->name = 'num_max';
        $this->properties['max'] = $max;
    }

    /**
     * @param int|float $max
     * @return static
     */
    public static function create(int|float $max): static
    {
        return new static($max);
    }

    /**
     * @param mixed $value
     * @return bool
     */
    public function validate(mixed $value): bool
    {
        $this->value = $value;
        return $this->value <= $this->properties['max'];
    }
}
