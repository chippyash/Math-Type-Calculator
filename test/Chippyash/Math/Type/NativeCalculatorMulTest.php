<?php
namespace Chippyash\Test\Math\Type;

use Chippyash\Math\Type\Calculator;
use Chippyash\Type\Number\IntType;
use Chippyash\Type\Number\WholeIntType;
use Chippyash\Type\Number\NaturalIntType;
use Chippyash\Type\Number\FloatType;
use Chippyash\Type\Number\Rational\RationalTypeFactory;
use Chippyash\Type\Number\Complex\ComplexTypeFactory;
use Chippyash\Type\RequiredType;

/**
 *
 */
class NativeCalculatorMulTest extends \PHPUnit_Framework_TestCase
{
    protected $object;

    public function setUp()
    {
        RequiredType::getInstance()->set(RequiredType::TYPE_NATIVE);
        $this->object = new Calculator();
    }

    public function testMulTwoIntsReturnsIntType()
    {
        $this->assertInstanceOf(
                'Chippyash\Type\Number\IntType',
                $this->object->mul(2, 3));
    }

    public function testMulIntAndFloatReturnsFloatType()
    {
        $this->assertInstanceOf(
                'Chippyash\Type\Number\FloatType',
                $this->object->mul(2, 3.4));
        $this->assertInstanceOf(
                'Chippyash\Type\Number\FloatType',
                $this->object->mul(3.4, 2));
    }

    public function testMulTwoFloatsReturnsFloatType()
    {
        $this->assertInstanceOf(
                'Chippyash\Type\Number\FloatType',
                $this->object->mul(2.6, -3.067));
    }

    public function testMulTwoIntTypesReturnsIntType()
    {
        $this->assertInstanceOf(
                'Chippyash\Type\Number\IntType',
                $this->object->mul(new IntType(2), new IntType(3)));
    }

    public function testMulIntTypeAndFloatReturnsFloatType()
    {
        $this->assertInstanceOf(
                'Chippyash\Type\Number\FloatType',
                $this->object->mul(new IntType(2), 3.4));
        $this->assertInstanceOf(
                'Chippyash\Type\Number\FloatType',
                $this->object->mul(3.4, new IntType(2)));
    }

    public function testMulIntTypeAndFloatTypeReturnsFloatType()
    {
        $this->assertInstanceOf(
                'Chippyash\Type\Number\FloatType',
                $this->object->mul(new IntType(2), new FloatType(3.4)));
        $this->assertInstanceOf(
                'Chippyash\Type\Number\FloatType',
                $this->object->mul(new FloatType(3.4), new IntType(2)));
    }

    public function testMulTwoFloatTypesReturnsFloatType()
    {
        $this->assertInstanceOf(
                'Chippyash\Type\Number\FloatType',
                $this->object->mul(new FloatType(2.6), new FloatType(-3.067)));
    }

    public function testMulFloatTypeAndIntReturnsFloatType()
    {
        $this->assertInstanceOf(
                'Chippyash\Type\Number\FloatType',
                $this->object->mul(2, new FloatType(3.4)));
        $this->assertInstanceOf(
                'Chippyash\Type\Number\FloatType',
                $this->object->mul(new FloatType(3.4), 2));
    }

    public function testMulTwoWholeIntTypesReturnsWholeIntType()
    {
        $this->assertInstanceOf(
                'Chippyash\Type\Number\WholeIntType',
                $this->object->mul(new WholeIntType(2), new WholeIntType(5)));
    }

    public function testMulWholeIntTypeAndIntReturnsWholeIntType()
    {
        $this->assertInstanceOf(
                'Chippyash\Type\Number\WholeIntType',
                $this->object->mul(new WholeIntType(2), 5));
        $this->assertInstanceOf(
                'Chippyash\Type\Number\WholeIntType',
                $this->object->mul(5, new WholeIntType(2)));
    }

    public function testMulWholeIntTypeAndIntTypeReturnsWholeIntType()
    {
        $this->assertInstanceOf(
                'Chippyash\Type\Number\WholeIntType',
                $this->object->mul(new WholeIntType(2), new IntType(5)));
        $this->assertInstanceOf(
                'Chippyash\Type\Number\WholeIntType',
                $this->object->mul(new IntType(5), new WholeIntType(2)));
    }

