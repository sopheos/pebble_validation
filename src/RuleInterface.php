<?php

namespace Pebble\Validation;

interface RuleInterface
{
    /**
     * @param FieldInterface $field
     * @return \static
     */
    public function addTo(FieldInterface $field);

    /**
     * @param mixed $value
     * @return bool
     */
    public function validate(mixed $value): bool;

    /**
     * @return string
     */
    public function name(): string;

    /**
     * @return mixed
     */
    public function value(): mixed;

    /**
     * @return array
     */
    public function properties(): array;

    /**
     * @return mixed
     */
    public function property(string $name): mixed;
}
