<?php

namespace Pebble\Validation\Rules;

class Regex extends Rule
{
    /**
     * @param string $name
     * @param string $pattern
     * @param bool $match
     */
    public function __construct(string $name, string $pattern, bool $match = true)
    {
        $this->name = $name;
        $this->properties['pattern'] = $pattern;
        $this->properties['match'] = $match;
    }

    /**
     * @param string $name
     * @param string $pattern
     * @param bool $match
     * @return static
     */
    public static function create(string $name, string $pattern, bool $match = true): static
    {
        return new static($name, $pattern, $match);
    }

    /**
     * @param mixed $value
     * @return bool
     */
    public function validate(mixed $value): bool
    {
        $this->value = $value;
        $match = preg_match($this->properties['pattern'], $this->value) === 1;
        return $match === $this->properties['match'];
    }
}
