<?php

namespace Pebble\Validation\Rules;

class LenMax extends Rule
{
    /**
     * @param int $max
     */
    public function __construct(int $max)
    {
        $this->name = 'len_max';
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
        return mb_strlen($this->value) <= $this->properties['max'];
    }
}
