<?php
namespace Inml\Text;

/**
 * Class to store array of Word objects
 *
 * @author Petr Trofimov <petrofimov@yandex.ru>
 */
class Line implements \Countable, \IteratorAggregate
{
    /**
     * Delimiter char for words
     */
    const CHAR_WORD = ' ';

    /**
     * Array of Word objects
     *
     * @var Word[]
     */
    private $words = [];

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
        $parts = explode(self::CHAR_WORD, $string);
        foreach ($parts as $item) {
            $word = new Word($item);
            if ($word->isStyle()) {
                $this->styles = array_merge(
                    $this->styles, $word->getStyles());
            } elseif ($word->hasWord()) {
                $this->words[] = $word;
            }
        }
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
     * True is line consists no words and has styles
     *
     * @return bool
     */
    public function isStyle()
    {
        return !count($this->words) && !empty($this->styles);
    }

    /**
     * True if there are styles
     *
     * @return bool
     */
    public function hasStyles()
    {
        return !empty($this->styles);
    }

    /**
     * Implementation of \IteratorAggregate interface
     *
     * @return \ArrayObject
     */
    public function getIterator()
    {
        return new \ArrayObject($this->words);
    }

    /**
     * Implementation of \Countable interface
     *
     * @return int
     */
    public function count()
    {
        return count($this->words);
    }
}