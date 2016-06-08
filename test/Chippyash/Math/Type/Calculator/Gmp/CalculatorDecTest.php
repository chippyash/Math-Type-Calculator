<?php
namespace Chippyash\Test\Math\Type\Calculator\Gmp;

use Chippyash\Math\Type\Calculator;
use Chippyash\Type\Number\Complex\ComplexTypeFactory;
use Chippyash\Type\Number\GMPIntType;
use Chippyash\Type\Number\Rational\RationalTypeFactory;
use Chippyash\Type\RequiredType;

/**
 * @requires ext gmp
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
        RequiredType::getInstance()->set(RequiredType::TYPE_GMP);
        $this->sut = new Calculator();
    }

    public function testDecrementingAnIntTypeWillAmendTheIntType()
    {
        $test = new GMPIntType(1);
        $this->sut->dec($test);
        $this->assertInstanceOf('Chippyash\Type\Number\GMPIntType', $test);
        $this->assertEquals(0, $test());
    }
    
    public function testDecrementingARationalTypeWillAmendTheRationalType()
    {
        $test = RationalTypeFactory::create(1,3);
        $this->sut->dec($test);
        $this->assertInstanceOf('Chippyash\Type\Number\Rational\GMPRationalType', $test);
        $this->assertEquals('0/3', (string) $test);
    }

    public function testDecrementingAComplexTypeWillAmendTheComplexType()
    {
        $test = ComplexTypeFactory::create(1,3);
        $this->sut->dec($test);
        $this->assertInstanceOf('Chippyash\Type\Number\Complex\GMPComplexType', $test);
        $this->assertEquals('0+3i', (string) $test);
    }

    public function testYouCanSetADecrementValue()
    {
        $dec = new GMPIntType(2);

        $test = new GMPIntType(1);
        $this->sut->dec($test, $dec);
        $this->assertEquals(-1, $test());
        
        $test3 = RationalTypeFactory::create(1,5);
        $this->sut->dec($test3, $dec);
        $this->assertEquals('-1/5', (string) $test3);

        $test4 = ComplexTypeFactory::create(1,3);
        $this->sut->dec($test4, $dec);
        $this->assertEquals('-1+3i', (string) $test4);
    }
}
