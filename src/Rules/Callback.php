<?php

namespace Pebble\Validation\Rules;

class Callback extends Rule
{
    /**
     * @param string $name
     * @param callable $callable
     * @param mixed ...$params
     */
    public function __construct(string $name, $callable, ...$params)
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
        $this->value = $value;

        if (!is_callable($this->properties['callable'])) {
            return false;
        }

        $res = call_user_func($this->properties['callable'], $this->value, ...$this->properties['params']);

        if ($res === null) {
            return false;
        }

        $this->value = $res;

        return true;
    }
}
