<?php

namespace Pebble\Validation\Rules;

class NumMin extends Rule
{
    /**
     * @param int|float $min
     */
    public function __construct(int|float $min)
    {
        $this->name = 'num_min';
        $this->properties['min'] = $min;
    }

    /**
     * @param int|float $min
     * @return static
     */
    public static function create(int|float $min): static
    {
        return new static($min);
    }

    /**
     * @param mixed $value
     * @return bool
     */
    public function validate(mixed $value): bool
    {
        $this->value = $value;
        return $this->value >= $this->properties['min'];
    }
}
