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
class NativeCalculatorAddTest extends \PHPUnit_Framework_TestCase
{
    /**@+
     * Class definitions for number types
     */
    const INT_TYPE = 'chippyash\Type\Number\IntType';
    const WINT_TYPE = 'chippyash\Type\Number\WholeIntType';
    const NINT_TYPE = 'chippyash\Type\Number\NaturalIntType';
    const FLOAT_TYPE = 'chippyash\Type\Number\FloatType';
    const RAT_TYPE = 'chippyash\Type\Number\Rational\RationalType';
    const COMP_TYPE = 'chippyash\Type\Number\Complex\ComplexType';
    /**@-*/
    
    /**
     * SUT
     * @var chippyash\Math\Type\Calculator
     */
    protected $object;

    public function setUp()
    {
        Calculator::setNumberType(Calculator::TYPE_NATIVE);
        
        $this->object = new Calculator();
    }

    public function testAddTwoIntsReturnsIntType()
    {
        $this->assertInstanceOf(
                self::INT_TYPE,
                $this->object->add(2, 3));
    }

    public function testAddIntAndFloatReturnsFloatType()
    {
        $this->assertInstanceOf(
                self::FLOAT_TYPE,
                $this->object->add(2, 3.4));
        $this->assertInstanceOf(
                self::FLOAT_TYPE,
                $this->object->add(3.4, 2));
    }

    public function testAddTwoFloatsReturnsFloatType()
    {
        $this->assertInstanceOf(
                self::FLOAT_TYPE,
                $this->object->add(2.6, -3.067));
    }

    public function testAddTwoIntTypesReturnsIntType()
    {
        $this->assertInstanceOf(
                self::INT_TYPE,
                $this->object->add(new IntType(2), new IntType(3)));
    }

    public function testAddIntTypeAndFloatReturnsFloatType()
    {
        $this->assertInstanceOf(
                self::FLOAT_TYPE,
                $this->object->add(new IntType(2), 3.4));
        $this->assertInstanceOf(
                self::FLOAT_TYPE,
                $this->object->add(3.4, new IntType(2)));
    }

    public function testAddIntTypeAndFloatTypeReturnsFloatType()
    {
        $this->assertInstanceOf(
                self::FLOAT_TYPE,
                $this->object->add(new IntType(2), new FloatType(3.4)));
        $this->assertInstanceOf(
                self::FLOAT_TYPE,
                $this->object->add(new FloatType(3.4), new IntType(2)));
    }

    public function testAddTwoFloatTypesReturnsFloatType()
    {
        $this->assertInstanceOf(
                self::FLOAT_TYPE,
                $this->object->add(new FloatType(2.6), new FloatType(-3.067)));
    }

    public function testAddFloatTypeAndIntReturnsFloatType()
    {
        $this->assertInstanceOf(
                self::FLOAT_TYPE,
                $this->object->add(2, new FloatType(3.4)));
        $this->assertInstanceOf(
                self::FLOAT_TYPE,
                $this->object->add(new FloatType(3.4), 2));
    }

    public function testAddTwoWholeIntTypesReturnsWholeIntType()
    {
        $this->assertInstanceOf(
                self::WINT_TYPE,
                $this->object->add(new WholeIntType(2), new WholeIntType(5)));
    }

    public function testAddWholeIntTypeAndIntReturnsWholeIntType()
    {
        $this->assertInstanceOf(
                self::WINT_TYPE,
                $this->object->add(new WholeIntType(2), 5));
        $this->assertInstanceOf(
                self::WINT_TYPE,
                $this->object->add(5, new WholeIntType(2)));
    }

    public function testAddWholeIntTypeAndIntTypeReturnsWholeIntType()
    {
        $this->assertInstanceOf(
                self::WINT_TYPE,
                $this->object->add(new WholeIntType(2), new IntType(5)));
        $this->assertInstanceOf(
                self::WINT_TYPE,
                $this->object->add(new IntType(5), new WholeIntType(2)));
    }

    public function testAddWholeIntTypeAndFloatTypeReturnsFloatType()
    {
        $this->assertInstanceOf(
                self::FLOAT_TYPE,
                $this->object->add(new WholeIntType(2), new FloatType(5.5)));
        $this->assertInstanceOf(
                self::FLOAT_TYPE,
                $this->object->add(new FloatType(5.5), new WholeIntType(2)));
    }

    public function testAddWholeIntTypeAndFloatReturnsFloatType()
    {
        $this->assertInstanceOf(
                self::FLOAT_TYPE,
                $this->object->add(new WholeIntType(2), 5.5));
        $this->assertInstanceOf(
                self::FLOAT_TYPE,
                $this->object->add(5.5, new WholeIntType(2)));
    }

    public function testAddTwoNaturalIntTypesReturnsNaturalIntType()
    {
        $this->assertInstanceOf(
                self::NINT_TYPE,
                $this->object->add(new NaturalIntType(2), new NaturalIntType(5)));
    }

    public function testAddNaturalIntTypeAndIntReturnsNaturalIntType()
    {
        $this->assertInstanceOf(
                self::NINT_TYPE,
                $this->object->add(new NaturalIntType(2), 5));
        $this->assertInstanceOf(
                self::NINT_TYPE,
                $this->object->add(5, new NaturalIntType(2)));
    }

