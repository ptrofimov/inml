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
     * Delimiter between classes and words
     */
    const CHAR_SPACE = ' ';

    /**
     * Delimiter between lines
     */
    const CHAR_LINEBREAK = "\n";

    /**
     * List of some HTML5 tags
     *
     * @var array
     */
    private $htmlTags;

    public function __construct()
    {
        $this->htmlTags = [
            'h1', 'h2', 'h3', 'h4', 'h5', 'h6',
            'p', 'hr', 'pre', 'blockquote',
            'ol', 'ul', 'li', 'dl', 'dt', 'div',
            'a', 'em', 'strong', 'small',
            'i', 'b', 'u',
        ];
    }

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
     * Wraps content in tags and styles
     *
     * @param string $content
     * @param array $styles
     * @param string $defaultTag
     * @return string
     */
    public function wrapInTags($content, array $styles, $defaultTag = 'span')
    {
        $tags = [];
        $tag = null;
        foreach ($styles as $style) {
            if (in_array($style, $this->htmlTags)) {
                array_push($tags, $tag);
                $tag = ['name' => $style, 'classes' => []];
            } else {
                if (is_null($tag)) {
                    $tag = ['name' => $defaultTag, 'classes' => []];
                }
                $tag['classes'][] = str_replace('"', '', $style);
            }
        }
        if ($defaultTag != 'span' && is_null($tag)) {
            $tag = ['name' => $defaultTag, 'classes' => []];
        }
        array_push($tags, $tag);
        foreach (array_reverse($tags) as $tag) {
            if (is_null($tag)) {
                continue;
            } elseif (!empty($tag['classes'])) {
                $classes = implode(self::CHAR_SPACE,
                    array_unique($tag['classes']));
                $open = "<$tag[name] class=\"$classes\">";
            } else {
                $open = "<$tag[name]>";
            }
            $close = "</$tag[name]>";
            $content = "$open$content$close";
        }

        return $content;
    }

    /**
     * Renders Paragraph object into HTML format
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

        return $this->wrapInTags(
            implode(self::CHAR_LINEBREAK, $lines),
            $paragraph->getStyles(),
            'p'
        );
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

        return $this->wrapInTags(
            implode(self::CHAR_SPACE, $words),
            $line->getStyles()
        );
    }

    /**
     * Renders Word object into HTML format
     *
     * @param \Inml\Text\Word $word
     * @return string
     */
    private function renderWord(Word $word)
    {
        return $this->wrapInTags(
            $word->getWord(),
            $word->getStyles()
        );
    }
}