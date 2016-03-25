<?php
namespace Demo\Calculator\Tests;

use Demo\Calculator\Calculator;

/**
 * Test class for class Calculator
 */
class CalculatorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Calculator
     */
    protected $cal;

    /**
     * Get a non public property of an object
     *
     * @param object $obj
     * @param string $property
     * @return mixed
     */
    protected function getNonPublicProperty($obj, $property)
    {
        if (!is_object($obj) || !is_string($property)) {
            return null;
        }
        $ref = new \ReflectionProperty(get_class($obj), $property);
        $ref->setAccessible(true);

        return $ref->getValue($obj);
    }

    /**
     * Set value for a non public property of an object
     *
     * @param object $obj
     * @param string $property
     * @param mixed  $value
     */
    protected function setNonPublicProperty($obj, $property, $value)
    {
        if (!is_object($obj) || !is_string($property)) {
            return;
        }
        $ref = new \ReflectionProperty(get_class($obj), $property);
        $ref->setAccessible(true);

        $ref->setValue($obj, $value);
    }

    /**
     * Setting up before load this class
     */
    public static function setUpBeforeClass()
    {
        parent::setUpBeforeClass();
    }

    /**
     * Setting up before load test method
     */
    protected function setUp()
    {
        parent::setUp();
        $this->cal = new Calculator();
    }

    /**
     * Test constructor
     *
     * @param mixed     $paramLimit
     * @param int|float $expectedLimit
     * @dataProvider dataForTestConstructor
     */
    public function testConstructor($paramLimit, $expectedLimit)
    {
        $cal = new Calculator($paramLimit);
        $limit = $this->getNonPublicProperty($cal, 'limit');
        $value = $this->getNonPublicProperty($cal, 'value');

        $this->assertEquals($expectedLimit, $limit);
        $this->assertEquals(0, $value);
    }

    /**
     * Provide data for test constructor
     *
     * @return array
     */
    public function dataForTestConstructor()
    {
        return [
            [10, 10],
            [0, 0],
            [-3, 0],
            [10.5, 10],
            [-10.5, 0],
            ['10.5', 10],
            ['string', 0],
        ];
    }

    /**
     * Test constructor without parameters
     */
    public function testConstructorWithoutParameters()
    {
        $limit = $this->getNonPublicProperty($this->cal, 'limit');
        $value = $this->getNonPublicProperty($this->cal, 'value');

        $this->assertEquals(10, $limit);
        $this->assertEquals(0, $value);
    }

    /**
     * Test method `setValue()`
     *
     * @param mixed     $paramValue
     * @param int|float $expectedValue
     * @depends testConstructorWithoutParameters
     * @dataProvider dataForTestSetValue
     */
    public function testSetValue($paramValue, $expectedValue)
    {
        $this->cal->setValue($paramValue);
        $value = $this->getNonPublicProperty($this->cal, 'value');

        $this->assertTrue(is_int($value) || is_float($value));
        $this->assertEquals($expectedValue, $value);
    }

    /**
     * Provide data for test method `setValue()` 
     * 
     * @return array
     */
    public function dataForTestSetValue()
    {
        return [
            [10, 10],
            [10.5, 10.5],
            [-10, -10],
            [-10.5, -10.5],
            [0, 0],
            ['10', 10],
            ['-10.5', -10.5],
            ['string', 0],
        ];
    }

    public function testExecute()
    {

    }

    /**
     * Test method `output()`
     *
     * @param int|float $value
     * @param string    $expected
     * @dataProvider dataForTestOutput
     */
    public function testOutput($value, $expected)
    {
        $this->markTestSkipped();
        $this->setNonPublicProperty($this->cal, 'value', $value);

        $this->expectOutputString($expected);
        $this->cal->output();
    }

    /**
     * Provide data for test method `output()`
     *
     * @return array
     */
    public function dataForTestOutput()
    {
        return [
            [10, '10'],
            [1.23, '1.23'],
            [-1.23, '-1.23'],
            [12345678901, '1234567890'],
            [123456.7890123456789, '123456.7890'],
            [123456789.123456789, '123456789.12'],
        ];
    }

    /**
     * Test method `getOperatorMethod()`
     *
     * @param string $operator
     * @param string $method
     * @dataProvider dataForTestGetOperatorMethod
     */
    public function testGetOperatorMethod($operator, $method)
    {
        $ref = new \ReflectionMethod(Calculator::class, 'getOperatorMethod');
        $ref->setAccessible(true);

        $this->assertSame($method, $ref->invoke(null, $operator));
    }

    /**
     * Test method `getOperatorMethod()` with an invalid operator
     *
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Operator is invalid
     */
    public function testGetOperatorMethodWithInvalidOperator()
    {
        $ref = new \ReflectionMethod(Calculator::class, 'getOperatorMethod');
        $ref->setAccessible(true);
        $ref->invoke(null, '&');
    }

    /**
     * Provide data for test method `getOperatorMethod()`
     *
     * @return array
     */
    public function dataForTestGetOperatorMethod()
    {
        return [
            [Calculator::OP_ADD, 'add'],
            [Calculator::OP_DIV, 'div'],
            [Calculator::OP_MOD, 'mod'],
            [Calculator::OP_MUL, 'mul'],
            [Calculator::OP_SUB, 'sub'],
        ];
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

    /**
     * Test case dividing by zero
     *
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Division by zero
     */
    public function testDivByZero()
    {
        //$this->expectException(\InvalidArgumentException::class);
        //$this->expectExceptionMessage('Division by zero');
        Calculator::div(10, 0);
    }

    /**
     * Test method `mod()`
     *
     * @param mixed $a
     * @param mixed $b
     * @dataProvider dataForTestMod
     */
    public function testMod($a, $b, $expected)
    {
        $result = Calculator::mod($a, $b);

        $this->assertTrue(is_int($result));
        $this->assertTrue($result > 0);
        $this->assertEquals($expected, $result);
    }

    /**
     * Data for test method `mod()`
     *
     * @return array
     */
    public function dataForTestMod()
    {
        return [
            [1, 3, 1],
            [10, 4, 2],
            [-2, 3, 1],
            [1.5, 2, 1],
        ];
    }

    /**
     * Test case modulus by zero
     *
     * @expectedException \PHPUnit_Framework_Error
     * @expectedExceptionMessage Division by zero
     */
    public function testModByZero()
    {
        //$this->expectException(\PHPUnit_Framework_Error::class);
        //$this->expectExceptionMessage('Division by zero');
        Calculator::mod(10, 0);
    }

    /**
     * Tear down after test
     */
    protected function tearDown()
    {
        parent::tearDown();
    }

    /**
     * Tear down after unload class
     */
    public static function tearDownAfterClass()
    {
        parent::tearDownAfterClass();
    }
}
