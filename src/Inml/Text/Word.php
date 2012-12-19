<?php
namespace Inml\Text;

/**
 * Class to parse string and extract word and styles from it
 *
 * @author Petr Trofimov <petrofimov@yandex.ru>
 */
class Word
{
    /**
     * Delimiter char for styles
     */
    const CHAR_STYLE = '.';

    /**
     * Delimiter char for define expression
     */
    const CHAR_DEFINE = '#';

    /**
     * Word
     *
     * @var string
     */
    private $word;

    /**
     * Array of styles
     *
     * @var string[]
     */
    private $styles = [];

    /**
     * Constructor
     *
     * @param string $string String to parse
     */
    public function __construct($string)
    {
        if (
            strpos($string, '@') !== false
            || strpos($string, '\\') !== false
            || strpos($string, '/') !== false
        ) {
            $this->word = $string;
            return;
        }
        $parts = explode(self::CHAR_STYLE, $string);
        $word = $parts[0];
        $styles = array_slice($parts, 1);
        foreach ($styles as $style) {
            if (!preg_match('/^[a-zA-Z][a-zA-Z0-9]*$/', $style)) {
                $word .= self::CHAR_STYLE . $style;
                array_shift($styles);
            }
        }
        $this->word = $word;
        $this->styles = $styles;
    }

    /**
     * Returns word
     *
     * @return string
     */
    public function getWord()
    {
        return $this->word;
    }

    /**
     * Returns array of styles
     *
     * @return string[]
     */
    public function getStyles()
    {
        return $this->styles;
    }

    /**
     * True if word is not empty
     *
     * @return bool
     */
    public function hasWord()
    {
        return (bool) strlen($this->word);
    }

    /**
     * True if array of styles is not empty
     *
     * @return bool
     */
    public function hasStyles()
    {
        return (bool) count($this->styles);
    }

    /**
     * True if there are styles and no word
     *
     * @return bool
     */
    public function isStyle()
    {
        return !$this->hasWord() && $this->hasStyles();
    }

    /**
     * True if word is not empty and starts with # char
     *
     * @return bool
     */
    public function isDefine()
    {
        return strlen($this->word) >= 2
            && substr($this->word, 0, 1) == self::CHAR_DEFINE;
    }

    /**
     * Returns key of define word
     *
     * @return null|string
     */
    public function getDefineKey()
    {
        $key = null;
        if ($this->isDefine()) {
            $key = substr($this->word, 1);
        }

        return $key;
    }

    /**
     * True if word is valid URL
     *
     * @return bool
     */
    public function isUrl()
    {
        return (bool) filter_var($word = $this->word, FILTER_VALIDATE_URL);
    }

    /**
     * True if word is valid e-mail
     *
     * @return bool
     */
    public function isEmail()
    {
        $word = $this->word;
        var_dump($word);
        return (bool) filter_var($word, FILTER_VALIDATE_EMAIL);
    }
}