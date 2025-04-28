<?php

namespace Pebble\Validation\Rules;

use Pebble\Validation\Form;

class Children extends Rule
{
    private array $errors = [];
    private array $messages = [];

    /**
     * @param Form $form
     */
    public function __construct(Form $form)
    {
        $this->name = 'children';
        $this->properties['form'] = $form;
    }

    /**
     * @param Form $form
     * @return static
     */
    public static function create(Form $form): static
    {
        return new static($form);
    }

    /**
     * @param mixed $value
     * @return bool
     */
    public function validate(mixed $value): bool
    {
        $this->errors = [];
        $this->messages = [];
        $this->value  = [];

        if (!is_array($value)) {
            return false;
        }

        $this->value = $value;

        $isValid = true;

        foreach ($this->value as $i => $item) {

            if (is_string($item)) {
                $item = json_decode($item, true);
                $this->value[$i] = $item;
            }

            if (!is_array($item)) {
                $isValid = false;
                continue;
            }

            /**
             * @var Form $form
             */
            $form = clone $this->properties['form'];
            if ($form->validate($item)) {
                $this->value[$i] = $form->values();
            } else {
                $isValid = false;
                $this->errors[$i] = $form->errors();
                $this->messages[$i] = $form->messages();
            }
        }

        return $isValid;
    }

    public function errors(): array
    {
        return $this->errors;
    }

    public function messages(): array
    {
        return $this->messages;
    }
}
