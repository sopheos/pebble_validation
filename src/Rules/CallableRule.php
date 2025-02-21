<?php

namespace Pebble\Validation\Rules;

use Throwable;

class CallableRule extends Rule
{
    /**
     * @param string $name
     * @param callable $callable
     * @param mixed ...$params
     */
    public function __construct(string $name, callable $callable, ...$params)
    {
        $this->name = $name;
        $this->properties['callable'] = $callable;
        $this->properties['params'] = $params;
    }

    /**
     * @param string $name
     * @param callable $callable
     * @param mixed ...$params
     * @return static
     */
    public static function create(string $name, $callable, ...$params): static
    {
        return new static($name, $callable, ...$params);
    }

    /**
     * @param mixed $value
     * @return bool
     */
    public function validate(mixed $value): bool
    {
        try {
            $callback    = $this->properties['callable'];
            $this->value = $callback($value, ...$this->properties['params']);
            return true;
        } catch (Throwable) {
            $this->value = $value;
            return false;
        }

        return true;
    }
}
