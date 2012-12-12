<?php
require_once(dirname(__DIR__) . '/classes/Inml.php');

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
    public function testNormalize($in, $out)
    {
        $this->assertSame($out, $this->me->normalize($in));
    }

    public function dataProviderTestParagraphs()
    {
        return [
            ["line", '<p>line</p>'],
            ["line1\nline2", '<p>line1 line2</p>'],
            ["line1\n\nline2", '<p>line1</p><p>line2</p>'],
            [".style1\nline1\n\n.style2\nline2",
                '<p class="style1">line1</p><p class="style2">line2</p>'],
        ];
    }

    /**
     * @dataProvider dataProviderTestParagraphs
     */
    public function testParagraphs($in, $out)
    {
        $this->assertSame($out, $this->me->render($in));
    }

    public function dataProviderTestLines()
    {
        return [
            ["line", '<p>line</p>'],
            [".style line", '<p><span class="style">line</span></p>'],
            ["line .style", '<p><span class="style">line</span></p>'],
        ];
    }

    /**
     * @dataProvider dataProviderTestLines
     */
    public function testLines($in, $out)
    {
        $this->assertSame($out, $this->me->render($in));
    }

    public function dataProviderTestWords()
    {
        return [
            ["word", '<p>word</p>'],
            ["word.style", '<p><span class="style">word</span></p>'],
        ];
    }

    /**
     * @dataProvider dataProviderTestWords
     */
    public function testWords($in, $out)
    {
        $this->assertSame($out, $this->me->render($in));
    }
}