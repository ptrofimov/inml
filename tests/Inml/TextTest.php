<?php
namespace Inml;

class TextTest extends \PHPUnit_Framework_TestCase
{
    public function testInstance()
    {
        $this->assertInstanceOf('\Inml\Text', new Text('test'));
    }

    public function dataProviderTestParse()
    {
        return [
            ["", 0],
            ["paragraph", 1],
            ["paragraph1\n\nparagraph2", 2],
            ["paragraph1\n\nparagraph2\n\nparagraph3", 3],
        ];
    }

    /**
     * @dataProvider dataProviderTestParse
     */
    public function testParse($string, $count)
    {
        $text = new Text($string);

        $this->assertSame($count, $text->getCount());
        $this->assertSame($count, count($text));
        $this->assertSame($count > 0 ? false : true, $text->isEmpty());
        $this->assertSame($string, $text->getRawString());

        foreach ($text as $paragraph) {
            $this->assertInstanceOf('\Inml\Text\Paragraph', $paragraph);
        }
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
        $this->assertSame($out, (new Text('test'))->normalize($in));
    }
}