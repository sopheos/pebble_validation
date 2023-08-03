<?php

namespace Pebble\Validation\Rules;

class ArrayMax extends Rule
{
    /**
     * @param int $max
     */
    public function __construct(int $max)
    {
        $this->name = 'array_max';
        $this->properties['max'] = $max;
    }

    /**
     * @param int $max
     * @return static
     */
    public static function create(int $max): static
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
        return count($this->value) <= $this->properties['max'];
    }
}
