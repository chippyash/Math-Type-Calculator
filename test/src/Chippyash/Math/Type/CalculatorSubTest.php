<?php
namespace Chippyash\Test\Math\Type;

use Chippyash\Math\Type\Calculator;
use Chippyash\Type\Number\IntType;
use Chippyash\Type\Number\WholeIntType;
use Chippyash\Type\Number\NaturalIntType;
use Chippyash\Type\Number\FloatType;
use Chippyash\Type\Number\Rational\RationalTypeFactory;
use Chippyash\Type\Number\Complex\ComplexTypeFactory;

/**
 *
 */
class CalculatorSubTest extends \PHPUnit_Framework_TestCase
{
    protected $object;

    public function setUp()
    {
        $this->object = new Calculator();
    }

    public function testSubTwoIntsReturnsIntType()
    {
        $this->assertInstanceOf(
                'Chippyash\Type\Number\IntType',
                $this->object->sub(2, 3));
    }

    public function testSubIntAndFloatReturnsFloatType()
    {
        $this->assertInstanceOf(
                'Chippyash\Type\Number\FloatType',
                $this->object->sub(2, 3.4));
        $this->assertInstanceOf(
                'Chippyash\Type\Number\FloatType',
                $this->object->sub(3.4, 2));
    }

    public function testSubTwoFloatsReturnsFloatType()
    {
        $this->assertInstanceOf(
                'Chippyash\Type\Number\FloatType',
                $this->object->sub(2.6, -3.067));
    }

    public function testSubTwoIntTypesReturnsIntType()
    {
        $this->assertInstanceOf(
                'Chippyash\Type\Number\IntType',
                $this->object->sub(new IntType(2), new IntType(3)));
    }

    public function testSubIntTypeAndFloatReturnsFloatType()
    {
        $this->assertInstanceOf(
                'Chippyash\Type\Number\FloatType',
                $this->object->sub(new IntType(2), 3.4));
        $this->assertInstanceOf(
                'Chippyash\Type\Number\FloatType',
                $this->object->sub(3.4, new IntType(2)));
    }

    public function testSubIntTypeAndFloatTypeReturnsFloatType()
    {
        $this->assertInstanceOf(
                'Chippyash\Type\Number\FloatType',
                $this->object->sub(new IntType(2), new FloatType(3.4)));
        $this->assertInstanceOf(
                'Chippyash\Type\Number\FloatType',
                $this->object->sub(new FloatType(3.4), new IntType(2)));
    }

    public function testSubTwoFloatTypesReturnsFloatType()
    {
        $this->assertInstanceOf(
                'Chippyash\Type\Number\FloatType',
                $this->object->sub(new FloatType(2.6), new FloatType(-3.067)));
    }

    public function testSubFloatTypeAndIntReturnsFloatType()
    {
        $this->assertInstanceOf(
                'Chippyash\Type\Number\FloatType',
                $this->object->sub(2, new FloatType(3.4)));
        $this->assertInstanceOf(
                'Chippyash\Type\Number\FloatType',
                $this->object->sub(new FloatType(3.4), 2));
    }

    public function testSubTwoWholeIntTypesReturnsWholeIntType()
    {
        $this->assertInstanceOf(
                'Chippyash\Type\Number\WholeIntType',
                $this->object->sub(new WholeIntType(2), new WholeIntType(1)));
    }

    public function testSubWholeIntTypeAndIntReturnsWholeIntType()
    {
        $this->assertInstanceOf(
                'Chippyash\Type\Number\WholeIntType',
                $this->object->sub(new WholeIntType(2), 1));
        $this->assertInstanceOf(
                'Chippyash\Type\Number\WholeIntType',
                $this->object->sub(5, new WholeIntType(2)));
    }

    public function testSubWholeIntTypeAndIntTypeReturnsWholeIntType()
    {
        $this->assertInstanceOf(
                'Chippyash\Type\Number\WholeIntType',
                $this->object->sub(new WholeIntType(2), new IntType(1)));
        $this->assertInstanceOf(
                'Chippyash\Type\Number\WholeIntType',
                $this->object->sub(new IntType(5), new WholeIntType(2)));
    }

