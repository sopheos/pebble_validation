<?php

namespace Pebble\Validation\Rules;

class LenRange extends Rule
{
    /**
     * @param int $min
     */
    public function __construct(int $min, int $max)
    {
        $this->name = 'len_range';
        $this->properties['min'] = $min;
        $this->properties['max'] = $max;
    }

    /**
     * @param int $min
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
        $len = mb_strlen($this->value);
        return $len >= $this->properties['min'] && $len <= $this->properties['max'];
    }
}
