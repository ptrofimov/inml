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
    private $styles;

    /**
     * Constructor
     *
     * @param string $string String to parse
     */
    public function __construct($string)
    {
        $parts = explode(self::CHAR_STYLE, $string);
        $this->word = $parts[0];
        $this->styles = array_slice($parts, 1);
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
}