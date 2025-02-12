<?php

namespace Pebble\Validation\Rules;

class FakeRule extends Rule
{
    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public static function create(string $name): static
    {
        return new static($name);
    }
}
