<?php

namespace Pebble\Validation\Rules;

use Pebble\Validation\FieldInterface;
use Pebble\Validation\RuleInterface;

class Rule implements RuleInterface
{
    protected string $name = '';
    protected mixed $value = null;
    protected array $properties = [];

    // -------------------------------------------------------------------------

    /**
     * @param FieldInterface $field
     * @return static
     */
    public function addTo(FieldInterface $field): static
    {
        $field->addRule($this);
        return $this;
    }

    // -------------------------------------------------------------------------

    /**
     * @param mixed $value
     * @return bool
     */
    public function validate(mixed $value): bool
    {
        $this->value = $value;
        return true;
    }

    // -------------------------------------------------------------------------

    /**
     * @return string
     */
    public function name(): string
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function value(): mixed
    {
        return $this->value;
    }

    /**
     * @return array
     */
    public function properties(): array
    {
        return $this->properties;
    }

    /**
     * @return mixed
     */
    public function property(string $name): mixed
    {
        return $this->properties[$name] ?? null;
    }

    // -------------------------------------------------------------------------
}
