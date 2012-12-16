<?php
/**
 * Example script to demonstrate the usage
 *
 * @author Petr Trofimov <petrofimov@yandex.ru>
 */
require_once(dirname(__DIR__) . '/vendor/autoload.php');

use \Inml\Text;
use \Inml\Render\Html;

$inml = file_get_contents(__DIR__ . '/example.inml');
$styles = file_get_contents(__DIR__ . '/styles.css');

$html = (new Html)->render(new Text($inml));

file_put_contents(__DIR__ . '/example.html',
    '<style>' . $styles . '</style>' . PHP_EOL . $html);