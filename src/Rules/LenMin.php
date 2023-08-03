<?php

namespace Pebble\Validation\Rules;

class LenMin extends Rule
{
    /**
     * @param int $min
     */
    public function __construct(int $min)
    {
        $this->name = 'len_min';
        $this->properties['min'] = $min;
    }

    /**
     * @param int $min
     * @return static
     */
    public static function create(int $min): static
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
        return mb_strlen($this->value) >= $this->properties['min'];
    }
}
