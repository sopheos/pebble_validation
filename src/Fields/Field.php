<?php

namespace Pebble\Validation\Fields;

use Pebble\Validation\FieldInterface;
use Pebble\Validation\FormInterface;
use Pebble\Validation\RuleInterface;
use Pebble\Validation\Rules\CallableRule;
use Pebble\Validation\Rules\FakeRule;

class Field implements FieldInterface
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var mixed
     */
    protected $input;

    /**
     * @var mixed
     */
    protected $value;

    /**
     * @var mixed
     */
    protected $default;

    /**
     * @var string
     */
    protected $prepare = '';

    /**
     * @var string
     */
    protected $required = '';

    /**
     * @var RuleInterface[]
     */
    protected $rules = [];

    /**
     * @var string
     */
    protected $error = '';

    /**
     * @var array
     */
    protected $messages = [];

    /**
     * @var string
     */
    protected $default_message = 'default';

    // -------------------------------------------------------------------------

    /**
     * @param string $name
     */
    public function __construct(string $name)
    {
        $this->name = $name;
    }

    /**
     * @param string $name
     * @return static
     */
    public static function create(string $name): static
    {
        return new static($name);
    }

    // -------------------------------------------------------------------------

    /**
     * @param mixed $value
     * @return static
     */
    public function defaultValue($value): static
    {
        $this->default = $value;
        return $this;
    }

    /**
     * @return static
     */
    public function required(): static
    {
        $this->required = 'required';
        return $this;
    }

    /**
     * @return string|null
     */
    public function getRequired()
    {
        return $this->required;
    }

    /**
     * @param RuleInterface $field
     * @return static
     */
    public function addRule(RuleInterface $rule): static
    {
        $this->rules[] = $rule;
        return $this;
    }

    /**
     * @param string $name
     * @return static
     */
    public function fakeRule(string $name): static
    {
        return $this->addRule(FakeRule::create($name));
    }

    /**
     * @param string $name
     * @return static
     */
    public function custom(string $name, callable $callable, ...$params): static
    {
        return $this->addRule(CallableRule::create($name, $callable, ...$params));
    }

    /**
     * @return RuleInterface[]
     */
    public function rules()
    {
        return $this->rules;
    }

    /**
     * @param FormInterface $field
     * @return static
     */
    public function addTo(FormInterface $form): static
    {
        $form->addField($this);
        return $this;
    }

    /**
     * @param string $rule
     * @param string|null$message
     * @return static
     */
    public function setMessage(string $rule, ?string $message = null): static
    {
        $this->messages[$rule] = $message ?? $rule;

        return $this;
    }

    /**
     * @param string $message
     * @return static
     */
    public function setDefaultMessage(string $message): static
    {
        $this->default_message = $message;
        return $this;
    }

    // -------------------------------------------------------------------------

    /**
     * @param mixed $value
     * @return boolean
     */
    public function validate(mixed $value): bool
    {
        $this->error = '';
        $value = $this->prepare($value);
        $this->input = $value;
        $this->value = $value;

        // Prepare error
        if ($this->error) {
            return false;
        }

        // Empty value
        if ($this->isEmpty($this->value)) {

            if ($this->required) {
                $this->error = $this->required;
                return false;
            }

            if ($this->default !== null) {
                $this->value = $this->default;
            }

            return true;
        }

        // Validate each rule
        foreach ($this->rules as $rule) {

            if ($rule->validate($this->value)) {
                $this->value = $rule->value();
            } else {
                $this->error = $rule->name();
                return false;
            }
        }

        return true;
    }

    /**
     * @param mixed $value
     * @return boolean
     */
    protected function isEmpty($value)
    {
        return $value === null
            || $value === ''
            || (is_array($value) && !$value);
    }

    /**
     * @param mixed $value
     * @return mixed
     */
    protected function prepare(mixed $value): mixed
    {
        return $value;
    }

    // -------------------------------------------------------------------------

    /**
     * @param mixed $value
     * @return static
     */
    public function setValue($value): static
    {
        $this->value = $value;
        return $this;
    }

    /**
     * @param string $error
     * @return static
     */
    public function setError(string $error): static
    {
        $this->error = $error;
        return $this;
    }

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
    public function input()
    {
        return $this->input;
    }

    /**
     * @return mixed
     */
    public function value()
    {
        return $this->value;
    }

    /**
     * @return string
     */
    public function error(): string
    {
        return $this->error;
    }

    /**
     * @return string
     */
    public function message(): string
    {
        if ($this->isValid()) {
            return '';
        }

        return $this->messages[$this->error] ?? $this->default_message;
    }

    /**
     * @return boolean
     */
    public function isValid(): bool
    {
        return !$this->error;
    }

    // -------------------------------------------------------------------------
}
