<?php
namespace Chippyash\Test\Math\Type\Calculator\Gmp;

use Chippyash\Math\Type\Calculator;
use Chippyash\Type\Number\GMPIntType;
use Chippyash\Type\Number\Rational\RationalTypeFactory;
use Chippyash\Type\Number\Complex\ComplexTypeFactory;
use Chippyash\Type\Number\IntType;
use Chippyash\Type\RequiredType;

/**
 * @requires ext gmp
 */
class CalculatorSubTest extends \PHPUnit_Framework_TestCase
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

    public function testSubTwoIntsReturnsIntType()
    {
        $this->assertInstanceOf(
                'Chippyash\Type\Number\GMPIntType',
                $this->sut->sub(2, 3));
    }
    
    public function testSubTwoIntTypesReturnsIntType()
    {
        $this->assertInstanceOf(
                'Chippyash\Type\Number\GMPIntType',
                $this->sut->sub(new IntType(2), new IntType(3)));
    }

    public function testSubRationalTypeAndIntReturnsRationalType()
    {
        $this->assertInstanceOf(
                'Chippyash\Type\Number\Rational\GMPRationalType',
                $this->sut->sub(RationalTypeFactory::create(1,5), 2));
        $this->assertInstanceOf(
                'Chippyash\Type\Number\Rational\GMPRationalType',
                $this->sut->sub(2, RationalTypeFactory::create(1,5)));

    }

    public function testSubRationalTypeAndIntTypeReturnsRationalType()
    {
        $this->assertInstanceOf(
                'Chippyash\Type\Number\Rational\GMPRationalType',
                $this->sut->sub(RationalTypeFactory::create(1,5), new GMPIntType(2)));
        $this->assertInstanceOf(
                'Chippyash\Type\Number\Rational\GMPRationalType',
                $this->sut->sub(new GMPIntType(2), RationalTypeFactory::create(1,5)));

    }

    public function testSubRationalTypeAndFloatReturnsRationalType()
    {
        $this->assertInstanceOf(
                'Chippyash\Type\Number\Rational\GMPRationalType',
                $this->sut->sub(RationalTypeFactory::create(1,5), 2.6));
        $this->assertInstanceOf(
                'Chippyash\Type\Number\Rational\GMPRationalType',
                $this->sut->sub(2.6, RationalTypeFactory::create(1,5)));

    }

    public function testSubTwoComplexNumbersReturnsComplexNumber()
    {
        $this->assertInstanceOf(
                'Chippyash\Type\Number\Complex\GMPComplexType',
                $this->sut->sub(ComplexTypeFactory::create(1,5), ComplexTypeFactory::create(5,1)));
    }

    /**
     * @dataProvider nonComplexNumbers
     * @param numeric $nonComplex
     */
    public function testSubComplexNumbersWithNonComplexNumberReturnsComplexNumber($nonComplex)
    {
        $this->assertInstanceOf(
                'Chippyash\Type\Number\Complex\GMPComplexType',
                $this->sut->sub(ComplexTypeFactory::create(1,5), $nonComplex));
    }

    /**
     * @dataProvider nonComplexNumbers
     * @param numeric $nonComplex
     */
    public function testSubNonComplexNumbersWithComplexNumberThrowsException($nonComplex)
    {
        $this->assertInstanceOf(
                'Chippyash\Type\Number\Complex\GMPComplexType',
                $this->sut->sub($nonComplex, ComplexTypeFactory::create(1,5)));
    }
    public function nonComplexNumbers()
    {
        RequiredType::getInstance()->set(RequiredType::TYPE_GMP);
        return [
            [2],
            [-2.4],
            [RationalTypeFactory::create(1,5)],
        ];
    }

    public function testSubtractionIsNotCommutative()
    {
        $a = $this->sut->sub(12, 3);
        $b = $this->sut->sub(3, 12);
        //a-b != b-a
        $this->assertNotEquals($a, $b);
    }

    public function testSubtractionIsNotAssociative()
    {
        $a = 12;
        $b = 3;
        $c = 5;
        //a-(b-c) != (a-b)-c
        $r1 = $this->sut->sub($a, $this->sut->sub($b, $c));
        $r2 = $this->sut->sub($this->sut->sub($a, $b), $c);

        $this->assertNotEquals($r1, $r2);
    }
}
