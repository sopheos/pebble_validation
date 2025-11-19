<?php

namespace Pebble\Validation\Fields;

use Exception;
use Pebble\Validation\Form;
use Pebble\Validation\Rules as R;
use Pebble\Validation\Rules\CallableRule;
use Pebble\Validation\Rules\Children;

/**
 * Table
 *
 * @author mathieu
 */
class Table extends Field
{
    const TYPE_NONE      = 0;
    const TYPE_INTEGER   = 1;
    const TYPE_NUMBER    = 2;
    const TYPE_TEXT      = 3;
    const TYPE_TEXTAREA  = 4;
    const TYPE_TIMESTAMP = 5;
    const TYPE_AUTO      = 6;

    protected $prepare = 'default';
    private int $type = self::TYPE_AUTO;

    private ?Form $form = null;
    private ?Children $children = null;

    // -------------------------------------------------------------------------

    /**
     * @param mixed $value
     * @return array
     */
    protected function prepare(mixed $value): mixed
    {
        if ($value === null || $value === '') {
            return [];
        }

        if (is_string($value)) {
            $value = json_decode($value, true);
        }

        if (is_array($value)) {
            return $this->parse($value);
        }

        $this->error = $this->prepare;

        return [];
    }

    // -------------------------------------------------------------------------
    // Config
    // -------------------------------------------------------------------------

    /**
     * @return static
     */
    public function none(): static
    {
        $this->type = self::TYPE_NONE;
        return $this;
    }

    /**
     * @return static
     */
    public function number(): static
    {
        $this->type = self::TYPE_NUMBER;
        return $this;
    }

    /**
     * @return static
     */
    public function integer(): static
    {
        $this->type = self::TYPE_INTEGER;
        return $this;
    }

    /**
     * @return static
     */
    public function text(): static
    {
        $this->type = self::TYPE_TEXT;
        return $this;
    }

    /**
     * @return static
     */
    public function textarea(): static
    {
        $this->type = self::TYPE_TEXTAREA;
        return $this;
    }

    /**
     * @return static
     */
    public function timestamp(): static
    {
        $this->type = self::TYPE_TIMESTAMP;
        return $this;
    }

    // -------------------------------------------------------------------------
    // Rules
    // -------------------------------------------------------------------------

    /**
     * @param int $min
     * @return static
     */
    public function min(int $min): static
    {
        return $this->addRule(R\ArrayMin::create($min));
    }

    /**
     * @param int $max
     * @return static
     */
    public function max(int $max): static
    {
        return $this->addRule(R\ArrayMax::create($max));
    }

    /**
     * @param int $min
     * @param int $max
     * @return static
     */
    public function range(int $min, int $max): static
    {
        return $this->addRule(R\ArrayRange::create($min, $max));
    }

    /**
     * @param R\Rule $rule
     * @return static
     */
    public function map(R\Rule $rule): static
    {
        return $this->addRule(R\ArrayMap::create($rule));
    }

    /**
     * @param array $items
     */
    public function includes(array $items): static
    {
        return $this->map(R\Includes::create($items));
    }

    /**
     * @param array $items
     */
    public function excludes(array $items): static
    {
        return $this->map(R\Excludes::create($items));
    }

    /**
     * @param Form $form
     * @return static
     */
    public function children(Form $form): static
    {
        if ($this->form === null) {
            $this->form = $form;
            $this->children = R\Children::create($form);
            $this->addRule($this->children);
        }

        return $this->none();
    }

    public function child(Form $form): static
    {
        if ($this->form === null) {
            $this->form = $form;
            $this->addRule(R\Child::create($form));
        }

        return $this->none();
    }

    /**
     * @return array
     */
    public function childrenErrors(): array
    {
        if ($this->children === null) {
            return [];
        }

        return $this->children->errors();
    }

    /**
     * @return array
     */
    public function childrenMessages(): array
    {
        if ($this->children === null) {
            return [];
        }

        return $this->children->messages();
    }

    /**
     * @param string $name
     * @return static
     */
    public function customMap(string $name, callable $callable, ...$params): static
    {
        return $this->map(CallableRule::create($name, $callable, ...$params));
    }

