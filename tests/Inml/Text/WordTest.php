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
            ['12.5.style', '12.5', ['style'], true, true, false],
            ['127.0.0.1', '127.0.0.1', [], true, false, false],
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
//
//    public function dataProviderTestIsUrl()
//    {
//        return [
//            ['', false],
//            ['link', false],
//            ['domain.com', false],
//            ['http://link', true],
//            ['https://link', true],
//            ['ftp://link', true],
//            ['http://link/$0', true],
//        ];
//    }
//
//    /**
//     * @dataProvider dataProviderTestIsUrl
//     */
//    public function testIsUrl($string, $isUrl)
//    {
//        $this->assertSame($isUrl, (new Word($string))->isUrl());
//    }
//
//    public function dataProviderTestIsEmail()
//    {
//        return [
//            ['', false],
//            ['link', false],
//            ['domain.com', false],
//            ['email@domain.com', true],
//        ];
//    }
//
//    /**
//     * @dataProvider dataProviderTestIsEmail
//     */
//    public function testIsEmail($string, $isEmail)
//    {
//        $this->assertSame($isEmail, (new Word($string))->isEmail());
//    }
}