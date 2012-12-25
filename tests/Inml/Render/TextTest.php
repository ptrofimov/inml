<?php
namespace Inml\Render;

class TextTest extends \PHPUnit_Framework_TestCase
{
    /** @var Text */
    private $me;

    public function setUp()
    {
        $this->me = new Text();
    }

    public function dataProviderTestParagraphs()
    {
        return [
            ["", ''],
            ["line", 'line'],
            ["line1\nline2", "line1\nline2"],
            ["line1\n\nline2", "line1\n\nline2"],
            [".style1.style2\nline", 'line'],
            [".style1\nline1\n\n.style2\nline2",
                "line1\n\nline2"],
        ];
    }

    /**
     * @dataProvider dataProviderTestParagraphs
     */
    public function testParagraphs($in, $out)
    {
        $this->assertSame($out, $this->me->render(new \Inml\Text($in)));
    }

    public function dataProviderTestLines()
    {
        return [
            ["line", 'line'],
            [".style line", 'line'],
            ["line .style", 'line'],
            [".style1.style2 line", 'line'],
            ["line .style1.style2", 'line'],
        ];
    }

    /**
     * @dataProvider dataProviderTestLines
     */
    public function testLines($in, $out)
    {
        $this->assertSame($out, $this->me->render(new \Inml\Text($in)));
    }

    public function dataProviderTestWords()
    {
        return [
            ["word", 'word'],
            ["word.style", 'word'],
            ["word.style1.style2", 'word'],
        ];
    }

    /**
     * @dataProvider dataProviderTestWords
     */
    public function testWords($in, $out)
    {
        $this->assertSame($out, $this->me->render(new \Inml\Text($in)));
    }
}