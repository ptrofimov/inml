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
     * Delimiter char for paragraphs
     */
    const CHAR_PARAGRAPH = "\n\n";

    /**
     * Array of Paragraph objects
     *
     * @var Paragraph[]
     */
    private $paragraphs = [];

    /**
     * Constructor
     *
     * @param string $string String to parse
     */
    public function __construct($string)
    {
        $parts = explode(self::CHAR_PARAGRAPH,
            $this->normalize($string));
        foreach ($parts as $item) {
            $paragraph = new Paragraph($item);
            if (count($paragraph)) {
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
        $text = str_replace("\r\n", Paragraph::CHAR_LINE, $text);
        $text = str_replace("\r", Paragraph::CHAR_LINE, $text);
        $text = preg_replace('/[\n]{2,}/', self::CHAR_PARAGRAPH, $text);
        $text = preg_replace('/ ?\n ?/', Paragraph::CHAR_LINE, $text);

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
        return count($this->paragraphs);
    }
}