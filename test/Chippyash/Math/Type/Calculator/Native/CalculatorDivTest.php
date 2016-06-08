<?php
namespace Chippyash\Test\Math\Type\Calculator\Native;

use Chippyash\Math\Type\Calculator;
use Chippyash\Type\Number\IntType;
use Chippyash\Type\Number\WholeIntType;
use Chippyash\Type\Number\NaturalIntType;
use Chippyash\Type\Number\FloatType;
use Chippyash\Type\Number\Rational\RationalTypeFactory;
use Chippyash\Type\Number\Complex\ComplexTypeFactory;
use Chippyash\Type\RequiredType;

class CalculatorDivTest extends \PHPUnit_Framework_TestCase
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

    public function testDivTwoIntsReturnsRationalType()
    {
        $this->assertInstanceOf(
                'Chippyash\Type\Number\Rational\RationalType',
                $this->sut->div(2, 3));
    }

    public function testDivTwoIntTypesReturnsRationalType()
    {
        $this->assertInstanceOf(
                'Chippyash\Type\Number\Rational\RationalType',
                $this->sut->div(new IntType(2), new IntType(3)));
    }

    public function testDivIntAndFloatReturnsFloatType()
    {
        $this->assertInstanceOf(
                'Chippyash\Type\Number\FloatType',
                $this->sut->div(2, 3.4));
        $this->assertInstanceOf(
                'Chippyash\Type\Number\FloatType',
                $this->sut->div(3.4, 2));
    }

    public function testDivIntTypeAndFloatReturnsFloatType()
    {
        $this->assertInstanceOf(
                'Chippyash\Type\Number\FloatType',
                $this->sut->div(new IntType(2), 3.4));
        $this->assertInstanceOf(
                'Chippyash\Type\Number\FloatType',
                $this->sut->div(3.4, new IntType(2)));
    }

    public function testDivTwoFloatsReturnsFloatType()
    {
        $this->assertInstanceOf(
                'Chippyash\Type\Number\FloatType',
                $this->sut->div(2.6, -3.067));
    }

    public function testDivTwoFloatTypesReturnsFloatType()
    {
        $this->assertInstanceOf(
                'Chippyash\Type\Number\FloatType',
                $this->sut->div(new FloatType(2), new FloatType(3)));
        $this->assertInstanceOf(
                'Chippyash\Type\Number\FloatType',
                $this->sut->div(new FloatType(2.6), new FloatType(-3.067)));
    }

    public function testDivFloatTypeAndFloatReturnsFloatType()
    {
        $this->assertInstanceOf(
                'Chippyash\Type\Number\FloatType',
                $this->sut->div(new FloatType(2), 3.4));
        $this->assertInstanceOf(
                'Chippyash\Type\Number\FloatType',
                $this->sut->div(3.4, new FloatType(2)));
    }

    public function testDivFloatTypeAndFloatTypeReturnsFloatType()
    {
        $this->assertInstanceOf(
                'Chippyash\Type\Number\FloatType',
                $this->sut->div(new FloatType(2), new FloatType(3.4)));
        $this->assertInstanceOf(
                'Chippyash\Type\Number\FloatType',
                $this->sut->div(new FloatType(3.4), new FloatType(2)));
    }

    public function testDivFloatTypeAndIntReturnsFloatType()
    {
        $this->assertInstanceOf(
                'Chippyash\Type\Number\FloatType',
                $this->sut->div(2, new FloatType(3.4)));
        $this->assertInstanceOf(
                'Chippyash\Type\Number\FloatType',
                $this->sut->div(new FloatType(3.4), 2));
    }

    public function testDivFloatTypeAndIntTypeReturnsFloatType()
    {
        $this->assertInstanceOf(
                'Chippyash\Type\Number\FloatType',
                $this->sut->div(new IntType(2), new FloatType(3.4)));
        $this->assertInstanceOf(
                'Chippyash\Type\Number\FloatType',
                $this->sut->div(new FloatType(3.4), new IntType(2)));
    }

    public function testDivTwoWholeFloatTypesReturnsRationalType()
    {
        $this->assertInstanceOf(
                'Chippyash\Type\Number\Rational\RationalType',
                $this->sut->div(new WholeIntType(2), new WholeIntType(5)));
    }

    public function testDivWholeIntTypeAndFloatTypeReturnsFloatType()
    {
        $this->assertInstanceOf(
                'Chippyash\Type\Number\FloatType',
                $this->sut->div(new WholeIntType(2), new FloatType(5.5)));
        $this->assertInstanceOf(
                'Chippyash\Type\Number\FloatType',
                $this->sut->div(new FloatType(5.5), new WholeIntType(2)));
    }

    public function testDivWholeIntTypeAndFloatReturnsFloatType()
    {
        $this->assertInstanceOf(
                'Chippyash\Type\Number\FloatType',
                $this->sut->div(new WholeIntType(2), 5.5));
        $this->assertInstanceOf(
                'Chippyash\Type\Number\FloatType',
                $this->sut->div(5.5, new WholeIntType(2)));
    }

    public function testDivTwoNaturalIntTypesReturnsRationalType()
    {
        $this->assertInstanceOf(
                'Chippyash\Type\Number\Rational\RationalType',
                $this->sut->div(new NaturalIntType(2), new NaturalIntType(5)));
    }

    public function testDivNaturalIntTypeAndFloatReturnsRationalType()
    {
        $this->assertInstanceOf(
                'Chippyash\Type\Number\Rational\RationalType',
                $this->sut->div(new NaturalIntType(2), 5));
        $this->assertInstanceOf(
                'Chippyash\Type\Number\Rational\RationalType',
                $this->sut->div(5, new NaturalIntType(2)));
    }

    public function testDivNaturalIntTypeAndFloatTypeReturnsFloatType()
    {
        $this->assertInstanceOf(
                'Chippyash\Type\Number\FloatType',
                $this->sut->div(new NaturalIntType(2), new FloatType(5)));
        $this->assertInstanceOf(
                'Chippyash\Type\Number\FloatType',
                $this->sut->div(new FloatType(5), new NaturalIntType(2)));
    }

    public function testDivNaturalIntTypeAndWholeIntReturnsRationalType()
    {
        $this->assertInstanceOf(
                'Chippyash\Type\Number\Rational\RationalType',
                $this->sut->div(new NaturalIntType(2), new WholeIntType(5)));
    }

    public function testDivWholeIntTypeAndNaturalIntTypeReturnsRationalType()
    {
        $this->assertInstanceOf(
                'Chippyash\Type\Number\Rational\RationalType',
                $this->sut->div(new WholeIntType(5), new NaturalIntType(2)));
    }

    public function testDivRationalTypeAndIntReturnsRationalType()
    {
        $this->assertInstanceOf(
                'Chippyash\Type\Number\Rational\RationalType',
                $this->sut->div(RationalTypeFactory::create(1,5), 2));
        $this->assertInstanceOf(
                'Chippyash\Type\Number\Rational\RationalType',
                $this->sut->div(2, RationalTypeFactory::create(1,5)));

    }

    public function testDivRationalTypeAndFloatTypeReturnsRationalType()
    {
        $this->assertInstanceOf(
                'Chippyash\Type\Number\Rational\RationalType',
                $this->sut->div(RationalTypeFactory::create(1,5), new FloatType(2)));
        $this->assertInstanceOf(
                'Chippyash\Type\Number\Rational\RationalType',
                $this->sut->div(new FloatType(2), RationalTypeFactory::create(1,5)));

    }

    public function testDivRationalTypeAndWholeIntTypeReturnsRationalType()
    {
        $this->assertInstanceOf(
                'Chippyash\Type\Number\Rational\RationalType',
                $this->sut->div(RationalTypeFactory::create(1,5), new WholeIntType(2)));
        $this->assertInstanceOf(
                'Chippyash\Type\Number\Rational\RationalType',
                $this->sut->div(new WholeIntType(2), RationalTypeFactory::create(1,5)));

    }

    public function testDivRationalTypeAndNaturalIntTypeReturnsRationalType()
    {
        $this->assertInstanceOf(
                'Chippyash\Type\Number\Rational\RationalType',
                $this->sut->div(RationalTypeFactory::create(1,5), new NaturalIntType(2)));
        $this->assertInstanceOf(
                'Chippyash\Type\Number\Rational\RationalType',
                $this->sut->div(new NaturalIntType(2), RationalTypeFactory::create(1,5)));

    }

    public function testDivRationalTypeAndFloatReturnsRationalType()
    {
        $this->assertInstanceOf(
                'Chippyash\Type\Number\Rational\RationalType',
                $this->sut->div(RationalTypeFactory::create(1,5), 2.6));
        $this->assertInstanceOf(
                'Chippyash\Type\Number\Rational\RationalType',
                $this->sut->div(2.6, RationalTypeFactory::create(1,5)));

    }

    public function testDivTwoComplexNumbersReturnsComplexNumber()
    {
        $this->assertInstanceOf(
                'Chippyash\Type\Number\Complex\ComplexType',
                $this->sut->div(ComplexTypeFactory::create(1,5), ComplexTypeFactory::create(5,1)));
    }

    /**
     * @dataProvider nonComplexNumbers
     * @param numeric $nonComplex
     */
    public function testDivComplexNumbersWithNonComplexNumberReturnsComplexNumber($nonComplex)
    {
        $this->assertInstanceOf(
                'Chippyash\Type\Number\Complex\ComplexType',
                $this->sut->div(ComplexTypeFactory::create(1,5), $nonComplex));
    }

    /**
     * @dataProvider nonComplexNumbers
     * @param numeric $nonComplex
     */
    public function testDivNonComplexNumbersWithComplexNumberThrowsException($nonComplex)
    {
        $this->assertInstanceOf(
                'Chippyash\Type\Number\Complex\ComplexType',
                $this->sut->div($nonComplex, ComplexTypeFactory::create(1,5)));
    }
    public function nonComplexNumbers()
    {
        return [
//            [2],
//            [-2.4],
//            [new FloatType(2)],
//            [new FloatType(2.6)],
            [RationalTypeFactory::create(2,5)],
//            [new WholeIntType(3)],
//            [new NaturalIntType(6)],
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
        $this->assertNotEquals($a, $b);
    }

    public function testDivisionIsNotAssociative()
    {
        $a = 12;
        $b = 3;
        $c = 5;
        //a/(b/c) != (a/b)/c
        $r1 = $this->sut->div($a, $this->sut->div($b, $c));
        $r2 = $this->sut->div($this->sut->div($a, $b), $c);

        $this->assertNotEquals($r1, $r2);
    }
}
