<?php

namespace Pebble\Validation\Fields;

use Pebble\Validation\Rules\IsDir;
use Pebble\Validation\Rules\IsFile;

/**
 * Text
 *
 * @author mathieu
 */
class Text extends Textarea
{
    protected $multiline = false;

    /**
     * @param string $prefix
     * @param string $suffix
     * @return static
     */
    public function isFile(string $prefix = '', string $suffix = ''): static
    {
        return $this->addRule(IsFile::create($prefix, $suffix));
    }

    /**
     * @param string $prefix
     * @param string $suffix
     * @return static
     */
    public function isDir(string $prefix = '', string $suffix = ''): static
    {
        return $this->addRule(IsDir::create($prefix, $suffix));
    }
}
