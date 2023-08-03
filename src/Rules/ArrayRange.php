<?php

namespace Pebble\Validation\Rules;

class ArrayRange extends Rule
{
    /**
     * @param int $min
     * @param int $max
     */
    public function __construct(int $min, int $max)
    {
        $this->name = 'array_range';
        $this->properties['min'] = $min;
        $this->properties['max'] = $max;
    }

    /**
     * @param int $max
     * @return static
     */
    public static function create(int $min, int $max): static
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
        $nb = count($this->value);
        return $nb >= $this->properties['min'] && $nb <= $this->properties['max'];
    }
}
