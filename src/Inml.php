<?php
class Inml
{
    public function render($text)
    {
        $text = $this->normalize($text);

        return $text;
    }

    private function normalize($text)
    {
        $text = preg_replace('/[ \t]+/', ' ', $text);
        $text = str_replace("\r\n", "\n", $text);
        $text = str_replace("\r", "\n", $text);
        $text = preg_replace('/[\n]{2,}/', "\n\n", $text);

        return $text;
    }
}