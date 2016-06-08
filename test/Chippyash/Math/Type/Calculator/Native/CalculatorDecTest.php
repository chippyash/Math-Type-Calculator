<?php
namespace Chippyash\Test\Math\Type\Calculator\Native;

use Chippyash\Math\Type\Calculator;
use Chippyash\Type\Number\Complex\ComplexTypeFactory;
use Chippyash\Type\Number\IntType;
use Chippyash\Type\Number\FloatType;
use Chippyash\Type\Number\Rational\RationalTypeFactory;
use Chippyash\Type\RequiredType;

/**
 * Test the decrementor
 */
class CalculatorDecTest extends \PHPUnit_Framework_TestCase
{
    /**
     * System under test
     * @var Calculator
     */
    protected $sut;

    public function setUp()
    {
        RequiredType::getInstance()->set(RequiredType::TYPE_NATIVE);
        $this->sut = new Calculator();
    }

    public function testDecrementingAnIntTypeWillAmendTheIntType()
    {
        $test = new IntType(1);
        $this->sut->dec($test);
        $this->assertInstanceOf('Chippyash\Type\Number\IntType', $test);
        $this->assertEquals(0, $test());
    }

    public function testDecrementingAFloatTypeWillAmendTheFloatType()
    {
        $test = new FloatType(1.5);
        $this->sut->dec($test);
        $this->assertInstanceOf('Chippyash\Type\Number\FloatType', $test);
        $this->assertEquals(0.5, $test());
    }

    public function testDecrementingARationalTypeWillAmendTheRationalType()
    {
        $test = RationalTypeFactory::create(1,3);
        $this->sut->dec($test);
        $this->assertInstanceOf('Chippyash\Type\Number\Rational\RationalType', $test);
        $this->assertEquals('0/3', (string) $test);
    }

    public function testDecrementingAComplexTypeWillAmendTheComplexType()
    {
        $test = ComplexTypeFactory::create(1,3);
        $this->sut->dec($test);
        $this->assertInstanceOf('Chippyash\Type\Number\Complex\ComplexType', $test);
        $this->assertEquals('0+3i', (string) $test);
    }

    public function testYouCanSetADecrementValue()
    {
        $dec = new IntType(2);

        $test = new IntType(1);
        $this->sut->dec($test, $dec);
        $this->assertEquals(-1, $test());

        $test2 = new FloatType(1.5);
        $this->sut->dec($test2, $dec);
        $this->assertEquals(-0.5, $test2());

        $test3 = RationalTypeFactory::create(1,5);
        $this->sut->dec($test3, $dec);
        $this->assertEquals('-1/5', (string) $test3);

        $test4 = ComplexTypeFactory::create(1,3);
        $this->sut->dec($test4, $dec);
        $this->assertEquals('-1+3i', (string) $test4);
    }
}
