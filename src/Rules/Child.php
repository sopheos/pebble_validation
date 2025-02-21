<?php

namespace Pebble\Validation\Rules;

use Pebble\Validation\Form;

class Child extends Rule
{
    private Form $form;

    /**
     * @param Form $form
     */
    public function __construct(Form $form)
    {
        $this->name = 'child';
        $this->properties['form'] = $form;
        $this->form = $form;
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
        $this->value  = [];

        if (!is_array($value)) {
            return false;
        }

        $this->value = $value;
        if ($this->form->validate($value)) {
            $this->value = $this->form->values();
            return true;
        }
        return false;
    }
}
