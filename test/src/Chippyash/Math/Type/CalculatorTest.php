<?php
namespace Chippyash\Test\Math\Type;

use Chippyash\Math\Type\Calculator;
use Chippyash\Math\Type\Calculator\Native;
use Chippyash\Type\Number\IntType;
use Chippyash\Type\Number\WholeIntType;
use Chippyash\Type\Number\NaturalIntType;
use Chippyash\Type\Number\FloatType;
use Chippyash\Type\Number\Rational\RationalTypeFactory;
use Chippyash\Type\Number\Complex\ComplexTypeFactory;

/**
 *
 */
class CalculatorTest extends \PHPUnit_Framework_TestCase
{
    public function testConstructWithNoParameterReturnsCalculator()
    {
        $this->assertInstanceOf(
                'Chippyash\Math\Type\Calculator', new Calculator());
    }

    public function testConstructWithValidEngineTypeReturnsCalculator()
    {
        $this->assertInstanceOf(
                'Chippyash\Math\Type\Calculator', new Calculator(Calculator::ENGINE_NATIVE));
    }

    public function testConstructWithCalculatorEngineInterfaceTypeReturnsCalculator()
    {
        $this->assertInstanceOf(
                'Chippyash\Math\Type\Calculator', new Calculator(new Native()));
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
