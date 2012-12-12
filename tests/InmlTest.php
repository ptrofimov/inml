<?php
require_once(dirname(__DIR__) . '/src/Inml.php');

class InmlTest extends PHPUnit_Framework_TestCase
{
    public function testInstance()
    {
        $this->assertInstanceOf('Inml', new Inml);
    }
}