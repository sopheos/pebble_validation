<?php

namespace Pebble\Validation\Rules;

class CharList extends Rule
{
    /**
     * @param string $name
     */
    public function __construct(string $name = 'charlist')
    {
        $this->name = $name;
        $this->properties['emoji'] = false;
        $this->properties['chars'] = '';
    }

    /**
     * @param string $name
     * @return static
     */
    public static function create(string $name = 'charlist'): static
    {
        return new static($name);
    }

    // -------------------------------------------------------------------------

    /**
     * Add chars
     *
     * @param string $chars
     * @return static
     */
    public function add(string $chars)
    {
        $this->properties['chars'] .= $chars;
        return $this;
    }

    /**
     * @return static
     */
    public function numbers()
    {
        return $this->add("0-9");
    }

    /**
     * @return static
     */
    public function letters()
    {
        return $this->add("a-z");
    }

    /**
     * @return static
     */
    public function accents()
    {
        return $this->add("äæǽöœüÄÜÖÀÁÂÃÄÅǺĀĂĄǍàáâãåǻāăąǎªÇĆĈĊČçćĉċčÐĎĐðďđÈÉÊËĒĔĖĘĚèéêëēĕėęěĜĞĠĢĝğġģĤĦĥħÌÍÎÏĨĪĬǏĮİìíîïĩīĭǐįıĴĵĶķĹĻĽĿŁĺļľŀłÑŃŅŇñńņňŉÒÓÔÕŌŎǑŐƠØǾòóôõōŏǒőơøǿºŔŖŘŕŗřŚŜŞŠśŝşšſŢŤŦţťŧÙÚÛŨŪŬŮŰŲƯǓǕǗǙǛùúûũūŭůűųưǔǖǘǚǜÝŸŶýÿŷŴŵŹŻŽźżžÆǼßĲĳŒƒ");
    }

    /**
     * @return static
     */
    public function ponctuations()
    {
        return $this->add("'\",.;^:?!()[\]«»_@&+\-*\\/%|{}°’#=…");
    }

    /**
     * @return static
     */
    public function currencies()
    {
        return $this->add(
            "\u{24}\u{a2}\u{a3}\u{a4}\u{a5}\u{58f}\u{60b}\u{7fe}\u{7ff}"
                . "\u{9f2}\u{9f3}\u{9fb}\u{af1}\u{bf9}\u{e3f}\u{17db}\u{20a0}\u{20a1}"
                . " \u{20a2}\u{20a3}\u{20a4}\u{20a5}\u{20a6}\u{20a7}\u{20a8}\u{20a9}"
                . "\u{20aa}\u{20ab}\u{20ac}\u{20ad}\u{20ae}\u{20af}\u{20b0}\u{20b1}"
                . "\u{20b2}\u{20b3}\u{20b4}\u{20b5}\u{20b6}\u{20b7}\u{20b8}\u{20b9}"
                . "\u{20ba}\u{20bb}\u{20bc}\u{20bd}\u{20be}\u{20bf}\u{a838}\u{fdfc}"
                . "\u{fe69}\u{ff04}\u{ffe0}\u{ffe1}\u{ffe5}\u{ffe6}\u{11fdd}\u{11fde}"
                . "\u{11fdf}\u{11fe0}\u{1e2ff}\u{1ecb0}"
        );
    }

    /**
     * @return static
     */
    public function indices()
    {
        return $this->add(
            "\u{b2}\u{b3}\u{b9}"
                . "\u{2070}\u{2071}\u{2074}-\u{207f}"
                . "\u{2080}-\u{208e}"
                . "\u{2090}-\u{209c}"
        );
    }

    /**
     * @return static
     */
    public function text()
    {
        return $this
            ->letters()
            ->numbers()
            ->accents()
            ->indices()
            ->currencies()
            ->ponctuations();
    }

    /**
     * @return static
     */
    public function emoji()
    {
        $this->properties['emoji'] = true;
        return $this;
    }

    // -------------------------------------------------------------------------

    /**
     * @param string $value
     * @return boolean
     */
    public function validate(mixed $value): bool
    {
        $this->value = $value;
        if (!$this->properties['chars']) return true;

        $pattern = "/^[" . $this->properties['chars'] . "]+$/ui";
        return preg_match($pattern, $this->parsedValue()) === 1;
    }

    /**
     * Prepare the value for the regex test
     */
    private function parsedValue()
    {
        $value = preg_replace('/\s/', '', $this->value);
        if (!$value || !$this->properties['emoji']) return $value;

        $emojis = include __DIR__ . '/../config/emoji.php';

        $map = [];
        foreach ($emojis as $emoji) {
            $map[$emoji] = "";
        }

        return strtr($value, $map);
    }

    // -------------------------------------------------------------------------
}
