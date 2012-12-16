<?php
namespace Inml;

use \Inml\Text\Paragraph;

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
        $parts = explode(self::CHAR_PARAGRAPH, $string);
        foreach ($parts as $item) {
            $paragraph = new Paragraph($item);
            if (count($paragraph)) {
                $this->paragraphs[] = $paragraph;
            }
        }
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