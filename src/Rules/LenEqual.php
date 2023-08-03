<?php

namespace Pebble\Validation\Rules;

class LenEqual extends Rule
{
    /**
     * @param int $len
     */
    public function __construct(int $len)
    {
        $this->name = 'len_len';
        $this->properties['len'] = $len;
    }

    /**
     * @param int $len
     * @return static
     */
    public static function create(int $len): static
    {
        return new static($len);
    }

    /**
     * @param mixed $value
     * @return bool
     */
    public function validate(mixed $value): bool
    {
        $this->value = $value;
        return mb_strlen($this->value) === $this->properties['len'];
    }
}
