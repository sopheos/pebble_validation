<?php

namespace Pebble\Validation;

interface FieldInterface
{
    /**
     * @param string $name
     * @return static
     */
    public static function create(string $name): static;

    /**
     * @param mixed $value
     * @return static
     */
    public function defaultValue($value): static;

    /**
     * @return static
     */
    public function required(): static;

    /**
     * @return string|null
     */
    public function getRequired();

    /**
     * @param RuleInterface $field
     * @return static
     */
    public function addRule(RuleInterface $rule): static;

    /**
     * @return RuleInterface[]
     */
    public function rules();

    /**
     * @param FormInterface $field
     * @return static
     */
    public function addTo(FormInterface $form): static;

    /**
     * @param mixed $value
     * @return boolean
     */
    public function validate(mixed $value): bool;

    /**
     * @param mixed $value
     * @return static
     */
    public function setValue($value): static;

    /**
     * @param string $error
     * @return static
     */
    public function setError(string $error): static;

    /**
     * @param string $rule
     * @param string|null $message
     * @return static
     */
    public function setMessage(string $rule, ?string $message = null): static;

    /**
     * @param string $message
     * @return static
     */
    public function setDefaultMessage(string $message): static;

    /**
     * @return string
     */
    public function name(): string;

    /**
     * @return mixed
     */
    public function input();

    /**
     * @return mixed
     */
    public function value();

    /**
     * @return string
     */
    public function error(): string;

    /**
     * @return string
     */
    public function message(): string;

    /**
     * @return boolean
     */
    public function isValid(): bool;
}
