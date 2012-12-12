<?php
/**
 * Class to render inML into HTML
 *
 * @author Petr Trofimov <petrofimov@yandex.ru>
 */
class Inml
{
    const BREAK_LINE = "\n";
    const BREAK_PARAGRAPH = "\n\n";

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
        $text = str_replace("\r\n", self::BREAK_LINE, $text);
        $text = str_replace("\r", self::BREAK_LINE, $text);
        $text = preg_replace('/[\n]{2,}/', self::BREAK_PARAGRAPH, $text);
        $text = preg_replace('/ ?\n ?/', self::BREAK_LINE, $text);

        return $text;
    }

    /**
     * Renders inML into HTML
     *
     * @param string $inml
     * @return string
     */
    public function render($inml)
    {
        $html = '';

        $normalized = $this->normalize($inml);
        if (strlen($normalized)) {
            $structure = $this->splitText($normalized);
            $html = $this->renderParagraphs($structure);
        }

        return $html;
    }

    /**
     * Splits text into array of paragraphs, lines and words
     *
     * @param string $text
     * @return array
     */
    private function splitText($text)
    {
        $paragraphs = explode(self::BREAK_PARAGRAPH, $text);
        foreach ($paragraphs as &$paragraph) {
            $lines = explode(self::BREAK_LINE, $paragraph);
            foreach ($lines as &$line) {
                $line = explode(' ', $line);
            }
            unset($line);
            $paragraph = $lines;
        }
        unset($paragraph);

        return $paragraphs;
    }

    private function renderParagraphs($paragraphs)
    {
        $out = '';

        foreach ($paragraphs as $item) {
            if (count($item[0]) == 1 && $item[0][0][0] == '.') {
                $class = substr($item[0][0], 1);
                $out .= "<p class=\"$class\">";
                array_shift($item);
            } else $out .= '<p>';

            foreach ($item as &$item2) {
                foreach ($item2 as &$item3) {
                    $parts = explode('.', $item3);
                    if (count($parts) == 2 && strlen($parts[0]) && strlen($parts[1])) {
                        $item3 = "<span class=\"{$parts[1]}\">{$parts[0]}</span>";
                    }
                }
                unset($item3);

                if ($item2[0][0] == '.') {
                    $class = substr($item2[0], 1);
                    array_shift($item2);
                    $item2 = "<span class=\"$class\">" . implode(' ', $item2) . '</span>';
                } elseif ($item2[count($item2) - 1][0] == '.') {
                    $class = substr($item2[count($item2) - 1], 1);
                    array_pop($item2);
                    $item2 = "<span class=\"$class\">" . implode(' ', $item2) . '</span>';
                } else {
                    $item2 = implode(' ', $item2);
                }
            }
            unset($item2);

            $out .= implode(' ', $item);
            $out .= '</p>';
        }

        return $out;
    }
}