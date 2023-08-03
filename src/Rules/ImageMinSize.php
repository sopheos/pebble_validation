<?php

namespace Pebble\Validation\Rules;

class ImageMinSize extends Rule
{
    /**
     * @param integer $width
     * @param integer $height
     * @param boolean $ignoreOrientation
     */
    public function __construct(int $width, int $height, bool $ignoreOrientation = true)
    {
        $this->name = 'image_min_size';
        $this->properties['width'] = $width;
        $this->properties['height'] = $height;
        $this->properties['ignoreOrientation'] = $ignoreOrientation;
    }

    /**
     * @param integer $width
     * @param integer $height
     * @param boolean $ignoreOrientation
     * @return static
     */
    public static function create(int $width, int $height, bool $ignoreOrientation = true): static
    {
        return new static($width, $height, $ignoreOrientation);
    }

    /**
     * @param mixed $value
     * @return bool
     */
    public function validate(mixed $value): bool
    {
        $this->value = $value;

        if (!($size = getimagesize($value['tmp_name']))) {
            return false;
        }

        $size = [$size[0], $size[1]];
        $limit = [$this->properties['width'], $this->properties['height']];

        if ($this->properties['ignoreOrientation']) {
            sort($size);
            sort($limit);
        }

        return $size[0] >= $limit[0] && $size[1] >= $limit[1];
    }
}