    public function testAddNaturalIntTypeAndIntTypeReturnsNaturalIntType()
    {
        $this->assertInstanceOf(
                self::NINT_TYPE,
                $this->object->add(new NaturalIntType(2), new IntType(5)));
        $this->assertInstanceOf(
                self::NINT_TYPE,
                $this->object->add(new IntType(5), new NaturalIntType(2)));
    }

    public function testAddNaturalIntTypeAndFloatTypeReturnsFloatType()
    {
        $this->assertInstanceOf(
                self::FLOAT_TYPE,
                $this->object->add(new NaturalIntType(2), new FloatType(5.5)));
        $this->assertInstanceOf(
                self::FLOAT_TYPE,
                $this->object->add(new FloatType(5.5), new NaturalIntType(2)));
    }

    public function testAddNaturalIntTypeAndFloatReturnsFloatType()
    {
        $this->assertInstanceOf(
                self::FLOAT_TYPE,
                $this->object->add(new NaturalIntType(2), 5.5));
        $this->assertInstanceOf(
                self::FLOAT_TYPE,
                $this->object->add(5.5, new NaturalIntType(2)));
    }

    public function testAddWholeIntTypeAndNaturalIntReturnsWholeIntType()
    {
        $this->assertInstanceOf(
                self::WINT_TYPE,
                $this->object->add(new WholeIntType(5), new NaturalIntType(2)));
        $this->assertInstanceOf(
                self::WINT_TYPE,
                $this->object->add(new NaturalIntType(2), new WholeIntType(5)));
    }

    public function testAddRationalTypeAndIntReturnsRationalType()
    {
        $this->assertInstanceOf(
                self::RAT_TYPE,
                $this->object->add(RationalTypeFactory::create(1,5), 2));
        $this->assertInstanceOf(
                self::RAT_TYPE,
                $this->object->add(2, RationalTypeFactory::create(1,5)));

    }

    public function testAddRationalTypeAndIntTypeReturnsRationalType()
    {
        $this->assertInstanceOf(
                self::RAT_TYPE,
                $this->object->add(RationalTypeFactory::create(1,5), new IntType(2)));
        $this->assertInstanceOf(
                self::RAT_TYPE,
                $this->object->add(new IntType(2), RationalTypeFactory::create(1,5)));

    }

    public function testAddRationalTypeAndWholeIntTypeReturnsRationalType()
    {
        $this->assertInstanceOf(
                self::RAT_TYPE,
                $this->object->add(RationalTypeFactory::create(1,5), new WholeIntType(2)));
        $this->assertInstanceOf(
                self::RAT_TYPE,
                $this->object->add(new WholeIntType(2), RationalTypeFactory::create(1,5)));

    }

    public function testAddRationalTypeAndNaturalIntTypeReturnsRationalType()
    {
        $this->assertInstanceOf(
                self::RAT_TYPE,
                $this->object->add(RationalTypeFactory::create(1,5), new NaturalIntType(2)));
        $this->assertInstanceOf(
                self::RAT_TYPE,
                $this->object->add(new NaturalIntType(2), RationalTypeFactory::create(1,5)));

    }

    public function testAddRationalTypeAndFloatReturnsRationalType()
    {
        $this->assertInstanceOf(
                self::RAT_TYPE,
                $this->object->add(RationalTypeFactory::create(1,5), 2.6));
        $this->assertInstanceOf(
                self::RAT_TYPE,
                $this->object->add(2.6, RationalTypeFactory::create(1,5)));

    }

    public function testAddRationalTypeAndFloatTypeReturnsRationalType()
    {
        $this->assertInstanceOf(
                self::RAT_TYPE,
                $this->object->add(RationalTypeFactory::create(1,5), new FloatType(2.6)));
        $this->assertInstanceOf(
                self::RAT_TYPE,
                $this->object->add(new FloatType(2.6), RationalTypeFactory::create(1,5)));

    }

    public function testAddTwoComplexNumbersReturnsComplexNumber()
    {
        $this->assertInstanceOf(
                self::COMP_TYPE,
                $this->object->add(ComplexTypeFactory::create(1,5), ComplexTypeFactory::create(5,1)));
    }

    /**
     * @dataProvider nonComplexNumbers
     * @param numeric $nonComplex
     */
    public function testAddComplexNumbersWithNonComplexNumberReturnsComplexNumber($nonComplex)
    {
        $this->assertInstanceOf(
                self::COMP_TYPE,
                $this->object->add(ComplexTypeFactory::create(1,5), $nonComplex));
    }

    /**
     * @dataProvider nonComplexNumbers
     * @param numeric $nonComplex
     */
    public function testAddNonComplexNumbersWithComplexNumberReturnsComplexNumber($nonComplex)
    {
        $this->assertInstanceOf(
                self::COMP_TYPE,
                $this->object->add($nonComplex, ComplexTypeFactory::create(1,5)));
    }

    public function nonComplexNumbers()
    {
        Calculator::setNumberType(Calculator::TYPE_NATIVE);
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
