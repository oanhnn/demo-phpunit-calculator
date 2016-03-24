<?php
namespace Demo\Calculator\Tests;

use Demo\Calculator\Calculator;

class CalculatorTest extends \PHPUnit_Framework_TestCase
{

    public static function setUpBeforeClass()
    {
        parent::setUpBeforeClass();
    }

    protected function setUp()
    {
        parent::setUp();
    }

    public function testConstructor()
    {
        
    }

    public function testSetValue()
    {
        
    }

    public function testExecute()
    {

    }

    public function testOutput()
    {
        
    }

    public function testGetOperatorMethod()
    {

    }

    public function testAdd()
    {
        $this->assertSame(10, Calculator::add(5, 5));
    }

    public function testSub()
    {

    }

    public function testMul()
    {
        
    }

    public function testDiv()
    {

    }

    public function testDivByZero()
    {

    }

    public function testMod()
    {
        
    }

    protected function tearDown()
    {
        parent::tearDown();
    }

    public static function tearDownAfterClass()
    {
        parent::tearDownAfterClass();
    }
}
