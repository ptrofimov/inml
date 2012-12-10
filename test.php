<?php

class Processor
{
	private $in, $out;

	public function process($text)
	{
		//$lines = explode(PHP_EOL, $text);
		//$new = array_replace($lines, array(''), array('</p><p>'));
		//$out = implode(PHP_EOL, $new);
		$out = preg_replace('/('.PHP_EOL.')+/', '</p><p>', $text);
		$out = preg_replace('/(\S+)\.(\w+)/', '<span class="$2">$1</span>', $out);
		$out = preg_replace('/<p>.*\.(\w+)<\/p>/', '<div class="$2">$1</div>', $out);

		return '<p>'.$out.'</p>';
	}
}

$text = <<<TEXT
some word.b in sentence .l
welcome
welcome

text
TEXT;

echo (new Processor)->process($text);

// several .bold words.b in sentence
