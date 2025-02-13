<?php

namespace Pebble\Validation\Fields;

use Exception;
use Pebble\Validation\Form;
use Pebble\Validation\Rules as R;
use Pebble\Validation\Rules\Children;

/**
 * Table
 *
 * @author mathieu
 */
class Table extends Field
{
    const TYPE_INTEGER   = 1;
    const TYPE_NUMBER    = 2;
    const TYPE_TEXT      = 3;
    const TYPE_TEXTAREA  = 4;
    const TYPE_TIMESTAMP = 5;

    protected $prepare = 'default';
    private int $type = 0;
    private ?Children $children = null;

    // -------------------------------------------------------------------------

    /**
     * @param mixed $value
     * @return string
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
     * @param Form $form
     * @return static
     */
    public function children(Form $form): static
    {
        if ($this->children === null) {
            $this->children = R\Children::create($form);
            $this->addRule($this->children);
        }

        return $this;
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

    // -------------------------------------------------------------------------
    // Helpers
    // -------------------------------------------------------------------------

    /**
     * @param array $value
     * @return array
     */
    private function parse(array $value): array
    {
        if (!$value || $this->children) {
            return $value;
        }

        switch ($this->type) {
            case self::TYPE_INTEGER:
                return $this->parseInteger($value);
            case self::TYPE_TEXT:
                return $this->parseText($value);
            case self::TYPE_NUMBER:
                return $this->parseNumber($value);
            case self::TYPE_TEXTAREA:
                return $this->parseTextarea($value);
            case self::TYPE_TIMESTAMP:
                return $this->parseTimestamp($value);
            default:
                return $this->parseAuto($value);
        }
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
