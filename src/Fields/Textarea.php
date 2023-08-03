<?php

namespace Pebble\Validation\Fields;

use Pebble\Validation\Rules as R;

/**
 * Textarea
 *
 * @author mathieu
 */
class Textarea extends Field
{
    protected $prepare = 'default';
    protected $multiline = true;

    /**
     * @param mixed $value
     * @return string
     */
    protected function prepare(mixed $value): mixed
    {
        if ($value === null) {
            return null;
        }

        if (is_string($value)) {
            $value = static::sanitize($value, $this->multiline);
            return $value === '' ? null : $value;
        }

        if (is_numeric($value)) {
            return (string)$value;
        }

        if (is_bool($value)) {
            return $value ? '1' : '0';
        }

        $this->error = $this->prepare;

        return null;
    }

    // -------------------------------------------------------------------------
    // Rules
    // -------------------------------------------------------------------------

    /**
     * @param string $val
     * @return static
     */
    public function match(string $val): static
    {
        return $this->addRule(R\Exact::create($val));
    }

    /**
     * @param string $val
     * @return static
     */
    public function differ(string $val): static
    {
        return $this->addRule(R\Differ::create($val));
    }

    /**
     * @param int $min
     * @return static
     */
    public function min(int $min): static
    {
        return $this->addRule(R\LenMin::create($min));
    }

    /**
     * @param int $max
     * @return static
     */
    public function max(int $max): static
    {
        return $this->addRule(R\LenMax::create($max));
    }

    /**
     * @param int $val
     * @return static
     */
    public function equal(int $val): static
    {
        return $this->addRule(R\LenEqual::create($val));
    }

    /**
     * @param int $min
     * @param int $max
     * @return static
     */
    public function range(int $min, int $max): static
    {
        return $this->addRule(R\LenRange::create($min, $max));
    }

    /**
     * @param array $items
     */
    public function includes(array $items): static
    {
        return $this->addRule(R\Includes::create($items));
    }

    /**
     * @param array $items
     */
    public function excludes(array $items): static
    {
        return $this->addRule(R\Excludes::create($items));
    }

    /**
     * @param string $name
     * @param string $pattern
     */
    public function regexMatch(string $name, string $pattern): static
    {
        return $this->addRule(R\Regex::create($name, $pattern, true));
    }

    /**
     * @param string $name
     * @param string $pattern
     */
    public function regexDiff(string $name, string $pattern): static
    {
        return $this->addRule(R\Regex::create($name, $pattern, false));
    }

    // -------------------------------------------------------------------------
    // Helpers
    // -------------------------------------------------------------------------

    /**
     * Sanitize string
     *
     * @param string $input
     * @param bool $is_soft
     * @return string
     */
    public static function sanitize(string $input, bool $multiline = false, bool $striptags = true): string
    {
        // convert into valid utf-8 string
        $input = htmlentities($input, ENT_QUOTES | ENT_SUBSTITUTE, "UTF-8", false);
        // decode entities
        $input = html_entity_decode($input, ENT_QUOTES | ENT_SUBSTITUTE | ENT_HTML5, "UTF-8");
        // strip html tags
        if ($striptags) {
            $input = self::stripTags($input);
        }
        // remove not printable characters
        $input = preg_replace('/[\x{FFFD}\x00-\x08\x0B\x0C\x0E-\x1F\x7F\x80-\x9F]/u', "", $input);
        // replace special spaces
        if ($striptags) {
            $input = preg_replace('/[\xA0\xAD\x{2000}-\x{200F}\x{2028}-\x{202F}\x{205F}-\x{206F}]/u', " ", $input);
        }

        if ($multiline) {
            // convert all whitespace except new lines into space
            $input = preg_replace('/[^\S\n]+/', " ", $input);
            // trim each lines
            $input = preg_replace('/ *\n */', "\n", $input);
            // two sets of consecutive lines at maximum
            $input = preg_replace('/\n{3,}/', "\n\n", $input);
        } else {
            // replace all whitespace into space
            $input = preg_replace('/\s/', " ", $input);
        }

        // remove consecutive spaces
        $input = preg_replace('/ +/', " ", $input);

        // trim all
        $input = trim($input);

        return $input;
    }

    public static function stripTags(string $string): string
    {
        $tag = "~" . uniqid() . "~";
        $string = preg_replace("/(<)(\d)/", "$1 {$tag}$2", $string);
        $string = strip_tags($string);
        $string = preg_replace("/(<) {$tag}(\d)/", "$1$2", $string);
        return $string;
    }

    // -------------------------------------------------------------------------
}
