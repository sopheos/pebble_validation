<?php

namespace Pebble\Validation\Rules;

class ArrayMap extends Rule
{
    private Rule $rule;

    /**
     * @param Rule $rule
     */
    public function __construct(Rule $rule)
    {
        $this->name = $rule->name();
        $this->rule = $rule;
    }

    /**
     * @param Rule $rule
     * @return static
     */
    public static function create(Rule $rule): static
    {
        return new static($rule);
    }

    /**
     * @param mixed $value
     * @return bool
     */
    public function validate(mixed $value): bool
    {
        $this->value = $value;

        $isValid = true;

        foreach ($value as $v) {
            if (!$this->rule->validate($v)) {
                $isValid = false;
            }
            $v = $this->rule->value();
        }

        return $isValid;
    }
}
