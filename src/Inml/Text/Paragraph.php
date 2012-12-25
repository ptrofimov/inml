<?php
namespace Inml\Text;

/**
 * Class to store array of Line objects
 *
 * @author Petr Trofimov <petrofimov@yandex.ru>
 */
class Paragraph implements \Countable, \IteratorAggregate
{
    /**
     * Separator char for paragraphs
     */
    const SEPARATOR = "\n\n";

    /**
     * Array of Line objects
     *
     * @var Line[]
     */
    private $lines = [];

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
     * Array of defines
     *
     * @var array
     */
    private $defines = [];

    /**
     * Constructor
     *
     * @param string $string String to parse
     */
    public function __construct($string)
    {
        $this->rawString = $string;
        $parts = explode(Line::SEPARATOR, $string);
        foreach ($parts as $item) {
            $line = new Line($item);
            if ($line->isStyle()) {
                $this->styles = array_merge(
                    $this->styles, $line->getStyles());
            } elseif ($line->isDefine()) {
                $this->defines[$line->getDefineKey()] = $line->getDefineWord();
            } elseif (!$line->isEmpty()) {
                $this->lines[] = $line;
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
        return new \ArrayObject($this->lines);
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
     * Returns non-parsed string
     *
     * @return string
     */
    public function getRawString()
    {
        return $this->rawString;
    }

    /**
     * Returns count of lines in paragraph
     *
     * @return int
     */
    public function getCount()
    {
        return count($this->lines);
    }

    /**
     * True if there are no lines in paragraph
     *
     * @return bool
     */
    public function isEmpty()
    {
        return !$this->getCount();
    }

    /**
     * Returns array of defines
     *
     * @return array
     */
    public function getDefines()
    {
        return $this->defines;
    }
}