    public function testMulWholeIntTypeAndFloatTypeReturnsFloatType()
    {
        $this->assertInstanceOf(
                'Chippyash\Type\Number\FloatType',
                $this->object->mul(new WholeIntType(2), new FloatType(5.5)));
        $this->assertInstanceOf(
                'Chippyash\Type\Number\FloatType',
                $this->object->mul(new FloatType(5.5), new WholeIntType(2)));
    }

    public function testMulWholeIntTypeAndFloatReturnsFloatType()
    {
        $this->assertInstanceOf(
                'Chippyash\Type\Number\FloatType',
                $this->object->mul(new WholeIntType(2), 5.5));
        $this->assertInstanceOf(
                'Chippyash\Type\Number\FloatType',
                $this->object->mul(5.5, new WholeIntType(2)));
    }

    public function testMulTwoNaturalIntTypesReturnsNaturalIntType()
    {
        $this->assertInstanceOf(
                'Chippyash\Type\Number\NaturalIntType',
                $this->object->mul(new NaturalIntType(2), new NaturalIntType(5)));
    }

    public function testMulNaturalIntTypeAndIntReturnsNaturalIntType()
    {
        $this->assertInstanceOf(
                'Chippyash\Type\Number\NaturalIntType',
                $this->object->mul(new NaturalIntType(2), 5));
        $this->assertInstanceOf(
                'Chippyash\Type\Number\NaturalIntType',
                $this->object->mul(5, new NaturalIntType(2)));
    }

    public function testMulNaturalIntTypeAndIntTypeReturnsNaturalIntType()
    {
        $this->assertInstanceOf(
                'Chippyash\Type\Number\NaturalIntType',
                $this->object->mul(new NaturalIntType(2), new IntType(5)));
        $this->assertInstanceOf(
                'Chippyash\Type\Number\NaturalIntType',
                $this->object->mul(new IntType(5), new NaturalIntType(2)));
    }

    public function testMulNaturalIntTypeAndFloatTypeReturnsFloatType()
    {
        $this->assertInstanceOf(
                'Chippyash\Type\Number\FloatType',
                $this->object->mul(new NaturalIntType(2), new FloatType(5.5)));
        $this->assertInstanceOf(
                'Chippyash\Type\Number\FloatType',
                $this->object->mul(new FloatType(5.5), new NaturalIntType(2)));
    }

    public function testMulNaturalIntTypeAndFloatReturnsFloatType()
    {
        $this->assertInstanceOf(
                'Chippyash\Type\Number\FloatType',
                $this->object->mul(new NaturalIntType(2), 5.5));
        $this->assertInstanceOf(
                'Chippyash\Type\Number\FloatType',
                $this->object->mul(5.5, new NaturalIntType(2)));
    }

    public function testMulWholeIntTypeAndNaturalIntReturnsWholeIntType()
    {
        $this->assertInstanceOf(
                'Chippyash\Type\Number\WholeIntType',
                $this->object->mul(new WholeIntType(5), new NaturalIntType(2)));
        $this->assertInstanceOf(
                'Chippyash\Type\Number\WholeIntType',
                $this->object->mul(new NaturalIntType(2), new WholeIntType(5)));
    }

    public function testMulRationalTypeAndIntReturnsRationalType()
    {
        $this->assertInstanceOf(
                'Chippyash\Type\Number\Rational\RationalType',
                $this->object->mul(RationalTypeFactory::create(1,5), 2));
        $this->assertInstanceOf(
                'Chippyash\Type\Number\Rational\RationalType',
                $this->object->mul(2, RationalTypeFactory::create(1,5)));

    }

    public function testMulRationalTypeAndIntTypeReturnsRationalType()
    {
        $this->assertInstanceOf(
                'Chippyash\Type\Number\Rational\RationalType',
                $this->object->mul(RationalTypeFactory::create(1,5), new IntType(2)));
        $this->assertInstanceOf(
                'Chippyash\Type\Number\Rational\RationalType',
                $this->object->mul(new IntType(2), RationalTypeFactory::create(1,5)));

    }

