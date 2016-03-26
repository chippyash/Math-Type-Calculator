<?php
namespace chippyash\Test\Math\Type;

use chippyash\Math\Type\Calculator;
use chippyash\Type\Number\IntType;
use chippyash\Type\Number\WholeIntType;
use chippyash\Type\Number\NaturalIntType;
use chippyash\Type\Number\FloatType;
use chippyash\Type\Number\Rational\RationalTypeFactory;
use chippyash\Type\Number\Complex\ComplexTypeFactory;
<<<<<<< HEAD
use chippyash\Type\TypeFactory;

/**
 * @runTestsInSeparateProcesses
=======

/**
 *
>>>>>>> 1871b7cff507a5c6b124f07bec75cd684a881865
 */
class GmpCalculatorAddTest extends \PHPUnit_Framework_TestCase
{
    /**@+
     * Class definitions for number types
     */
    const GINT_TYPE = 'chippyash\Type\Number\GMPIntType';
    const WINT_TYPE = 'chippyash\Type\Number\WholeIntType';
    const NINT_TYPE = 'chippyash\Type\Number\NaturalIntType';
    const FLOAT_TYPE = 'chippyash\Type\Number\FloatType';
    const GRAT_TYPE = 'chippyash\Type\Number\Rational\GMPRationalType';
    const GCOMP_TYPE = 'chippyash\Type\Number\Complex\GMPComplexType';
    /**@-*/
    
    /**
     * SUT
     * @var chippyash\Math\Type\Calculator
     */
    protected $object;

    public function setUp()
    {
        Calculator::setNumberType(Calculator::TYPE_GMP);
        
        $this->object = new Calculator();
    }

    public function testAddTwoIntsReturnsGmpIntType()
    {
        $this->assertInstanceOf(
                self::GINT_TYPE,
                $this->object->add(2, 3));
    }

    public function testAddIntAndFloatReturnsGmpRationalType()
    {
        $this->assertInstanceOf(
                self::GRAT_TYPE,
                $this->object->add(2, 3.4));
        $this->assertInstanceOf(
                self::GRAT_TYPE,
                $this->object->add(3.4, 2));
    }

    public function testAddTwoFloatsReturnsGmpRationalType()
    {
        $this->assertInstanceOf(
                self::GRAT_TYPE,
                $this->object->add(2.6, -3.067));
    }

    public function testAddTwoIntTypesReturnsGmpIntType()
    {
        $this->assertInstanceOf(
                self::GINT_TYPE,
                $this->object->add(new IntType(2), new IntType(3)));
    }

    public function testAddIntTypeAndFloatReturnsGmpRationalType()
    {
        $this->assertInstanceOf(
                self::GRAT_TYPE,
                $this->object->add(new IntType(2), 3.4));
        $this->assertInstanceOf(
                self::GRAT_TYPE,
                $this->object->add(3.4, new IntType(2)));
    }

    public function testAddIntTypeAndFloatTypeReturnsGmpRationalType()
    {
        $this->assertInstanceOf(
                self::GRAT_TYPE,
                $this->object->add(new IntType(2), new FloatType(3.4)));
        $this->assertInstanceOf(
                self::GRAT_TYPE,
                $this->object->add(new FloatType(3.4), new IntType(2)));
    }

    public function testAddTwoFloatTypesReturnsGmpRationalType()
    {
        $this->assertInstanceOf(
                self::GRAT_TYPE,
                $this->object->add(new FloatType(2.6), new FloatType(-3.067)));
    }

    public function testAddFloatTypeAndIntReturnsGmpRationalType()
    {
        $this->assertInstanceOf(
                self::GRAT_TYPE,
                $this->object->add(2, new FloatType(3.4)));
        $this->assertInstanceOf(
                self::GRAT_TYPE,
                $this->object->add(new FloatType(3.4), 2));
    }

