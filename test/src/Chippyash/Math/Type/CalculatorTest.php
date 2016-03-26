<?php
namespace Chippyash\Test\Math\Type;

<<<<<<< HEAD:test/src/chippyash/Math/Type/CalculatorTest.php
use chippyash\Math\Type\Calculator;
use chippyash\Math\Type\Calculator\NativeEngine;
=======
use Chippyash\Math\Type\Calculator;
use Chippyash\Math\Type\Calculator\Native;
use Chippyash\Type\Number\IntType;
use Chippyash\Type\Number\WholeIntType;
use Chippyash\Type\Number\NaturalIntType;
use Chippyash\Type\Number\FloatType;
use Chippyash\Type\Number\Rational\RationalTypeFactory;
use Chippyash\Type\Number\Complex\ComplexTypeFactory;
>>>>>>> 4f1de48055fdc9f29c54dbfd364827575f79d2d4:test/src/Chippyash/Math/Type/CalculatorTest.php

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

<<<<<<< HEAD:test/src/chippyash/Math/Type/CalculatorTest.php
    /**
     * @runInSeparateProcess
     * 
     * This is a slightly bizarre test, as you have to create a calculator to
     * send to the engine, in order to be able to construct a calculator with
     * an engine!  In normal circumstance you won't do this, but simply create
     * a new Calculator, optionally preceded by setting the required number type
     */
=======
    public function testConstructWithValidEngineTypeReturnsCalculator()
    {
        $this->assertInstanceOf(
                'Chippyash\Math\Type\Calculator', new Calculator(Calculator::ENGINE_NATIVE));
    }

>>>>>>> 4f1de48055fdc9f29c54dbfd364827575f79d2d4:test/src/Chippyash/Math/Type/CalculatorTest.php
    public function testConstructWithCalculatorEngineInterfaceTypeReturnsCalculator()
    {
        Calculator::setNumberType(Calculator::TYPE_NATIVE);
        $this->assertInstanceOf(
<<<<<<< HEAD:test/src/chippyash/Math/Type/CalculatorTest.php
                'chippyash\Math\Type\Calculator', new Calculator(new NativeEngine(new Calculator())));
=======
                'Chippyash\Math\Type\Calculator', new Calculator(new Native()));
>>>>>>> 4f1de48055fdc9f29c54dbfd364827575f79d2d4:test/src/Chippyash/Math/Type/CalculatorTest.php
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