    public function testMulRationalTypeAndWholeIntTypeReturnsRationalType()
    {
        $this->assertInstanceOf(
                'Chippyash\Type\Number\Rational\RationalType',
                $this->object->mul(RationalTypeFactory::create(1,5), new WholeIntType(2)));
        $this->assertInstanceOf(
                'Chippyash\Type\Number\Rational\RationalType',
                $this->object->mul(new WholeIntType(2), RationalTypeFactory::create(1,5)));

    }

    public function testMulRationalTypeAndNaturalIntTypeReturnsRationalType()
    {
        $this->assertInstanceOf(
                'Chippyash\Type\Number\Rational\RationalType',
                $this->object->mul(RationalTypeFactory::create(1,5), new NaturalIntType(2)));
        $this->assertInstanceOf(
                'Chippyash\Type\Number\Rational\RationalType',
                $this->object->mul(new NaturalIntType(2), RationalTypeFactory::create(1,5)));

    }

    public function testMulRationalTypeAndFloatReturnsRationalType()
    {
        $this->assertInstanceOf(
                'Chippyash\Type\Number\Rational\RationalType',
                $this->object->mul(RationalTypeFactory::create(1,5), 2.6));
        $this->assertInstanceOf(
                'Chippyash\Type\Number\Rational\RationalType',
                $this->object->mul(2.6, RationalTypeFactory::create(1,5)));

    }

    public function testMulRationalTypeAndFloatTypeReturnsRationalType()
    {
        $this->assertInstanceOf(
                'Chippyash\Type\Number\Rational\RationalType',
                $this->object->mul(RationalTypeFactory::create(1,5), new FloatType(2.6)));
        $this->assertInstanceOf(
                'Chippyash\Type\Number\Rational\RationalType',
                $this->object->mul(new FloatType(2.6), RationalTypeFactory::create(1,5)));

    }

    public function testMulTwoComplexNumbersReturnsComplexNumber()
    {
        $this->assertInstanceOf(
                'Chippyash\Type\Number\Complex\ComplexType',
                $this->object->mul(ComplexTypeFactory::create(1,5), ComplexTypeFactory::create(5,1)));
    }

    /**
     * @dataProvider nonComplexNumbers
     * @param numeric $nonComplex
     */
    public function testMulComplexNumbersWithNonComplexNumberReturnsComplexNumber($nonComplex)
    {
        $this->assertInstanceOf(
                'Chippyash\Type\Number\Complex\ComplexType',
                $this->object->mul(ComplexTypeFactory::create(1,5), $nonComplex));
    }

    /**
     * @dataProvider nonComplexNumbers
     * @param numeric $nonComplex
     */
    public function testMulNonComplexNumbersWithComplexNumberThrowsException($nonComplex)
    {
        $this->assertInstanceOf(
                'Chippyash\Type\Number\Complex\ComplexType',
                $this->object->mul($nonComplex, ComplexTypeFactory::create(1,5)));
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


    public function testMultiplicationIsCommutative()
    {
        //a+b = b+a
        $a = $this->object->mul(12, 3);
        $b = $this->object->mul(3, 12);
        $this->assertEquals($a, $b);
    }

    public function testMultiplicationIsAssociative()
    {
        $a = 12;
        $b = 3;
        $c = 5;
        //a+(b+c) = (a+b)+c
        $r1 = $this->object->mul($a, $this->object->mul($b, $c));
        $r2 = $this->object->mul($this->object->mul($a, $b), $c);

        $this->assertEquals($r1, $r2);
    }

    public function testMultiplicationIsDistributiveOverAddition()
    {
        $a = 12;
        $b = 3;
        $c = 5;
        //a(b+c) == ab + ac
        $r1 = $this->object->mul($a, $this->object->add($b, $c));
        $r2 = $this->object->add($this->object->mul($a, $b),$this->object->mul($a, $c));

        $this->assertEquals($r1, $r2);
    }

    public function testMultiplicationIsDistributiveOverSubtraction()
    {
        $a = 12;
        $b = 3;
        $c = 5;
        //a(b-c) == ab - ac
        $r1 = $this->object->mul($a, $this->object->sub($b, $c));
        $r2 = $this->object->sub($this->object->mul($a, $b),$this->object->mul($a, $c));

        $this->assertEquals($r1, $r2);
    }

}
