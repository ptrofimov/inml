<?php
namespace Inml\Render;

use \Inml\Text;

class HtmlTest extends \PHPUnit_Framework_TestCase
{
    public function dataProviderTestParagraphs()
    {
        return [
            ["", ''],
            ["line", '<p>line</p>'],
            ["line1\nline2", '<p>line1 line2</p>'],
            ["line1\n\nline2", '<p>line1</p><p>line2</p>'],
            [".style1\nline1\n\n.style2\nline2",
                '<p class="style1">line1</p><p class="style2">line2</p>'],
            [".style1.style2\nline1",
                '<p class="style1 style2">line1</p>'],
        ];
    }

    /**
     * @dataProvider dataProviderTestParagraphs
     */
    public function testParagraphs($in, $out)
    {
        $this->assertSame($out, (new Html())->render(new Text($in)));
    }

    public function dataProviderTestLines()
    {
        return [
            ["line", '<p>line</p>'],
            [".style line", '<p><span class="style">line</span></p>'],
            ["line .style", '<p><span class="style">line</span></p>'],
            [".style1.style2 line",
                '<p><span class="style1 style2">line</span></p>'],
            ["line .style1.style2",
                '<p><span class="style1 style2">line</span></p>'],
        ];
    }

    /**
     * @dataProvider dataProviderTestLines
     */
    public function testLines($in, $out)
    {
        $this->assertSame($out, (new Html())->render(new Text($in)));
    }

    public function dataProviderTestWords()
    {
        return [
            ["word", '<p>word</p>'],
            ["word.style", '<p><span class="style">word</span></p>'],
            ["word.style1.style2",
                '<p><span class="style1 style2">word</span></p>'],
        ];
    }

    /**
     * @dataProvider dataProviderTestWords
     */
    public function testWords($in, $out)
    {
        $this->assertSame($out, (new Html())->render(new Text($in)));
    }
}