    // -------------------------------------------------------------------------
    // Helpers
    // -------------------------------------------------------------------------

    /**
     * @param array $value
     * @return array
     */
    private function parse(array $value): array
    {
        if (!$value) {
            return $value;
        }

        return match ($this->type) {
            self::TYPE_NONE      => $value,
            self::TYPE_INTEGER   => $this->parseInteger($value),
            self::TYPE_TEXT      => $this->parseText($value),
            self::TYPE_NUMBER    => $this->parseNumber($value),
            self::TYPE_TEXTAREA  => $this->parseTextarea($value),
            self::TYPE_TIMESTAMP => $this->parseTimestamp($value),
            default              => $this->parseAuto($value)
        };
    }

    /**
     * @param array $input
     * @return array
     */
    private function parseInteger(array $input): array
    {
        $output = [];

        foreach ($input as $key => $value) {
            if ($value === null) {
                continue;
            } elseif (is_numeric($value)) {
                $output[$key] = (int) $value;
            } elseif (is_array($value)) {
                $output[$key] = $this->parseInteger($value);
            } else {
                $this->error = $this->prepare;
            }
        }

        return $output;
    }

    /**
     * @param array $input
     * @return array
     */
    private function parseTimestamp(array $input): array
    {
        $output = [];

        foreach ($input as $key => $value) {
            if (is_array($value)) {
                $output[$key] = $this->parseTimestamp($value);
            } else {
                try {
                    if (($value = Timestamp::sanitize($value))) {
                        $output[$key] = $value;
                    }
                } catch (Exception) {
                    $this->error = $this->prepare;
                }
            }
        }

        return $output;
    }

    /**
     * @param array $input
     * @return array
     */
    private function parseNumber($input)
    {
        $output = [];

        foreach ($input as $key => $value) {
            if ($value === null) {
                continue;
            } elseif (is_numeric($value)) {
                $output[$key] = (float) $value;
            } elseif (is_array($value)) {
                $output[$key] = $this->parseNumber($value);
            } else {
                $this->error = $this->prepare;
            }
        }

        return $output;
    }

    /**
     * @param array $input
     * @return array
     */
    private function parseText(array $input): array
    {
        $output = [];

        foreach ($input as $key => $value) {
            if ($value === null) {
                continue;
            } elseif (is_string($value)) {
                if (($value = Textarea::sanitize($value, false))) {
                    $output[$key] = $value;
                }
            } elseif (is_numeric($value)) {
                $output[$key] = (string) $value;
            } elseif (is_bool($value)) {
                $output[$key] = $value ? '1' : '0';
            } elseif (is_array($value)) {
                $output[$key] = $this->parseText($value);
            } else {
                $this->error = $this->prepare;
            }
        }

        return $output;
    }

    /**
     * @param array $input
     * @return array
     */
    private function parseTextarea(array $input): array
    {
        $output = [];

        foreach ($input as $key => $value) {
            if ($value === null) {
                continue;
            } elseif (is_numeric($value)) {
                $output[$key] = (string) $value;
            } elseif (is_string($value)) {
                if (($value = Textarea::sanitize($value, true))) {
                    $output[$key] = $value;
                }
            } elseif (is_bool($value)) {
                $output[$key] = $value ? '1' : '0';
            } elseif (is_array($value)) {
                $output[$key] = $this->parseTextarea($value);
            } else {
                $this->error = $this->prepare;
            }
        }

        return $output;
    }

    private function parseAuto(array $input): array
    {
        $output = [];

        foreach ($input as $key => $value) {
            if ($value === null) {
                continue;
            } elseif (is_numeric($value)) {
                $output[$key] = is_string($value) ? (float) $value : $value;
            } elseif (is_string($value)) {
                if (($value = Textarea::sanitize($value, true))) {
                    $output[$key] = $value;
                }
            } elseif (is_bool($value)) {
                $output[$key] = $value;
            } elseif (is_array($value)) {
                $output[$key] = $this->parseAuto($value);
            } else {
                $this->error = $this->prepare;
            }
        }

        return $output;
    }

    // -------------------------------------------------------------------------
}
