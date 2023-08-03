<?php

namespace Pebble\Validation\Rules;

class Exact extends Rule
{
    /**
     * @param mixed $compare
     */
    public function __construct($compare)
    {
        $this->name = 'match';
        $this->properties['compare'] = $compare;
    }

    /**
     * @param mixed $compare
     * @return static
     */
    public static function create($compare): static
    {
        return new static($compare);
    }

    /**
     * @param mixed $value
     * @return bool
     */
    public function validate(mixed $value): bool
    {
        $this->value = $value;
        return $this->value === $this->properties['compare'];
    }
}
