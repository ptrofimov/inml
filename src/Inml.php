<?php
class Inml
{
    public function render($text)
    {
        $text = $this->normalize($text);

        return $this->doRender($text);
    }

    private function normalize($text)
    {
        $text = trim($text);
        $text = preg_replace('/[ \t]+/', ' ', $text);
        $text = str_replace("\r\n", "\n", $text);
        $text = str_replace("\r", "\n", $text);
        $text = preg_replace('/[\n]{2,}/', "\n\n", $text);
        $text = preg_replace('/ \n/', "\n", $text);
        $text = preg_replace('/\n /', "\n", $text);

        return $text;
    }

    private function doRender($text)
    {
        $out = '';

        $paragraphs = explode("\n\n", $text);
        foreach ($paragraphs as &$item) {
            $lines = explode("\n", $item);
            foreach ($lines as &$item2) {
                $item2 = explode(' ', $item2);
            }
            $item = $lines;
        }
        unset($item);


        foreach ($paragraphs as $item) {
            if (count($item[0]) == 1 && $item[0][0][0] == '.') {
                $class = substr($item[0][0], 1);
                $out .= "<p class='$class'>";
                array_shift($item);
            } else $out .= '<p>';

            foreach ($item as &$item2) {
                foreach ($item2 as &$item3) {
                    $parts = explode('.', $item3);
                    if (count($parts) == 2 && strlen($parts[0]) && strlen($parts[1])) {
                        $item3 = "<span class='{$parts[1]}'>{$parts[0]}</span>";
                    }
                }
                unset($item3);

                if ($item2[0][0] == '.') {
                    $class = substr($item2[0], 1);
                    array_shift($item2);
                    $item2 = "<span class='$class'>" . implode(' ', $item2) . '</span>';
                } elseif ($item2[count($item2) - 1][0] == '.') {
                    $class = substr($item2[count($item2) - 1], 1);
                    array_pop($item2);
                    $item2 = "<span class='$class'>" . implode(' ', $item2) . '</span>';
                } else {
                    $item2 = implode(' ', $item2);
                }
            }
            unset($item2);

            $out .= implode(' ', $item);

            $out .= '</p>';

            return $out;
        }
    }
}