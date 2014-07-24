<?php
namespace chippyash\Test\Math\Type;

use chippyash\Math\Type\Calculator;
use chippyash\Math\Type\Calculator\Native;
use chippyash\Type\Number\IntType;
use chippyash\Type\Number\WholeIntType;
use chippyash\Type\Number\NaturalIntType;
use chippyash\Type\Number\FloatType;
use chippyash\Type\Number\Rational\RationalTypeFactory;
use chippyash\Type\Number\Complex\ComplexTypeFactory;

/**
 *
 */
class CalculatorTest extends \PHPUnit_Framework_TestCase
{
    public function testConstructWithNoParameterReturnsCalculator()
    {
        $this->assertInstanceOf(
                'chippyash\Math\Type\Calculator', new Calculator());
    }

    public function testConstructWithValidEngineTypeReturnsCalculator()
    {
        $this->assertInstanceOf(
                'chippyash\Math\Type\Calculator', new Calculator(Calculator::ENGINE_NATIVE));
    }

    public function testConstructWithCalculatorEngineInterfaceTypeReturnsCalculator()
    {
        $this->assertInstanceOf(
                'chippyash\Math\Type\Calculator', new Calculator(new Native()));
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessa No known calculator engine
     */
    public function testConstructWithInvalidCalculatorEngineThrowsException()
    {
        $c = new Calculator('foo');
    }
}
