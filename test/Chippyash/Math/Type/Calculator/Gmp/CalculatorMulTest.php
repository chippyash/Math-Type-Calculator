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
class CalculatorMulTest extends \PHPUnit_Framework_TestCase
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

    public function testMulTwoIntsReturnsIntType()
    {
        $this->assertInstanceOf(
                'Chippyash\Type\Number\GmpIntType',
                $this->sut->mul(2, 3));
    }
    
    public function testMulTwoIntTypesReturnsIntType()
    {
        $this->assertInstanceOf(
                'Chippyash\Type\Number\GmpIntType',
                $this->sut->mul(new GMPIntType(2), new GMPIntType(3)));
    }
    
    public function testMulRationalTypeAndIntReturnsRationalType()
    {
        $this->assertInstanceOf(
                'Chippyash\Type\Number\Rational\GmpRationalType',
                $this->sut->mul(RationalTypeFactory::create(1,5), 2));
        $this->assertInstanceOf(
                'Chippyash\Type\Number\Rational\GmpRationalType',
                $this->sut->mul(2, RationalTypeFactory::create(1,5)));

    }

    public function testMulRationalTypeAndIntTypeReturnsRationalType()
    {
        $this->assertInstanceOf(
                'Chippyash\Type\Number\Rational\GmpRationalType',
                $this->sut->mul(RationalTypeFactory::create(1,5), new GMPIntType(2)));
        $this->assertInstanceOf(
                'Chippyash\Type\Number\Rational\GmpRationalType',
                $this->sut->mul(new GMPIntType(2), RationalTypeFactory::create(1,5)));

    }


    public function testMulRationalTypeAndFloatReturnsRationalType()
    {
        $this->assertInstanceOf(
                'Chippyash\Type\Number\Rational\GmpRationalType',
                $this->sut->mul(RationalTypeFactory::create(1,5), 2.6));
        $this->assertInstanceOf(
                'Chippyash\Type\Number\Rational\GmpRationalType',
                $this->sut->mul(2.6, RationalTypeFactory::create(1,5)));

    }
    
    public function testMulTwoComplexNumbersReturnsComplexNumber()
    {
        $this->assertInstanceOf(
                'Chippyash\Type\Number\Complex\GmpComplexType',
                $this->sut->mul(ComplexTypeFactory::create(1,5), ComplexTypeFactory::create(5,1)));
    }

    /**
     * @dataProvider nonComplexNumbers
     * @param numeric $nonComplex
     */
    public function testMulComplexNumbersWithNonComplexNumberReturnsComplexNumber($nonComplex)
    {
        $this->assertInstanceOf(
                'Chippyash\Type\Number\Complex\GmpComplexType',
                $this->sut->mul(ComplexTypeFactory::create(1,5), $nonComplex));
    }

    /**
     * @dataProvider nonComplexNumbers
     * @param numeric $nonComplex
     */
    public function testMulNonComplexNumbersWithComplexNumberThrowsException($nonComplex)
    {
        $this->assertInstanceOf(
                'Chippyash\Type\Number\Complex\GmpComplexType',
                $this->sut->mul($nonComplex, ComplexTypeFactory::create(1,5)));
    }
    public function nonComplexNumbers()
    {
        return [
            [2],
            [-2.4],
            [RationalTypeFactory::create(1,5)],
        ];
    }


    public function testMultiplicationIsCommutative()
    {
        //a*b = b*a
        $a = $this->sut->mul(12, 3);
        $b = $this->sut->mul(3, 12);
        $this->assertEquals($a->get(), $b->get());
    }

    public function testMultiplicationIsAssociative()
    {
        $a = 12;
        $b = 3;
        $c = 5;
        //a*(b*c) = (a*b)*c
        $r1 = $this->sut->mul($a, $this->sut->mul($b, $c));
        $r2 = $this->sut->mul($this->sut->mul($a, $b), $c);

        $this->assertEquals($r1->get(), $r2->get());
    }

    public function testMultiplicationIsDistributiveOverAddition()
    {
        $a = 12;
        $b = 3;
        $c = 5;
        //a(b+c) == ab + ac
        $r1 = $this->sut->mul($a, $this->sut->add($b, $c));
        $r2 = $this->sut->add($this->sut->mul($a, $b),$this->sut->mul($a, $c));

        $this->assertEquals($r1->get(), $r2->get());
    }

    public function testMultiplicationIsDistributiveOverSubtraction()
    {
        $a = 12;
        $b = 3;
        $c = 5;
        //a(b-c) == ab - ac
        $r1 = $this->sut->mul($a, $this->sut->sub($b, $c));
        $r2 = $this->sut->sub($this->sut->mul($a, $b),$this->sut->mul($a, $c));

        $this->assertEquals($r1->get(), $r2->get());
    }

}
