<?php
namespace Chippyash\Test\Math\Type\Calculator\Native;

use Chippyash\Math\Type\Calculator;
use Chippyash\Type\Number\Complex\ComplexTypeFactory;
use Chippyash\Type\Number\IntType;
use Chippyash\Type\Number\FloatType;
use Chippyash\Type\Number\Rational\RationalType;
use Chippyash\Type\Number\Rational\RationalTypeFactory;
use Chippyash\Type\RequiredType;

/**
 * Test the incrementor
 */
class CalculatorIncTest extends \PHPUnit_Framework_TestCase
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

    public function testIncrementingAnIntTypeWillAmendTheIntType()
    {
        $test = new IntType(1);
        $this->sut->inc($test);
        $this->assertInstanceOf('Chippyash\Type\Number\IntType', $test);
        $this->assertEquals(2, $test());
    }

    public function testIncrementingAFloatTypeWillAmendTheFloatType()
    {
        $test = new FloatType(1.5);
        $this->sut->inc($test);
        $this->assertInstanceOf('Chippyash\Type\Number\FloatType', $test);
        $this->assertEquals(2.5, $test());
    }

    public function testIncrementingARationalTypeWillAmendTheRationalType()
    {
        $test = RationalTypeFactory::create(1,3);
        $this->sut->inc($test);
        $this->assertInstanceOf('Chippyash\Type\Number\Rational\RationalType', $test);
        $this->assertEquals('2/3', (string) $test);
    }

    public function testIncrementingAComplexTypeWillAmendTheComplexType()
    {
        $test = ComplexTypeFactory::create(1,3);
        $this->sut->inc($test);
        $this->assertInstanceOf('Chippyash\Type\Number\Complex\ComplexType', $test);
        $this->assertEquals('2+3i', (string) $test);
    }

    public function testYouCanSetAnIncrementValue()
    {
        $inc = new IntType(2);

        $test = new IntType(1);
        $this->sut->inc($test, $inc);
        $this->assertEquals(3, $test());

        $test2 = new FloatType(1.5);
        $this->sut->inc($test2, $inc);
        $this->assertEquals(3.5, $test2());

        $test3 = RationalTypeFactory::create(1,5);
        $this->sut->inc($test3, $inc);
        $this->assertEquals('3/5', (string) $test3);

        $test4 = ComplexTypeFactory::create(1,3);
        $this->sut->inc($test4, $inc);
        $this->assertEquals('3+3i', (string) $test4);
    }
}
