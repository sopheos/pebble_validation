<?php

namespace Pebble\Validation\Rules;

class FileSize extends Rule
{
    /**
     * @param integer $limit value in byte
     */
    public function __construct(int $limit)
    {
        $this->name = 'file_size';
        $this->properties['limit'] = $limit;
    }

    /**
     * @param integer $limit value in byte
     * @return static
     */
    public static function create(int $limit): static
    {
        return new static($limit);
    }

    /**
     * @param mixed $value
     * @return bool
     */
    public function validate(mixed $value): bool
    {
        $this->value = $value;

        if (!($size = filesize($value['tmp_name']))) {
            return false;
        }

        return $size <= $this->properties['limit'];
    }
}
