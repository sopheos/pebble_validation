<?php

namespace Pebble\Validation;

use Imagick;
use Throwable;

class ImagickHelper
{
    public static function getImageSize(string $filename): ?array
    {
        try {
            $image = new Imagick($filename);
            return [$image->getImageWidth(), $image->getImageHeight()];
        } catch (Throwable) {
            return null;
        }
    }
}
