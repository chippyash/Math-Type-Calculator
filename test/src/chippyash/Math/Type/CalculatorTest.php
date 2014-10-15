<?php
namespace chippyash\Test\Math\Type;

use chippyash\Math\Type\Calculator;
use chippyash\Math\Type\Calculator\NativeEngine;

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

    public function testConstructWithCalculatorEngineInterfaceTypeReturnsCalculator()
    {
        $this->assertInstanceOf(
                'chippyash\Math\Type\Calculator', new Calculator(new NativeEngine()));
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
