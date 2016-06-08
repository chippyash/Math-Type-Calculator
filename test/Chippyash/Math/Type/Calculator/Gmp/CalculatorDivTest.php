<?php
namespace Chippyash\Test\Math\Type\Calculator\Gmp;

use Chippyash\Math\Type\Calculator;
use Chippyash\Type\Number\GMPIntType;
use Chippyash\Type\Number\Rational\RationalTypeFactory;
use Chippyash\Type\Number\Complex\ComplexTypeFactory;
use Chippyash\Type\RequiredType;

/**
 * @requires ext gmp
 */
class CalculatorDivTest extends \PHPUnit_Framework_TestCase
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

    public function testDivTwoIntsReturnsRationalType()
    {
        $this->assertInstanceOf(
                'Chippyash\Type\Number\Rational\GMPRationalType',
                $this->sut->div(2, 3));
    }

    public function testDivTwoIntTypesReturnsRationalType()
    {
        $this->assertInstanceOf(
                'Chippyash\Type\Number\Rational\GMPRationalType',
                $this->sut->div(new GMPIntType(2), new GMPIntType(3)));
    }

    public function testDivIntAndFloatReturnsRationalType()
    {
        $this->assertInstanceOf(
                'Chippyash\Type\Number\Rational\GMPRationalType',
                $this->sut->div(2, 3.4));
        $this->assertInstanceOf(
                'Chippyash\Type\Number\Rational\GMPRationalType',
                $this->sut->div(3.4, 2));
    }

    public function testDivIntTypeAndFloatReturnsRationalType()
    {
        $this->assertInstanceOf(
                'Chippyash\Type\Number\Rational\GMPRationalType',
                $this->sut->div(new GMPIntType(2), 3.4));
        $this->assertInstanceOf(
                'Chippyash\Type\Number\Rational\GMPRationalType',
                $this->sut->div(3.4, new GMPIntType(2)));
    }

    public function testDivTwoFloatsReturnsRationalType()
    {
        $this->assertInstanceOf(
                'Chippyash\Type\Number\Rational\GMPRationalType',
                $this->sut->div(2.6, -3.067));
    }
    
    public function testDivRationalTypeAndIntReturnsRationalType()
    {
        $this->assertInstanceOf(
                'Chippyash\Type\Number\Rational\GMPRationalType',
                $this->sut->div(RationalTypeFactory::create(1,5), 2));
        $this->assertInstanceOf(
                'Chippyash\Type\Number\Rational\GMPRationalType',
                $this->sut->div(2, RationalTypeFactory::create(1,5)));

    }
    
    public function testDivRationalTypeAndFloatReturnsRationalType()
    {
        $this->assertInstanceOf(
                'Chippyash\Type\Number\Rational\GMPRationalType',
                $this->sut->div(RationalTypeFactory::create(1,5), 2.6));
        $this->assertInstanceOf(
                'Chippyash\Type\Number\Rational\GMPRationalType',
                $this->sut->div(2.6, RationalTypeFactory::create(1,5)));

    }

    public function testDivTwoComplexNumbersReturnsComplexNumber()
    {
        $this->assertInstanceOf(
                'Chippyash\Type\Number\Complex\GMPComplexType',
                $this->sut->div(ComplexTypeFactory::create(1,5), ComplexTypeFactory::create(5,1)));
    }

    /**
     * @dataProvider nonComplexNumbers
     * @param numeric $nonComplex
     */
    public function testDivComplexNumbersWithNonComplexNumberReturnsComplexNumber($nonComplex)
    {
        $this->assertInstanceOf(
                'Chippyash\Type\Number\Complex\GMPComplexType',
                $this->sut->div(ComplexTypeFactory::create(1,5), $nonComplex));
    }

    /**
     * @dataProvider nonComplexNumbers
     * @param numeric $nonComplex
     */
    public function testDivNonComplexNumbersWithComplexNumberThrowsException($nonComplex)
    {
        $this->assertInstanceOf(
                'Chippyash\Type\Number\Complex\GMPComplexType',
                $this->sut->div($nonComplex, ComplexTypeFactory::create(1,5)));
    }
    public function nonComplexNumbers()
    {
        return [
            [2],
            [-2.4],
            [RationalTypeFactory::create(2,5)],
        ];
    }

    /**
     * @expectedException BadMethodCallException
     * @expectedExceptionMessage Cannot divide complex number by zero complex number
     */
    public function testDivComplexByZeroComplexThrowsException()
    {
        $this->sut->div(
                ComplexTypeFactory::create(1,5),
                ComplexTypeFactory::create(0,0));

    }

    public function testDivisionIsNotCommutative()
    {
        $a = $this->sut->div(12, 3);
        $b = $this->sut->div(3, 12);
        //a/b != b/a
        $this->assertNotEquals($a->get(), $b->get());
    }

    public function testDivisionIsNotAssociative()
    {
        $a = 12;
        $b = 3;
        $c = 5;
        //a/(b/c) != (a/b)/c
        $r1 = $this->sut->div($a, $this->sut->div($b, $c));
        $r2 = $this->sut->div($this->sut->div($a, $b), $c);

        $this->assertNotEquals($r1->get(), $r2->get());
    }
}
