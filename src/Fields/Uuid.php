<?php

namespace Pebble\Validation\Fields;

use Pebble\Validation\Rules\Uuid as UuidRule;

class Uuid extends Text
{
    public function __construct(string $name)
    {
        parent::__construct($name);
        $this->addRule(UuidRule::create());
    }
}
