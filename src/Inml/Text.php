<?php
namespace Inml;

use \Inml\Text\Paragraph;
use \Inml\Text\Line;
use \Inml\Text\Word;

/**
 * Class to store array of Paragraph objects
 *
 * @author Petr Trofimov <petrofimov@yandex.ru>
 */
class Text implements \Countable, \IteratorAggregate
{
    /**
     * Array of Paragraph objects
     *
     * @var Paragraph[]
     */
    private $paragraphs = [];


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
     *  - normalizes string
     *  - splits one string into many Paragraphs objects
     *
     * @param string $string String to parse
     */
    public function __construct($string)
    {
        $this->rawString = $string;
        $parts = explode(Paragraph::SEPARATOR, $this->normalize($string));
        foreach ($parts as $part) {
            $paragraph = new Paragraph($part);
            $this->defines = array_merge($this->defines,
                $paragraph->getDefines());
            if (!$paragraph->isEmpty()) {
                $this->paragraphs[] = $paragraph;
            }
        }
    }

    /**
     * Transforms text in order to normalize
     *
     *  - trims text
     *  - removes double spaces
     *  - normalizes line break symbols
     *
     * @param string $text
     * @return string
     */
    public function normalize($text)
    {
        $text = preg_replace('/[ \t]+/', ' ', trim($text));
        $text = str_replace("\r\n", Line::SEPARATOR, $text);
        $text = str_replace("\r", Line::SEPARATOR, $text);
        $text = preg_replace('/[\n]{2,}/', Paragraph::SEPARATOR, $text);
        $text = preg_replace('/ ?\n ?/', Line::SEPARATOR, $text);

        return $text;
    }

    /**
     * Implementation of \IteratorAggregate interface
     *
     * @return \ArrayObject
     */
    public function getIterator()
    {
        return new \ArrayObject($this->paragraphs);
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
     * Returns count of paragraphs in text
     *
     * @return int
     */
    public function getCount()
    {
        return count($this->paragraphs);
    }

    /**
     * True if there are no paragraphs in text
     *
     * @return bool
     */
    public function isEmpty()
    {
        return !$this->getCount();
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
     * Returns array of defines
     *
     * @return array
     */
    public function getDefines()
    {
        return $this->defines;
    }
}