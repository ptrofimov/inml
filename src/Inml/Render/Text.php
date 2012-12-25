<?php
namespace Inml\Render;

use \Inml\Text\Paragraph;
use \Inml\Text\Line;
use \Inml\Text\Word;

/**
 * Class to render Inml\Text into Text format
 *
 * @author Petr Trofimov <petrofimov@yandex.ru>
 */
class Text implements \Inml\Render
{
    /**
     * Delimiter between words
     */
    const CHAR_SPACE = ' ';

    /**
     * Delimiter between lines
     */
    const CHAR_LINEBREAK = "\n";

    /**
     * Delimiter between paragraphs
     */
    const CHAR_PARAGRAPH = "\n\n";

    /**
     * Renders Inml\Text into Text format
     *
     * @param \Inml\Text $text Text to render
     * @return string
     */
    public function render(\Inml\Text $text)
    {
        $paragraphs = [];
        foreach ($text as $paragraph) {
            $paragraphs[] = $this->renderParagraph($paragraph);
        }

        return implode(self::CHAR_PARAGRAPH, $paragraphs);
    }

    /**
     * Renders Paragraph object into Text format
     *
     * @param \Inml\Text\Paragraph $paragraph
     * @return string
     */
    private function renderParagraph(Paragraph $paragraph)
    {
        $lines = [];
        foreach ($paragraph as $line) {
            $lines[] = $this->renderLine($line);
        }

        return implode(self::CHAR_LINEBREAK, $lines);
    }

    /**
     * Renders Line object into Text format
     *
     * @param \Inml\Text\Line $line
     * @return string
     */
    private function renderLine(Line $line)
    {
        $words = [];
        foreach ($line as $word) {
            $words[] = $this->renderWord($word);
        }

        return implode(self::CHAR_SPACE, $words);
    }

    /**
     * Renders Word object into Text format
     *
     * @param \Inml\Text\Word $word
     * @return string
     */
    private function renderWord(Word $word)
    {
        return $word->getWord();
    }
}