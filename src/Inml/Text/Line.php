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
     * Delimiter char for define expression
     */
    const CHAR_DEFINE = '#';

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
     * Non-parsed string
     *
     * @var string
     */
    private $rawString;

    /**
     * Constructor
     *
     * @param string $string String to parse
     */
    public function __construct($string)
    {
        $this->rawString = $string;
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
        return $this->getCount();
    }

    /**
     * Returns count of words in line
     *
     * @return int
     */
    public function getCount()
    {
        return count($this->words);
    }

    /**
     * True if there are no words in line
     *
     * @return bool
     */
    public function isEmpty()
    {
        return !$this->getCount();
    }

    /**
     * True if line is define string
     *
     * @return bool
     */
    public function isDefine()
    {
        return $this->getCount() == 2
            && $this->words[0]->isDefine();
    }

    /**
     * Returns define string key
     *
     * @return string|null
     */
    public function getDefineKey()
    {
        return $this->isDefine() ? $this->words[0]->getDefineKey() : null;
    }

    /**
     * Returns \Inml\Text\Word instance for define string
     *
     * @return Word|null
     */
    public function getDefineWord()
    {
        return $this->isDefine() ? $this->words[1] : null;
    }

    /**
     * Returns non-parsed string
     *
     * @return string
     */
    public function getRawString()
    {
        return $this->rawString;
    }
}