    public function testSubWholeIntTypeAndFloatTypeReturnsFloatType()
    {
        $this->assertInstanceOf(
                'Chippyash\Type\Number\FloatType',
                $this->object->sub(new WholeIntType(2), new FloatType(5.5)));
        $this->assertInstanceOf(
                'Chippyash\Type\Number\FloatType',
                $this->object->sub(new FloatType(5.5), new WholeIntType(2)));
    }

    public function testSubWholeIntTypeAndFloatReturnsFloatType()
    {
        $this->assertInstanceOf(
                'Chippyash\Type\Number\FloatType',
                $this->object->sub(new WholeIntType(2), 5.5));
        $this->assertInstanceOf(
                'Chippyash\Type\Number\FloatType',
                $this->object->sub(5.5, new WholeIntType(2)));
    }

    public function testSubTwoNaturalIntTypesReturnsNaturalIntType()
    {
        $this->assertInstanceOf(
                'Chippyash\Type\Number\NaturalIntType',
                $this->object->sub(new NaturalIntType(2), new NaturalIntType(1)));
    }

    public function testSubNaturalIntTypeAndIntReturnsNaturalIntType()
    {
        $this->assertInstanceOf(
                'Chippyash\Type\Number\NaturalIntType',
                $this->object->sub(new NaturalIntType(5), 2));
        $this->assertInstanceOf(
                'Chippyash\Type\Number\NaturalIntType',
                $this->object->sub(5, new NaturalIntType(2)));
    }

    public function testSubNaturalIntTypeAndIntTypeReturnsNaturalIntType()
    {
        $this->assertInstanceOf(
                'Chippyash\Type\Number\NaturalIntType',
                $this->object->sub(new NaturalIntType(5), new IntType(2)));
        $this->assertInstanceOf(
                'Chippyash\Type\Number\NaturalIntType',
                $this->object->sub(new IntType(5), new NaturalIntType(2)));
    }

    public function testSubNaturalIntTypeAndFloatTypeReturnsFloatType()
    {
        $this->assertInstanceOf(
                'Chippyash\Type\Number\FloatType',
                $this->object->sub(new NaturalIntType(2), new FloatType(5.5)));
        $this->assertInstanceOf(
                'Chippyash\Type\Number\FloatType',
                $this->object->sub(new FloatType(5.5), new NaturalIntType(2)));
    }

    public function testSubNaturalIntTypeAndFloatReturnsFloatType()
    {
        $this->assertInstanceOf(
                'Chippyash\Type\Number\FloatType',
                $this->object->sub(new NaturalIntType(2), 5.5));
        $this->assertInstanceOf(
                'Chippyash\Type\Number\FloatType',
                $this->object->sub(5.5, new NaturalIntType(2)));
    }

    public function testSubWholeIntTypeAndNaturalIntReturnsWholeIntType()
    {
        $this->assertInstanceOf(
                'Chippyash\Type\Number\WholeIntType',
                $this->object->sub(new WholeIntType(5), new NaturalIntType(2)));
        $this->assertInstanceOf(
                'Chippyash\Type\Number\WholeIntType',
                $this->object->sub(new NaturalIntType(2), new WholeIntType(1)));
    }

    public function testSubRationalTypeAndIntReturnsRationalType()
    {
        $this->assertInstanceOf(
                'Chippyash\Type\Number\Rational\RationalType',
                $this->object->sub(RationalTypeFactory::create(1,5), 2));
        $this->assertInstanceOf(
                'Chippyash\Type\Number\Rational\RationalType',
                $this->object->sub(2, RationalTypeFactory::create(1,5)));

    }

    public function testSubRationalTypeAndIntTypeReturnsRationalType()
    {
        $this->assertInstanceOf(
                'Chippyash\Type\Number\Rational\RationalType',
                $this->object->sub(RationalTypeFactory::create(1,5), new IntType(2)));
        $this->assertInstanceOf(
                'Chippyash\Type\Number\Rational\RationalType',
                $this->object->sub(new IntType(2), RationalTypeFactory::create(1,5)));

    }

