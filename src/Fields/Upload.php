<?php

namespace Pebble\Validation\Fields;

use InvalidArgumentException;
use Pebble\Validation\Fields\Field;
use Pebble\Validation\Rules\FileSize;
use Pebble\Validation\Rules\FileType;
use Pebble\Validation\Rules\ImageMaxSize;
use Pebble\Validation\Rules\ImageMinSize;

class Upload extends Field
{
    protected $prepare = 'default';

    private static $codeErrors = [
        UPLOAD_ERR_INI_SIZE => 'file_size',
        UPLOAD_ERR_FORM_SIZE => 'file_size',
        UPLOAD_ERR_PARTIAL => 'corrupted',
        UPLOAD_ERR_NO_FILE => 'corrupted',
    ];

    private static $acceptedErrors = [
        UPLOAD_ERR_INI_SIZE,
        UPLOAD_ERR_FORM_SIZE,
        UPLOAD_ERR_PARTIAL,
        UPLOAD_ERR_NO_FILE,
    ];

    private static $exceptionMessages = [
        UPLOAD_ERR_OK => 'UPLOAD_ERR_OK',
        UPLOAD_ERR_INI_SIZE => 'UPLOAD_ERR_INI_SIZE',
        UPLOAD_ERR_FORM_SIZE => 'UPLOAD_ERR_FORM_SIZE',
        UPLOAD_ERR_PARTIAL => 'UPLOAD_ERR_PARTIAL',
        UPLOAD_ERR_NO_FILE => 'UPLOAD_ERR_NO_FILE',
        UPLOAD_ERR_NO_TMP_DIR => 'UPLOAD_ERR_NO_TMP_DIR',
        UPLOAD_ERR_CANT_WRITE => 'UPLOAD_ERR_CANT_WRITE',
        UPLOAD_ERR_EXTENSION => 'UPLOAD_ERR_EXTENSION',
    ];

    /**
     * @param mixed $value
     * @return string
     */
    protected function prepare(mixed $value): mixed
    {
        if (!$value) {
            return null;
        }

        if (!is_array($value) || !isset($value['error'])) {
            $this->error = $this->prepare;
            return null;
        }

        $uploadError = $value['error'];

        if ($uploadError === UPLOAD_ERR_OK) {
            if (isset($value['tmp_name']) && is_file($value['tmp_name'])) {
                return $value;
            } else {
                $this->error = $this->prepare;
                return null;
            }
        }

        $this->error = self::$codeErrors[$uploadError] ?? $this->prepare;

        if (!in_array($uploadError, self::$acceptedErrors)) {
            $exceptionMessage = self::$exceptionMessages[$uploadError] ?? $uploadError;
            $message = "Error for {$this->name} : {$exceptionMessage}";
            trigger_error(new InvalidArgumentException($message));
        }

        return null;
    }

    /**
     * @param array $mimes
     * @return static
     */
    public function mimes(array $mimes): static
    {
        return $this->addRule(FileType::create($mimes));
    }

    /**
     * @param int $limit value in byte
     * @return static
     */
    public function size(int $limit): static
    {
        return $this->addRule(FileSize::create($limit));
    }

    /**
     * @param integer $width
     * @param integer $height
     * @param boolean $ignoreOrientation
     * @return static
     */
    public function min(int $width, int $height, bool $ignoreOrientation = true): static
    {
        return $this->addRule(ImageMinSize::create($width, $height, $ignoreOrientation));
    }

    /**
     * @param integer $width
     * @param integer $height
     * @param boolean $ignoreOrientation
     * @return static
     */
    public function max(int $width, int $height, bool $ignoreOrientation = true): static
    {
        return $this->addRule(ImageMaxSize::create($width, $height, $ignoreOrientation));
    }
}
