<?php
namespace chippyash\Test\Math\Type;

use chippyash\Math\Type\Calculator;
use chippyash\Type\Number\IntType;
use chippyash\Type\Number\WholeIntType;
use chippyash\Type\Number\NaturalIntType;
use chippyash\Type\Number\FloatType;
use chippyash\Type\Number\Rational\RationalTypeFactory;
use chippyash\Type\Number\Complex\ComplexTypeFactory;

/**
 *
 */
class CalculatorAddTest extends \PHPUnit_Framework_TestCase
{
    protected $object;

    public function setUp()
    {
        $this->object = new Calculator();
    }

    public function testAddTwoIntsReturnsIntType()
    {
        $this->assertInstanceOf(
                'chippyash\Type\Number\IntType',
                $this->object->add(2, 3));
    }

    public function testAddIntAndFloatReturnsFloatType()
    {
        $this->assertInstanceOf(
                'chippyash\Type\Number\FloatType',
                $this->object->add(2, 3.4));
        $this->assertInstanceOf(
                'chippyash\Type\Number\FloatType',
                $this->object->add(3.4, 2));
    }

    public function testAddTwoFloatsReturnsFloatType()
    {
        $this->assertInstanceOf(
                'chippyash\Type\Number\FloatType',
                $this->object->add(2.6, -3.067));
    }

    public function testAddTwoIntTypesReturnsIntType()
    {
        $this->assertInstanceOf(
                'chippyash\Type\Number\IntType',
                $this->object->add(new IntType(2), new IntType(3)));
    }

    public function testAddIntTypeAndFloatReturnsFloatType()
    {
        $this->assertInstanceOf(
                'chippyash\Type\Number\FloatType',
                $this->object->add(new IntType(2), 3.4));
        $this->assertInstanceOf(
                'chippyash\Type\Number\FloatType',
                $this->object->add(3.4, new IntType(2)));
    }

    public function testAddIntTypeAndFloatTypeReturnsFloatType()
    {
        $this->assertInstanceOf(
                'chippyash\Type\Number\FloatType',
                $this->object->add(new IntType(2), new FloatType(3.4)));
        $this->assertInstanceOf(
                'chippyash\Type\Number\FloatType',
                $this->object->add(new FloatType(3.4), new IntType(2)));
    }

    public function testAddTwoFloatTypesReturnsFloatType()
    {
        $this->assertInstanceOf(
                'chippyash\Type\Number\FloatType',
                $this->object->add(new FloatType(2.6), new FloatType(-3.067)));
    }

    public function testAddFloatTypeAndIntReturnsFloatType()
    {
        $this->assertInstanceOf(
                'chippyash\Type\Number\FloatType',
                $this->object->add(2, new FloatType(3.4)));
        $this->assertInstanceOf(
                'chippyash\Type\Number\FloatType',
                $this->object->add(new FloatType(3.4), 2));
    }

    public function testAddTwoWholeIntTypesReturnsWholeIntType()
    {
        $this->assertInstanceOf(
                'chippyash\Type\Number\WholeIntType',
                $this->object->add(new WholeIntType(2), new WholeIntType(5)));
    }

    public function testAddWholeIntTypeAndIntReturnsWholeIntType()
    {
        $this->assertInstanceOf(
                'chippyash\Type\Number\WholeIntType',
                $this->object->add(new WholeIntType(2), 5));
        $this->assertInstanceOf(
                'chippyash\Type\Number\WholeIntType',
                $this->object->add(5, new WholeIntType(2)));
    }

    public function testAddWholeIntTypeAndIntTypeReturnsWholeIntType()
    {
        $this->assertInstanceOf(
                'chippyash\Type\Number\WholeIntType',
                $this->object->add(new WholeIntType(2), new IntType(5)));
        $this->assertInstanceOf(
                'chippyash\Type\Number\WholeIntType',
                $this->object->add(new IntType(5), new WholeIntType(2)));
    }

    public function testAddWholeIntTypeAndFloatTypeReturnsFloatType()
    {
        $this->assertInstanceOf(
                'chippyash\Type\Number\FloatType',
                $this->object->add(new WholeIntType(2), new FloatType(5.5)));
        $this->assertInstanceOf(
                'chippyash\Type\Number\FloatType',
                $this->object->add(new FloatType(5.5), new WholeIntType(2)));
    }

