<?php
namespace Chippyash\Test\Math\Type\Calculator\Gmp;

use Chippyash\Math\Type\Calculator;
use Chippyash\Type\Number\Complex\ComplexTypeFactory;
use Chippyash\Type\Number\GMPIntType;
use Chippyash\Type\Number\Rational\RationalTypeFactory;
use Chippyash\Type\RequiredType;

/**
 * Test the incrementor
 * @requires ext gmp
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
        RequiredType::getInstance()->set(RequiredType::TYPE_GMP);
        $this->sut = new Calculator();
    }

    public function testIncrementingAnIntTypeWillAmendTheIntType()
    {
        $test = new GMPIntType(1);
        $this->sut->inc($test);
        $this->assertInstanceOf('Chippyash\Type\Number\GMPIntType', $test);
        $this->assertEquals(2, $test());
    }

    public function testIncrementingARationalTypeWillAmendTheRationalType()
    {
        $test = RationalTypeFactory::create(1,3);
        $this->sut->inc($test);
        $this->assertInstanceOf('Chippyash\Type\Number\Rational\GMPRationalType', $test);
        $this->assertEquals('2/3', (string) $test);
    }

    public function testIncrementingAComplexTypeWillAmendTheComplexType()
    {
        $test = ComplexTypeFactory::create(1,3);
        $this->sut->inc($test);
        $this->assertInstanceOf('Chippyash\Type\Number\Complex\GMPComplexType', $test);
        $this->assertEquals('2+3i', (string) $test);
    }

    public function testYouCanSetAnIncrementValue()
    {
        $inc = new GMPIntType(2);

        $test = new GMPIntType(1);
        $this->sut->inc($test, $inc);
        $this->assertEquals(3, $test());

        $test3 = RationalTypeFactory::create(1,5);
        $this->sut->inc($test3, $inc);
        $this->assertEquals('3/5', (string) $test3);

        $test4 = ComplexTypeFactory::create(1,3);
        $this->sut->inc($test4, $inc);
        $this->assertEquals('3+3i', (string) $test4);
    }
}