    public function testSubRationalTypeAndWholeIntTypeReturnsRationalType()
    {
        $this->assertInstanceOf(
                'Chippyash\Type\Number\Rational\RationalType',
                $this->object->sub(RationalTypeFactory::create(1,5), new WholeIntType(2)));
        $this->assertInstanceOf(
                'Chippyash\Type\Number\Rational\RationalType',
                $this->object->sub(new WholeIntType(2), RationalTypeFactory::create(1,5)));

    }

    public function testSubRationalTypeAndNaturalIntTypeReturnsRationalType()
    {
        $this->assertInstanceOf(
                'Chippyash\Type\Number\Rational\RationalType',
                $this->object->sub(RationalTypeFactory::create(1,5), new NaturalIntType(2)));
        $this->assertInstanceOf(
                'Chippyash\Type\Number\Rational\RationalType',
                $this->object->sub(new NaturalIntType(2), RationalTypeFactory::create(1,5)));

    }

    public function testSubRationalTypeAndFloatReturnsRationalType()
    {
        $this->assertInstanceOf(
                'Chippyash\Type\Number\Rational\RationalType',
                $this->object->sub(RationalTypeFactory::create(1,5), 2.6));
        $this->assertInstanceOf(
                'Chippyash\Type\Number\Rational\RationalType',
                $this->object->sub(2.6, RationalTypeFactory::create(1,5)));

    }

    public function testSubRationalTypeAndFloatTypeReturnsRationalType()
    {
        $this->assertInstanceOf(
                'Chippyash\Type\Number\Rational\RationalType',
                $this->object->sub(RationalTypeFactory::create(1,5), new FloatType(2.6)));
        $this->assertInstanceOf(
                'Chippyash\Type\Number\Rational\RationalType',
                $this->object->sub(new FloatType(2.6), RationalTypeFactory::create(1,5)));

    }

    public function testSubTwoComplexNumbersReturnsComplexNumber()
    {
        $this->assertInstanceOf(
                'Chippyash\Type\Number\Complex\ComplexType',
                $this->object->sub(ComplexTypeFactory::create(1,5), ComplexTypeFactory::create(5,1)));
    }

    /**
     * @dataProvider nonComplexNumbers
     * @param numeric $nonComplex
     */
    public function testSubComplexNumbersWithNonComplexNumberReturnsComplexNumber($nonComplex)
    {
        $this->assertInstanceOf(
                'Chippyash\Type\Number\Complex\ComplexType',
                $this->object->sub(ComplexTypeFactory::create(1,5), $nonComplex));
    }

    /**
     * @dataProvider nonComplexNumbers
     * @param numeric $nonComplex
     */
    public function testSubNonComplexNumbersWithComplexNumberThrowsException($nonComplex)
    {
        $this->assertInstanceOf(
                'Chippyash\Type\Number\Complex\ComplexType',
                $this->object->sub($nonComplex, ComplexTypeFactory::create(1,5)));
    }
    public function nonComplexNumbers()
    {
        return [
            [2],
            [-2.4],
            [new FloatType(2)],
            [new FloatType(2.6)],
            [RationalTypeFactory::create(1,5)],
            [new WholeIntType(3)],
            [new NaturalIntType(6)],
        ];
    }

    public function testSubtractionIsNotCommutative()
    {
        $a = $this->object->sub(12, 3);
        $b = $this->object->sub(3, 12);
        //a-b != b-a
        $this->assertNotEquals($a, $b);
    }

    public function testSubtractionIsNotAssociative()
    {
        $a = 12;
        $b = 3;
        $c = 5;
        //a-(b-c) != (a-b)-c
        $r1 = $this->object->sub($a, $this->object->sub($b, $c));
        $r2 = $this->object->sub($this->object->sub($a, $b), $c);

        $this->assertNotEquals($r1, $r2);
    }
}
