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

    /**
     * @runInSeparateProcess
     * 
     * This is a slightly bizarre test, as you have to create a calculator to
     * send to the engine, in order to be able to construct a calculator with
     * an engine!  In normal circumstance you won't do this, but simply create
     * a new Calculator, optionally preceded by setting the required number type
     */
    public function testConstructWithCalculatorEngineInterfaceTypeReturnsCalculator()
    {
        Calculator::setNumberType(Calculator::TYPE_NATIVE);
        $this->assertInstanceOf(
                'Chippyash\Math\Type\Calculator', new Calculator(new Native()));
    }

    /**
     * @expectedException PHPUnit_Framework_Error
     */
    public function testConstructWithInvalidCalculatorEngineThrowsException()
    {
        $c = new Calculator('foo');
    }
    
    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage foo is not a supported number type
     */
    public function testSetNumberTypeWithInvalidTypeThrowsException()
    {
        Calculator::setNumberType('foo');
    }
    
    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage GMP not supported
     */
    public function testSetNumberTypeWillThrowExceptionIfGmpRequestedAndGmpNotLoaded()
    {
        if (extension_loaded('gmp')) {
            $this->markTestSkipped('GMP loaded - test skipped');
        }
        Calculator::setNumberType(Calculator::TYPE_GMP);
    }
    
    /**
     * @runInSeparateProcess
     */
    public function testCalculatorAutomaticallyReturnsCorrectNumbersDependingOnGmpBeingLoaded()
    {
        $c = new Calculator();
        if (extension_loaded('gmp')) {
            $this->assertInstanceOf('chippyash\Type\Number\GMPIntType', $c->add(2, 2));
        } else {
            $this->assertInstanceOf('chippyash\Type\Number\IntType', $c->add(2, 2));
        }
    }
}
