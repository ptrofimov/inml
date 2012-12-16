<?php
namespace Inml\Text;

class LineTest extends \PHPUnit_Framework_TestCase
{
    public function testInstance()
    {
        $this->assertInstanceOf('\Inml\Text\Line', new Line('test'));
    }

    public function dataProviderTestParse()
    {
        return [
            ['', 0, [], [], false],
            ['word', 1, ['word'], [], false],
            ['word1 word2', 2, ['word1', 'word2'], [], false],
            ['.style', 0, [], ['style'], true],
            ['.style1.style2', 0, [], ['style1', 'style2'], true],
            ['.style word', 1, ['word'], ['style'], false],
            ['word .style', 1, ['word'], ['style'], false],
            ['.style1.style2 word', 1, ['word'],
                ['style1', 'style2'], false],
            ['word .style1.style2', 1, ['word'],
                ['style1', 'style2'], false],
        ];
    }

    /**
     * @dataProvider dataProviderTestParse
     */
    public function testParse($string, $count, array $words,
                              array $getStyles, $isStyle)
    {
        $line = new Line($string);

        $this->assertSame($count, count($line));

        $array = [];
        foreach ($line as $word) {
            $this->assertInstanceOf('\Inml\Text\Word', $word);
            $array[] = $word->getWord();
        }

        $this->assertSame($words, $array);
    }
}