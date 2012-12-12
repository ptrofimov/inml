<?php
require_once(dirname(__DIR__) . '/classes/Inml.php');

$inml = file_get_contents(__DIR__ . '/example.inml');

$html = (new Inml)->render($inml);

file_put_contents(__DIR__ . '/example.html', $html);