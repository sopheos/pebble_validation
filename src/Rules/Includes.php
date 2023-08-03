<?php

namespace Pebble\Validation\Rules;

class Includes extends Rule
{
    /**
     * @param array $items
     */
    public function __construct(array $items)
    {
        $this->name = 'includes';
        $this->properties['items'] = $items ?? [];
    }

    /**
     * @param array $items
     * @return static
     */
    public static function create(array $items): static
    {
        return new static($items);
    }

    /**
     * @param mixed $value
     * @return bool
     */
    public function validate(mixed $value): bool
    {
        $this->value = $value;
        return in_array($this->value, $this->properties['items']);
    }
}
