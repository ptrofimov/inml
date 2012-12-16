<?php
/**
 * Class to render inML into HTML
 *
 * @author Petr Trofimov <petrofimov@yandex.ru>
 */
class Inml
{
    const BREAK_PARAGRAPH = "\n\n";
    const BREAK_LINE = "\n";
    const BREAK_WORD = " ";
    const BREAK_STYLE = ".";

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
            $paragraphs = $this->splitText($normalized);
            $html = $this->renderParagraphs($paragraphs);
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
        for ($i = 0, $il = count($paragraphs); $i < $il; $i++) {
            $lines = explode(self::BREAK_LINE, $paragraphs[$i]);
            for ($j = 0, $jl = count($lines); $j < $jl; $j++) {
                $lines[$j] = explode(self::BREAK_WORD, $lines[$j]);
            }
            $paragraphs[$i] = $lines;
        }

        return $paragraphs;
    }

    private function getStyles($string)
    {
        $styles = [];

        if ($string) {
            $parts = explode(self::BREAK_STYLE, $string);
            if (count($parts) > 1 && !strlen($parts[0])) {
                $styles = array_slice($parts, 1);
            }
        }

        return $styles;
    }

    private function isParagraphStyle(array $line)
    {
        return count($line) == 1
            && substr($line[0], 0, 1) == self::BREAK_STYLE;
    }

    private function getStylesAsString($string)
    {
        return implode(' ', $this->getStyles($string));
    }

    /**
     * Renders array of paragraphs into HTML
     *
     * @param array $paragraphs
     * @return string
     */
    private function renderParagraphs($paragraphs)
    {
        $html = '';

        foreach ($paragraphs as $item) {
            if ($this->isParagraphStyle($item[0])) {
                $class = $this->getStylesAsString($item[0][0]);
                $html .= "<p class=\"$class\">";
                array_shift($item);
            } else $html .= '<p>';

            $html .= $this->renderLines($item) . '</p>';
        }

        return $html;
    }

    /**
     * Renders array of lines into HTML
     *
     * @param array $lines
     * @return string
     */
    private function renderLines($lines)
    {
        foreach ($lines as &$item2) {
            $item2 = $this->renderWords($item2);

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

        return implode(' ', $lines);
    }

    /**
     * Renders array of words into array of HTML words
     *
     * @param array $words
     * @return array
     */
    private function renderWords($words)
    {
        foreach ($words as &$item3) {
            $parts = explode('.', $item3);
            if (count($parts) == 2 && strlen($parts[0]) && strlen($parts[1])) {
                $item3 = "<span class=\"{$parts[1]}\">{$parts[0]}</span>";
            }
        }
        unset($item3);

        return $words;
    }
}