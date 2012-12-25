<?php
namespace Inml\Text;

class ParagraphTest extends \PHPUnit_Framework_TestCase
{
    public function testInstance()
    {
        $this->assertInstanceOf('\Inml\Text\Paragraph', new Paragraph('test'));
    }

    public function dataProviderTestParse()
    {
        return [
            ["", 0, [], false],
            ["line", 1, [], false],
            ["line1\nline2", 2, [], false],
            [".style\nline1\nline2", 2, ['style'], true],
            [".style1.style2\nline1\nline2", 2,
                ['style1', 'style2'], true],
        ];
    }

    /**
     * @dataProvider dataProviderTestParse
     */
    public function testParse($string, $count, array $getStyles, $hasStyles)
    {
        $paragraph = new Paragraph($string);

        $this->assertSame($string, $paragraph->getRawString());

        $this->assertSame($count, count($paragraph));
        $this->assertSame($count, $paragraph->getCount());
        $this->assertSame($count > 0 ? false : true, $paragraph->isEmpty());

        foreach ($paragraph as $line) {
            $this->assertInstanceOf('\Inml\Text\Line', $line);
        }

        $this->assertSame($getStyles, $paragraph->getStyles());
        $this->assertSame($hasStyles, $paragraph->hasStyles());
    }
}