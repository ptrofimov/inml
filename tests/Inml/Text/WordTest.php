<?php
namespace Inml\Text;

class WordTest extends \PHPUnit_Framework_TestCase
{
    public function testInstance()
    {
        $this->assertInstanceOf('\Inml\Text\Word', new Word('test'));
    }

    public function dataProviderTestParse()
    {
        return [
            ['', '', [], false, false, false],
            ['word', 'word', [], true, false, false],
            ['.style', '', ['style'], false, true, true],
            ['word.style', 'word', ['style'], true, true, false],
            ['word.style1.style2', 'word',
                ['style1', 'style2'], true, true, false],
        ];
    }

    /**
     * @dataProvider dataProviderTestParse
     */
    public function testParse($string, $getWord,
                              array $getStyles, $hasWord,
                              $hasStyles, $isStyle)
    {
        $word = new Word($string);

        $this->assertSame($getWord, $word->getWord());
        $this->assertSame($getStyles, $word->getStyles());
        $this->assertSame($hasWord, $word->hasWord());
        $this->assertSame($hasStyles, $word->hasStyles());
        $this->assertSame($isStyle, $word->isStyle());
    }

    public function dataProviderTestDefine()
    {
        return [
            ['', false, null],
            ['key', false, null],
            ['#key', true, 'key'],
        ];
    }

    /**
     * @dataProvider dataProviderTestDefine
     */
    public function testDefine($string, $isDefine, $getDefineKey)
    {
        $word = new Word($string);

        $this->assertSame($isDefine, $word->isDefine());
        $this->assertSame($getDefineKey, $word->getDefineKey());
    }
}