<?php

namespace Pebble\Validation\Rules;

class IsUrl extends Rule
{
    public function __construct()
    {
        $this->name = 'is_url';
    }

    /**
     * @return static
     */
    public static function create(): static
    {
        return new static();
    }

    public function validate(mixed $value): bool
    {
        $this->value = $value;
        return !!filter_var($value, FILTER_VALIDATE_URL);
    }
}
