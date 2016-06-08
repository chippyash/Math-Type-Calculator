<?php
namespace Chippyash\Test\Math\Type\Calculator\Native;

use Chippyash\Math\Type\Calculator;
use Chippyash\Math\Type\Calculator\NativeEngine;
use Chippyash\Type\RequiredType;

/**
 *
 */
class CalculatorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * System under test
     * @var Calculator
     */
    protected function setUp()
    {
        RequiredType::getInstance()->set(RequiredType::TYPE_NATIVE);
    }

    public function testConstructWithNoParameterReturnsCalculator()
    {
        $this->assertInstanceOf(
                'Chippyash\Math\Type\Calculator', new Calculator());
    }

    /**
     * This is a slightly bizarre test, as you have to create a calculator to
     * send to the engine, in order to be able to construct a calculator with
     * an engine!  In normal circumstance you won't do this, but simply create
     * a new Calculator, optionally preceded by setting the required number type
     */
    public function testConstructWithCalculatorEngineInterfaceTypeReturnsCalculator()
    {
        $this->assertInstanceOf(
                'Chippyash\Math\Type\Calculator', new Calculator(new NativeEngine()));
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testConstructWithInvalidCalculatorEngineThrowsException()
    {
        $c = new Calculator('foo');
    }

    public function testCalculatorAutomaticallyReturnsCorrectNumbers()
    {
        $c = new Calculator();
        $this->assertInstanceOf('Chippyash\Type\Number\IntType', $c->add(2, 2));
    }
}
