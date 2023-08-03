<?php

namespace Pebble\Validation\Rules;

class IsFile extends Rule
{
    /**
     * @param string $prefix
     * @param string $suffix
     */
    public function __construct(string $prefix = '', string $suffix = '')
    {
        $this->name = 'is_file';
        $this->properties['prefix'] = $prefix;
        $this->properties['suffix'] = $suffix;
    }

    /**
     * @param string $prefix
     * @param string $suffix
     * @return static
     */
    public static function create(string $prefix = '', string $suffix = ''): static
    {
        return new static($prefix, $suffix);
    }

    public function validate(mixed $value): bool
    {
        $this->value = $value;
        return $value && is_file($this->properties['prefix'] . $value . $this->properties['suffix']);
    }
}
