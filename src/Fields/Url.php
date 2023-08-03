<?php

namespace Pebble\Validation\Fields;

use Pebble\Validation\Rules\IsUrl;

class Url extends Text
{
    public function __construct(string $name)
    {
        parent::__construct($name);
        $this->addRule(IsUrl::create(), true);
    }

    /**
     * Sanitize string
     *
     * @param string $input
     * @param bool $is_soft
     * @return string
     */
    public static function sanitize(string $input, bool $multiline = false, bool $striptags = true): string
    {
        return trim(filter_var($input, FILTER_SANITIZE_URL)) ?: '';
    }
}
