<?php
require_once(dirname(__DIR__) . '/src/Inml.php');

class InmlTest extends PHPUnit_Framework_TestCase
{
    /** @var Inml */
    private $me;

    public function setUp()
    {
        $this->me = new Inml();
    }

    public function testInstance()
    {
        $this->assertInstanceOf('Inml', $this->me);
    }

    public function dataProviderTestNormalize()
    {
        return [
            ['', ''],
            [' ', ' '],
            ['  ', ' '],
            ["\t", ' '],
            ["\t\t", ' '],
            [" \t ", ' '],
            ["\n", "\n"],
            ["\n\n", "\n\n"],
            ["\r", "\n"],
            ["\r\r", "\n\n"],
            ["\r\n", "\n"],
            ["\r\n\r\n", "\n\n"],
        ];
    }

    /**
     * @dataProvider dataProviderTestNormalize
     */
    public function testRender($inml, $html)
    {
        $this->assertSame($html, $this->me->render($inml));
    }
}