    public function testAddTwoWholeIntTypesReturnsGmpIntType()
    {
        $this->assertInstanceOf(
                self::GINT_TYPE,
                $this->object->add(new WholeIntType(2), new WholeIntType(5)));
    }

    public function testAddWholeIntTypeAndIntReturnsGmpIntType()
    {
        $this->assertInstanceOf(
                self::GINT_TYPE,
                $this->object->add(new WholeIntType(2), 5));
        $this->assertInstanceOf(
                self::GINT_TYPE,
                $this->object->add(5, new WholeIntType(2)));
    }

    public function testAddWholeIntTypeAndIntTypeReturnsGmpIntType()
    {
        $this->assertInstanceOf(
                self::GINT_TYPE,
                $this->object->add(new WholeIntType(2), new IntType(5)));
        $this->assertInstanceOf(
                self::GINT_TYPE,
                $this->object->add(new IntType(5), new WholeIntType(2)));
    }

    public function testAddWholeIntTypeAndFloatTypeReturnsGmpRationalType()
    {
        $this->assertInstanceOf(
                self::GRAT_TYPE,
                $this->object->add(new WholeIntType(2), new FloatType(5.5)));
        $this->assertInstanceOf(
                self::GRAT_TYPE,
                $this->object->add(new FloatType(5.5), new WholeIntType(2)));
    }

    public function testAddWholeIntTypeAndFloatReturnsGmpRationalType()
    {
        $this->assertInstanceOf(
                self::GRAT_TYPE,
                $this->object->add(new WholeIntType(2), 5.5));
        $this->assertInstanceOf(
                self::GRAT_TYPE,
                $this->object->add(5.5, new WholeIntType(2)));
    }

    public function testAddTwoNaturalIntTypesReturnsGmpIntType()
    {
        $this->assertInstanceOf(
                self::GINT_TYPE,
                $this->object->add(new NaturalIntType(2), new NaturalIntType(5)));
    }

    public function testAddNaturalIntTypeAndIntReturnsGmpIntType()
    {
        $this->assertInstanceOf(
                self::GINT_TYPE,
                $this->object->add(new NaturalIntType(2), 5));
        $this->assertInstanceOf(
                self::GINT_TYPE,
                $this->object->add(5, new NaturalIntType(2)));
    }

    public function testAddNaturalIntTypeAndIntTypeReturnsGmpIntType()
    {
        $this->assertInstanceOf(
                self::GINT_TYPE,
                $this->object->add(new NaturalIntType(2), new IntType(5)));
        $this->assertInstanceOf(
                self::GINT_TYPE,
                $this->object->add(new IntType(5), new NaturalIntType(2)));
    }

    public function testAddNaturalIntTypeAndFloatTypeReturnsGmpRationalType()
    {
        $this->assertInstanceOf(
                self::GRAT_TYPE,
                $this->object->add(new NaturalIntType(2), new FloatType(5.5)));
        $this->assertInstanceOf(
                self::GRAT_TYPE,
                $this->object->add(new FloatType(5.5), new NaturalIntType(2)));
    }

    public function testAddNaturalIntTypeAndFloatReturnsGmpRationalType()
    {
        $this->assertInstanceOf(
                self::GRAT_TYPE,
                $this->object->add(new NaturalIntType(2), 5.5));
        $this->assertInstanceOf(
                self::GRAT_TYPE,
                $this->object->add(5.5, new NaturalIntType(2)));
    }

    public function testAddWholeIntTypeAndNaturalIntReturnsGmpIntType()
    {
        $this->assertInstanceOf(
                self::GINT_TYPE,
                $this->object->add(new WholeIntType(5), new NaturalIntType(2)));
        $this->assertInstanceOf(
                self::GINT_TYPE,
                $this->object->add(new NaturalIntType(2), new WholeIntType(5)));
    }