    public function testAddWholeIntTypeAndFloatReturnsFloatType()
    {
        $this->assertInstanceOf(
                'chippyash\Type\Number\FloatType',
                $this->object->add(new WholeIntType(2), 5.5));
        $this->assertInstanceOf(
                'chippyash\Type\Number\FloatType',
                $this->object->add(5.5, new WholeIntType(2)));
    }

    public function testAddTwoNaturalIntTypesReturnsNaturalIntType()
    {
        $this->assertInstanceOf(
                'chippyash\Type\Number\NaturalIntType',
                $this->object->add(new NaturalIntType(2), new NaturalIntType(5)));
    }

    public function testAddNaturalIntTypeAndIntReturnsNaturalIntType()
    {
        $this->assertInstanceOf(
                'chippyash\Type\Number\NaturalIntType',
                $this->object->add(new NaturalIntType(2), 5));
        $this->assertInstanceOf(
                'chippyash\Type\Number\NaturalIntType',
                $this->object->add(5, new NaturalIntType(2)));
    }

    public function testAddNaturalIntTypeAndIntTypeReturnsNaturalIntType()
    {
        $this->assertInstanceOf(
                'chippyash\Type\Number\NaturalIntType',
                $this->object->add(new NaturalIntType(2), new IntType(5)));
        $this->assertInstanceOf(
                'chippyash\Type\Number\NaturalIntType',
                $this->object->add(new IntType(5), new NaturalIntType(2)));
    }

    public function testAddNaturalIntTypeAndFloatTypeReturnsFloatType()
    {
        $this->assertInstanceOf(
                'chippyash\Type\Number\FloatType',
                $this->object->add(new NaturalIntType(2), new FloatType(5.5)));
        $this->assertInstanceOf(
                'chippyash\Type\Number\FloatType',
                $this->object->add(new FloatType(5.5), new NaturalIntType(2)));
    }

    public function testAddNaturalIntTypeAndFloatReturnsFloatType()
    {
        $this->assertInstanceOf(
                'chippyash\Type\Number\FloatType',
                $this->object->add(new NaturalIntType(2), 5.5));
        $this->assertInstanceOf(
                'chippyash\Type\Number\FloatType',
                $this->object->add(5.5, new NaturalIntType(2)));
    }

    public function testAddWholeIntTypeAndNaturalIntReturnsWholeIntType()
    {
        $this->assertInstanceOf(
                'chippyash\Type\Number\WholeIntType',
                $this->object->add(new WholeIntType(5), new NaturalIntType(2)));
        $this->assertInstanceOf(
                'chippyash\Type\Number\WholeIntType',
                $this->object->add(new NaturalIntType(2), new WholeIntType(5)));
    }

    public function testAddRationalTypeAndIntReturnsRationalType()
    {
        $this->assertInstanceOf(
                'chippyash\Type\Number\Rational\RationalType',
                $this->object->add(RationalTypeFactory::create(1,5), 2));
        $this->assertInstanceOf(
                'chippyash\Type\Number\Rational\RationalType',
                $this->object->add(2, RationalTypeFactory::create(1,5)));

    }

    public function testAddRationalTypeAndIntTypeReturnsRationalType()
    {
        $this->assertInstanceOf(
                'chippyash\Type\Number\Rational\RationalType',
                $this->object->add(RationalTypeFactory::create(1,5), new IntType(2)));
        $this->assertInstanceOf(
                'chippyash\Type\Number\Rational\RationalType',
                $this->object->add(new IntType(2), RationalTypeFactory::create(1,5)));

    }

    public function testAddRationalTypeAndWholeIntTypeReturnsRationalType()
    {
        $this->assertInstanceOf(
                'chippyash\Type\Number\Rational\RationalType',
                $this->object->add(RationalTypeFactory::create(1,5), new WholeIntType(2)));
        $this->assertInstanceOf(
                'chippyash\Type\Number\Rational\RationalType',
                $this->object->add(new WholeIntType(2), RationalTypeFactory::create(1,5)));

    }

    public function testAddRationalTypeAndNaturalIntTypeReturnsRationalType()
    {
        $this->assertInstanceOf(
                'chippyash\Type\Number\Rational\RationalType',
                $this->object->add(RationalTypeFactory::create(1,5), new NaturalIntType(2)));
        $this->assertInstanceOf(
                'chippyash\Type\Number\Rational\RationalType',
                $this->object->add(new NaturalIntType(2), RationalTypeFactory::create(1,5)));

    }

