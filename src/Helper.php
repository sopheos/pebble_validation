<?php

namespace Pebble\Validation;

class Helper
{
    public static function getImageSize(string $filename): ?array
    {
        if (extension_loaded('imagick')) {
            return ImagickHelper::getImageSize($filename);
        }

        if (!($size = getimagesize($filename))) {
            return null;
        }

        return [$size[0], $size[1]];
    }
}
