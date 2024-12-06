<?php

namespace Pebble\Validation\Rules;

class Uuid extends Rule
{
    public function __construct()
    {
        $this->name = 'format';
    }

    /**
     * @return static
     */
    public static function create(): static
    {
        return new static();
    }

    /**
     * @param mixed $value
     * @return bool
     */
    public function validate(mixed $value): bool
    {
        $this->value = $value;
        $pattern = "/^([a-fA-F0-9]{8}-[a-fA-F0-9]{4}-[a-fA-F0-9]{4}-[a-fA-F0-9]{4}-[a-fA-F0-9]{12})$/i";
        return preg_match($pattern, $this->value) === 1;
    }
}
