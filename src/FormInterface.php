<?php

namespace Pebble\Validation;

interface FormInterface
{
    /**
     * @return string
     */
    public function name(): string;

    /**
     * @param string $name
     * @return static
     */
    public function setName(string $name): static;

    /**
     * @param FieldInterface $field
     * @return static
     */
    public function addField(FieldInterface $field): static;

    /**
     * @param string $name
     * @return FieldInterface|null
     */
    public function field(string $name): ?FieldInterface;

    /**
     * @return FieldInterface[]
     */
    public function fields(): array;

    /**
     * @param array $data
     * @return boolean
     */
    public function validate(array $data): bool;

    /**
     * @return boolean
     */
    public function isValid(): bool;

    /**
     * @return array
     */
    public function values(): array;

    /**
     * @return array
     */
    public function errors(): array;

    /**
     * @return array
     */
    public function messages(): array;

    /**
     * @param string $field
     * @return mixed
     */
    public function input(string $field);

    /**
     * @param string $field
     * @return mixed
     */
    public function value(string $field);

    /**
     * @param string $field
     * @return mixed
     */
    public function error(string $field);

    /**
     * @param string $field
     * @return mixed
     */
    public function message(string $field);
}
