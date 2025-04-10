<?php

namespace Pebble\Validation;

class Form implements FormInterface
{
    /**
     * @var string
     */
    protected $name = '';

    /**
     * @var FieldInterface[]
     */
    protected $fields = [];

    /**
     * @var bool
     */
    protected $is_valid = true;

    // -------------------------------------------------------------------------

    /**
     * @return string
     */
    public function name(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return \static
     */
    public function setName(string $name): static
    {
        $this->name = $name;
        return $this;
    }

    // -------------------------------------------------------------------------

    /**
     * @param FieldInterface $field
     * @return \static
     */
    public function addField(FieldInterface $field): static
    {
        $this->fields[$field->name()] = $field;
        return $this;
    }

    /**
     * @param string $name
     * @return FieldInterface|null
     */
    public function field(string $name): ?FieldInterface
    {
        return $this->fields[$name] ?? null;
    }

    /**
     * @return FieldInterface[]
     */
    public function fields(): array
    {
        return $this->fields;
    }

    // -------------------------------------------------------------------------

    /**
     * @param array $data
     * @return boolean
     */
    public function validate(array $data): bool
    {
        $this->is_valid = true;

        // Validate each fields
        foreach ($this->fields as $name => $field) {
            if (!$field->validate($data[$name] ?? null) && $this->is_valid) {
                $this->is_valid = false;
            }
        }

        return $this->is_valid;
    }

    // -------------------------------------------------------------------------

    /**
     * @return boolean
     */
    public function isValid(): bool
    {
        return $this->is_valid;
    }

    /**
     * @return array
     */
    public function values(): array
    {
        $values = [];
        foreach ($this->fields as $field) {
            $values[$field->name()] = $field->value();
        }

        return $values;
    }

    /**
     * @return array
     */
    public function inputs(): array
    {
        $inputs = [];
        foreach ($this->fields as $field) {
            if (($input = $field->input())) {
                $inputs[$field->name()] = $input;
            }
        }

        return $inputs;
    }

    /**
     * @return array
     */
    public function errors(): array
    {
        $errors = [];
        foreach ($this->fields as $field) {
            if (($error = $field->error())) {
                $errors[$field->name()] = $error;
            }
        }

        return $errors;
    }

    /**
     * @return array
     */
    public function messages(): array
    {
        $messages = [];
        foreach ($this->fields as $field) {
            if (($message = $field->message())) {
                $messages[$field->name()] = $message;
            }
        }

        return $messages;
    }

    // -------------------------------------------------------------------------

    /**
     * @param string $field
     * @return mixed
     */
    public function input(string $field)
    {
        return $this->field($field)->input();
    }

    /**
     * @param string $field
     * @return mixed
     */
    public function value(string $field)
    {
        return $this->field($field)->value();
    }

    /**
     * @param string $field
     * @return string
     */
    public function error(string $field): string
    {
        return $this->field($field)->error();
    }

    /**
     * @param string $field
     * @return string
     */
    public function message(string $field): string
    {
        return $this->field($field)->message();
    }

    // -------------------------------------------------------------------------
}
