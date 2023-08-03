<?php

namespace Pebble\Validation\Fields;

use Pebble\Validation\Rules\Regex;

class Password extends Text
{
    public function __construct(string $name)
    {
        parent::__construct($name);
        // no special spaces
        $this->addRule(Regex::create('special_space', '/[\xA0\xAD\x{2000}-\x{200F}\x{2028}-\x{202F}\x{205F}-\x{206F}]/u', false));
        // no whitespace
        $this->addRule(Regex::create('whitespace', '/\s/', false));
    }

    /**
     * Sanitize string
     *
     * @param string $input
     * @return string
     */
    public static function sanitize(string $input, bool $multiline = false, bool $striptags = true): string
    {
        // convert into valid utf-8 string
        $input = htmlentities($input, ENT_QUOTES | ENT_SUBSTITUTE, "UTF-8", false);
        // decode entities
        $input = html_entity_decode($input, ENT_QUOTES | ENT_SUBSTITUTE | ENT_HTML5, "UTF-8");
        // remove not printable characters
        $input = preg_replace('/[\x{FFFD}\x00-\x08\x0B\x0C\x0E-\x1F\x7F\x80-\x9F]/u', "", $input);

        return $input;
    }
}
