<?php
namespace Inml\Render;

use \Inml\Text;

class HtmlTest extends \PHPUnit_Framework_TestCase
{
    /** @var Html */
    private $me;

    public function setUp()
    {
        $this->me = new Html();
    }

    public function dataProviderTestWrapInTags()
    {
        return [
            ['', [], ''],
            ['word', [], 'word'],
            ['word', ['style'], '<span class="style">word</span>'],
            ['word', ['sty"le'], '<span class="style">word</span>'],
            ['word', ['style', 'style'], '<span class="style">word</span>'],
            ['word', ['style1', 'style2'],
                '<span class="style1 style2">word</span>'],
            ['word', ['p'], '<p>word</p>'],
            ['word', ['P'], '<span class="P">word</span>'],
            ['word', ['p', 'b'], '<p><b>word</b></p>'],
            ['word', ['p', 'style'], '<p class="style">word</p>'],
            ['word', ['p', 'style1', 'style2'],
                '<p class="style1 style2">word</p>'],
            ['word', ['p', 'style1', 'style2', 'b', 'style3'],
                '<p class="style1 style2"><b class="style3">word</b></p>'],
        ];
    }

    /**
     * @dataProvider dataProviderTestWrapInTags
     */
    public function testWrapInTags($content, array $styles, $return)
    {
        $this->assertSame($return, $this->me->wrapInTags($content, $styles));
    }

    public function dataProviderTestParagraphs()
    {
        return [
            ["", ''],
            ["line", '<p>line</p>'],
            ["line1\nline2", '<p>line1 line2</p>'],
            ["line1\n\nline2", '<p>line1</p><p>line2</p>'],
            [".style1.style2\nline", '<p class="style1 style2">line</p>'],
            [".style1\nline1\n\n.style2\nline2",
                '<p class="style1">line1</p><p class="style2">line2</p>'],
        ];
    }

    /**
     * @dataProvider dataProviderTestParagraphs
     */
    public function testParagraphs($in, $out)
    {
        $this->assertSame($out, $this->me->render(new Text($in)));
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
        $this->assertSame($out, $this->me->render(new Text($in)));
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
        $this->assertSame($out, $this->me->render(new Text($in)));
    }
}