    public function testAddRationalTypeAndFloatReturnsRationalType()
    {
        $this->assertInstanceOf(
                'chippyash\Type\Number\Rational\RationalType',
                $this->object->add(RationalTypeFactory::create(1,5), 2.6));
        $this->assertInstanceOf(
                'chippyash\Type\Number\Rational\RationalType',
                $this->object->add(2.6, RationalTypeFactory::create(1,5)));

    }

    public function testAddRationalTypeAndFloatTypeReturnsRationalType()
    {
        $this->assertInstanceOf(
                'chippyash\Type\Number\Rational\RationalType',
                $this->object->add(RationalTypeFactory::create(1,5), new FloatType(2.6)));
        $this->assertInstanceOf(
                'chippyash\Type\Number\Rational\RationalType',
                $this->object->add(new FloatType(2.6), RationalTypeFactory::create(1,5)));

    }

    public function testAddTwoComplexNumbersReturnsComplexNumber()
    {
        $this->assertInstanceOf(
                'chippyash\Type\Number\Complex\ComplexType',
                $this->object->add(ComplexTypeFactory::create(1,5), ComplexTypeFactory::create(5,1)));
    }

    /**
     * @expectedException BadMethodCallException
     * @dataProvider badComplexCombinations
     */
    public function testAddComplexNumbersWithNonComplexNumberThrowsException($nonComplex)
    {
        $this->assertInstanceOf(
                'chippyash\Type\Number\Complex\ComplexType',
                $this->object->add(ComplexTypeFactory::create(1,5), $nonComplex));
    }

    /**
     * @expectedException BadMethodCallException
     * @dataProvider badComplexCombinations
     */
    public function testAddNonComplexNumbersWithComplexNumberThrowsException($nonComplex)
    {
        $this->assertInstanceOf(
                'chippyash\Type\Number\Complex\ComplexType',
                $this->object->add($nonComplex, ComplexTypeFactory::create(1,5)));
    }

    public function badComplexCombinations()
    {
        return [
            [2],
            [-2.4],
            [new IntType(2)],
            [new FloatType(2.6)],
            [RationalTypeFactory::create(1,5)],
            [new WholeIntType(3)],
            [new NaturalIntType(6)],
        ];
    }

    public function testAdditionIsCommutative()
    {
        $a = $this->object->add(12, 3);
        $b = $this->object->add(3, 12);
        //a+b = b+a
        $this->assertEquals($a, $b);
    }

    public function testAdditionIsAssociative()
    {
        $a = 12;
        $b = 3;
        $c = 5;
        //a+(b+c) = (a+b)_c
        $r1 = $this->object->add($a, $this->object->add($b, $c));
        $r2 = $this->object->add($this->object->add($a, $b), $c);

        $this->assertEquals($r1, $r2);
    }

    /**
     * @dataProvider correctResults
     * @param mixed $a
     * @param mixed $b
     * @param mixed $r
     */
    public function testAdditionGivesCorrectResults($a, $b, $r)
    {
        $this->assertEquals($r, $this->object->add($a, $b));
    }

    public function correctResults()
    {
        return [
            [1,2,new IntType(3)],
            [new IntType(1),2,new IntType(3)],
            [1,new IntType(2),new IntType(3)],
            [new IntType(1),new IntType(2),new IntType(3)],
            [2.0,3.0,new FloatType(5.0)],
            [new FloatType(2.0),3.0,new FloatType(5.0)],
            [2.0,new FloatType(3.0),new FloatType(5.0)],
            [new FloatType(2.0),new FloatType(3.0),new FloatType(5.0)],
            [new IntType(2),3.0,new FloatType(5.0)],
            [new WholeIntType(2), 3, new WholeIntType(5)],
            [2, new WholeIntType(3), new WholeIntType(5)],
            [new NaturalIntType(2), 3, new NaturalIntType(5)],
            [2, new NaturalIntType(3), new NaturalIntType(5)],
            [RationalTypeFactory::create(4),RationalTypeFactory::create(4),RationalTypeFactory::create(8)]
        ];
    }
}
