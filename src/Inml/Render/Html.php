<?php
namespace Inml\Render;

use \Inml\Text;
use \Inml\Text\Paragraph;
use \Inml\Text\Line;
use \Inml\Text\Word;

class Html implements \Inml\Render
{
    const CHAR_SPACE = ' ';

    public function render(Text $text)
    {
        $out = '';
        foreach ($text as $paragraph) {
            $out .= $this->renderParagraph($paragraph);
        }

        return $out;
    }

    private function getClass($object)
    {
        return implode(self::CHAR_SPACE, $object->getStyles());
    }

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