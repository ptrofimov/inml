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
        ];
    }

    /**
     * @dataProvider dataProviderTestParse
     */
    public function testParse($string, $count)
    {
        $text = new Text($string);

        $this->assertSame($count, count($text));

        foreach ($text as $paragraph) {
            $this->assertInstanceOf('\Inml\Text\Paragraph', $paragraph);
        }
    }
}