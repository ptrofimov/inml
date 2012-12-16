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
            ['', 0, [], [], false, false],
            ['word', 1, ['word'], [], false, false],
            ['word1 word2', 2, ['word1', 'word2'], [], false, false],
            ['.style', 0, [], ['style'], true, true],
            ['.style1.style2', 0, [], ['style1', 'style2'], true, true],
            ['.style word', 1, ['word'], ['style'], false, true],
            ['word .style', 1, ['word'], ['style'], false, true],
            ['.style1.style2 word', 1, ['word'],
                ['style1', 'style2'], false, true],
            ['word .style1.style2', 1, ['word'],
                ['style1', 'style2'], false, true],
        ];
    }

    /**
     * @dataProvider dataProviderTestParse
     */
    public function testParse($string, $count, array $words,
                              array $getStyles, $isStyle, $hasStyles)
    {
        $line = new Line($string);

        $this->assertSame($count, count($line));

        $array = [];
        foreach ($line as $word) {
            $this->assertInstanceOf('\Inml\Text\Word', $word);
            $array[] = $word->getWord();
        }
        $this->assertSame($words, $array);

        $this->assertSame($getStyles, $line->getStyles());
        $this->assertSame($isStyle, $line->isStyle());
        $this->assertSame($hasStyles, $line->hasStyles());
    }
//
//    public function dataProviderTestDefine()
//    {
//        return [
//            ['', false, []],
//            ['#key', false, []],
//            ['value', false, []],
//            ['#key value', true, ['key' => 'value']],
//        ];
//    }
//
//    /**
//     * @dataProvider dataProviderTestDefine
//     */
//    public function testDefine($string, $isDefine, array $getDefine)
//    {
//        $line = new Line($string);
//
//        $this->assertSame($isDefine, $line->isDefine());
//        $this->assertSame($getDefine, $line->getDefine());
//    }
}