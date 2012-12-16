<?php
namespace Inml\Render;

use \Inml\Text;
use \Inml\Text\Paragraph;
use \Inml\Text\Line;
use \Inml\Text\Word;

/**
 * Class to render Inml\Text into HTML format
 *
 * @author Petr Trofimov <petrofimov@yandex.ru>
 */
class Html implements \Inml\Render
{
    /**
     * Delimiter between classes, lines and words
     */
    const CHAR_SPACE = ' ';

    /**
     * Renders Inml\Text into HTML format
     *
     * @param \Inml\Text $text Text to render
     * @return string
     */
    public function render(Text $text)
    {
        $out = '';
        foreach ($text as $paragraph) {
            $out .= $this->renderParagraph($paragraph);
        }

        return $out;
    }

    /**
     * Joins array of styles into string
     *
     * @param $object
     * @return string
     */
    private function getClass($object)
    {
        return implode(self::CHAR_SPACE, $object->getStyles());
    }

    /**
     * Renders Paragraph object into HTML format
     *
     * @param \Inml\Text\Paragraph $paragraph
     * @return string
     */
    private function renderParagraph(Paragraph $paragraph)
    {
        if ($paragraph->hasStyles()) {
            $out = "<p class=\"{$this->getClass($paragraph)}\">";
        } else {
            $out = '<p>';
        }
        $lines = [];
        foreach ($paragraph as $line) {
            $lines[] = $this->renderLine($line);
        }
        $out .= implode(self::CHAR_SPACE, $lines);

        return $out . '</p>';
    }

    /**
     * Renders Line object into HTML format
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
        $out = implode(self::CHAR_SPACE, $words);
        if ($line->hasStyles()) {
            $out = "<span class=\"{$this->getClass($line)}\">" .
                $out . '</span>';
        }

        return $out;
    }

    /**
     * Renders Word object into HTML format
     *
     * @param \Inml\Text\Word $word
     * @return string
     */
    private function renderWord(Word $word)
    {
        $out = $word->getWord();
        if ($word->hasStyles()) {
            $out = "<span class=\"{$this->getClass($word)}\">" .
                $out . '</span>';
        }

        return $out;
    }
}