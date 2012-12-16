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
     * Delimiter char for lines
     */
    const CHAR_LINE = "\n";

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
     * Constructor
     *
     * @param string $string String to parse
     */
    public function __construct($string)
    {
        $parts = explode(self::CHAR_LINE, $string);
        foreach ($parts as $item) {
            $line = new Line($item);
            if ($line->isStyle()) {
                $this->styles = array_merge(
                    $this->styles, $line->getStyles());
            } elseif (count($line)) {
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
        return count($this->lines);
    }
}