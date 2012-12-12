<?php
require_once(dirname(__DIR__) . '/src/Inml.php');

class InmlTest extends PHPUnit_Framework_TestCase
{
    /** @var Inml */
    private $me;

    public function setUp()
    {
        $this->me = new Inml();
    }

    public function testInstance()
    {
        $this->assertInstanceOf('Inml', $this->me);
    }

    public function dataProviderTestNormalize()
    {
        return [
            ['', ''],
            [' ', ''],
            ['a b', 'a b'],
            ['a  b', 'a b'],
            ["a\tb", 'a b'],
            ["a\t\tb", 'a b'],
            ["a \t b", 'a b'],
            ["a\nb", "a\nb"],
            ["a\n\nb", "a\n\nb"],
            ["a\rb", "a\nb"],
            ["a\r\rb", "a\n\nb"],
            ["a\r\nb", "a\nb"],
            ["a\r\n\r\nb", "a\n\nb"],
            ["a\n b", "a\nb"],
            ["a \nb", "a\nb"],
            [" a ", "a"],
        ];
    }

    /**
     * @dataProvider dataProviderTestNormalize
     */
    public function testNormalize($inml, $html)
    {
        $this->assertSame($html, $this->me->render($inml));
    }

    public function dataProviderParagraphs()
    {
        return [
            ["line", 'line'],
        ];
    }

    /**
     * @dataProvider dataProviderParagraphs
     */
    public function testParagraphs($inml, $html)
    {
        $this->assertSame($html, $this->me->render($inml));
    }
}