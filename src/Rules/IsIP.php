<?php

namespace Pebble\Validation\Rules;

class IsIP extends Rule
{
    public function __construct($flags = 0)
    {
        $this->name = 'is_ip';
        $this->properties['flags'] = $flags;
    }

    /**
     * @return static
     */
    public static function create($flags = 0): static
    {
        return new static($flags);
    }

    /**
     * @param mixed $value
     * @return bool
     */
    public function validate(mixed $value): bool
    {
        $this->value = $value;
        return !!filter_var($value, FILTER_VALIDATE_IP, $this->properties['flags']);
    }
}