    public function testAddRationalTypeAndIntReturnsGmpRationalType()
    {
        $this->assertInstanceOf(
                self::GRAT_TYPE,
                $this->object->add(RationalTypeFactory::create(1,5), 2));
        $this->assertInstanceOf(
                self::GRAT_TYPE,
                $this->object->add(2, RationalTypeFactory::create(1,5)));

    }

    public function testAddRationalTypeAndIntTypeReturnsGmpRationalType()
    {
        $this->assertInstanceOf(
                self::GRAT_TYPE,
                $this->object->add(RationalTypeFactory::create(1,5), new IntType(2)));
        $this->assertInstanceOf(
                self::GRAT_TYPE,
                $this->object->add(new IntType(2), RationalTypeFactory::create(1,5)));

    }

    public function testAddRationalTypeAndWholeIntTypeReturnsGmpRationalType()
    {
        $this->assertInstanceOf(
                self::GRAT_TYPE,
                $this->object->add(RationalTypeFactory::create(1,5), new WholeIntType(2)));
        $this->assertInstanceOf(
                self::GRAT_TYPE,
                $this->object->add(new WholeIntType(2), RationalTypeFactory::create(1,5)));

    }

    public function testAddRationalTypeAndNaturalIntTypeReturnsGmpRationalType()
    {
        $this->assertInstanceOf(
                self::GRAT_TYPE,
                $this->object->add(RationalTypeFactory::create(1,5), new NaturalIntType(2)));
        $this->assertInstanceOf(
                self::GRAT_TYPE,
                $this->object->add(new NaturalIntType(2), RationalTypeFactory::create(1,5)));

    }

    public function testAddRationalTypeAndFloatReturnsGmpRationalType()
    {
        $this->assertInstanceOf(
                self::GRAT_TYPE,
                $this->object->add(RationalTypeFactory::create(1,5), 2.6));
        $this->assertInstanceOf(
                self::GRAT_TYPE,
                $this->object->add(2.6, RationalTypeFactory::create(1,5)));

    }

    public function testAddRationalTypeAndFloatTypeReturnsGmpRationalType()
    {
        $this->assertInstanceOf(
                self::GRAT_TYPE,
                $this->object->add(RationalTypeFactory::create(1,5), new FloatType(2.6)));
        $this->assertInstanceOf(
                self::GRAT_TYPE,
                $this->object->add(new FloatType(2.6), RationalTypeFactory::create(1,5)));

    }

    public function testAddTwoComplexNumbersReturnsGmpComplexNumber()
    {
        $this->assertInstanceOf(
                self::GCOMP_TYPE,
                $this->object->add(ComplexTypeFactory::create(1,5), ComplexTypeFactory::create(5,1)));
    }

    /**
     * @dataProvider nonComplexNumbers
     * @param numeric $nonComplex
     */
    public function testAddComplexNumbersWithNonComplexNumberReturnsGmpComplexNumber($nonComplex)
    {
        $a = ComplexTypeFactory::create(1,5);
        $this->assertInstanceOf(
                self::GCOMP_TYPE,
                $this->object->add($a, $nonComplex));
    }

    /**
     * @dataProvider nonComplexNumbers
     * @param numeric $nonComplex
     */
    public function testAddNonComplexNumbersWithComplexNumberReturnsGmpComplexNumber($nonComplex)
    {
        $b = ComplexTypeFactory::create(1,5);
        $this->assertInstanceOf(
                self::GCOMP_TYPE,
                $this->object->add($nonComplex, $b));
    }

