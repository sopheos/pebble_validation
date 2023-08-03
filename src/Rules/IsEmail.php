<?php

namespace Pebble\Validation\Rules;

class IsEmail extends Rule
{
    public function __construct()
    {
        $this->name = 'is_email';
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
        $this->value = mb_strtolower($value);

        return $this->value
            && !!filter_var($this->value, FILTER_VALIDATE_EMAIL);
    }
}