    public function nonComplexNumbers()
    {
        Calculator::setNumberType(Calculator::TYPE_GMP);
        return [
            [2],
            [-2.4],
            [new IntType(2)],
<<<<<<< HEAD
=======
            [new FloatType(2.6)],
>>>>>>> 1871b7cff507a5c6b124f07bec75cd684a881865
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
        $this->assertEquals(0, gmp_cmp($a->gmp(), $b->gmp()));
    }

    public function testAdditionIsAssociative()
    {
        $a = 12;
        $b = 3;
        $c = 5;
        //a+(b+c) = (a+b)_c
        $r1 = $this->object->add($a, $this->object->add($b, $c));
        $r2 = $this->object->add($this->object->add($a, $b), $c);

        $this->assertEquals(0, gmp_cmp($r1->gmp(), $r2->gmp()));
    }

    /**
<<<<<<< HEAD
     * @dataProvider correctIntResults
=======
     * @dataProvider correctResults
>>>>>>> 1871b7cff507a5c6b124f07bec75cd684a881865
     * @param mixed $a
     * @param mixed $b
     * @param mixed $r
     */
<<<<<<< HEAD
    public function testAdditionOfIntegersGivesCorrectResults($a, $b, $r)
    {
        $this->assertEquals(0, gmp_cmp($r->gmp(), $this->object->add($a, $b)->gmp()));
    }

    public function correctIntResults()
    {
        Calculator::setNumberType(Calculator::TYPE_GMP);
        return [
            [1, 2, TypeFactory::createInt(3)],
            [TypeFactory::createInt(1), 2, TypeFactory::createInt(3)],
            [1, TypeFactory::createInt(2), TypeFactory::createInt(3)],
            [TypeFactory::createInt(1), TypeFactory::createInt(2), TypeFactory::createInt(3)],
            [TypeFactory::createWhole(2), 3, TypeFactory::createWhole(5)],
            [2, TypeFactory::createWhole(3), TypeFactory::createWhole(5)],
            [TypeFactory::createNatural(2), 3, TypeFactory::createNatural(5)],
            [2, TypeFactory::createNatural(3), TypeFactory::createNatural(5)],
        ];
    }
    
    /**
     * @dataProvider correctFloatResults
     * @param mixed $a
     * @param mixed $b
     * @param mixed $r
     */
    public function testAdditionOfFloatsGivesCorrectResults($a, $b, $r)
    {
        $expected = $r->gmp();
        $test = $this->object->add($a, $b)->gmp();
        //numerator
        $this->assertEquals(0, gmp_cmp($expected[0], $test[0]));
        //denominator
        $this->assertEquals(0, gmp_cmp($expected[1], $test[1]));
    }

    public function correctFloatResults()
    {
        Calculator::setNumberType(Calculator::TYPE_GMP);
        return [
            [2.0, 3.0, TypeFactory::createFloat(5.0)],
            [TypeFactory::createFloat(2.0), 3.0, TypeFactory::createFloat(5.0)],
            [2.0, TypeFactory::createFloat(3.0), TypeFactory::createFloat(5.0)],
            [TypeFactory::createFloat(2.0), TypeFactory::createFloat(3.0), TypeFactory::createFloat(5.0)],
            [TypeFactory::createInt(2), 3.0, TypeFactory::createFloat(5.0)],
        ];
    }
    
    /**
     * @dataProvider correctRationalResults
     * @param mixed $a
     * @param mixed $b
     * @param mixed $r
     */
    public function testAdditionOfRationalsGivesCorrectResults($a, $b, $r)
    {
        $expected = $r->gmp();
        $test = $this->object->add($a, $b)->gmp();
         //numerator
        $this->assertEquals(0, gmp_cmp($expected[0], $test[0]));
        //denominator
        $this->assertEquals(0, gmp_cmp($expected[1], $test[1]));
    }

    public function correctRationalResults()
    {
        Calculator::setNumberType(Calculator::TYPE_GMP);
        return [
            [RationalTypeFactory::create(4),RationalTypeFactory::create(4),RationalTypeFactory::create(8)],
            [RationalTypeFactory::create(8,2),RationalTypeFactory::create(8,2),RationalTypeFactory::create(16,2)],
        ];
    }
    
=======
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
>>>>>>> 1871b7cff507a5c6b124f07bec75cd684a881865
}
