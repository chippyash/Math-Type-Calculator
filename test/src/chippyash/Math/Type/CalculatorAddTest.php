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
    /**@+
     * Class definitions for number types
     */
    const INT_TYPE = 'chippyash\Type\Number\IntType';
    const GINT_TYPE = 'chippyash\Type\Number\GMPIntType';
    const WINT_TYPE = 'chippyash\Type\Number\WholeIntType';
    const NINT_TYPE = 'chippyash\Type\Number\NaturalIntType';
    const FLOAT_TYPE = 'chippyash\Type\Number\FloatType';
    const RAT_TYPE = 'chippyash\Type\Number\Rational\RationalType';
    const GRAT_TYPE = 'chippyash\Type\Number\Rational\GMPRationalType';
    const COMP_TYPE = 'chippyash\Type\Number\Complex\ComplexType';
    const GCOMP_TYPE = 'chippyash\Type\Number\Complex\GMPComplexType';
    /**@-*/
    
    /**@+
     * class names
     */
    protected $intType;
    protected $wintType;
    protected $nintType;
    protected $floatType;
    protected $ratType;
    protected $compType;
    /**@-*/
    
    /**
     * SUT
     * @var chippyash\Math\Type\Calculator
     */
    protected $object;

    public function setUp()
    {
        $this->nintType = self::NINT_TYPE;
        $this->wintType = self::WINT_TYPE;
        $this->floatType = self::FLOAT_TYPE;
        if (extension_loaded('gmp')) {
            $this->intType = self::GINT_TYPE;
            $this->ratType = self::GRAT_TYPE;
            $this->compType = self::GCOMP_TYPE;
            Calculator::setNumberType(Calculator::TYPE_GMP);
        } else {
            $this->intType = self::INT_TYPE;
            $this->ratType = self::RAT_TYPE;
            $this->compType = self::COMP_TYPE;
            Calculator::setNumberType(Calculator::TYPE_NATIVE);
        }
        
        $this->object = new Calculator();
    }

    public function testAddTwoIntsReturnsIntType()
    {
        $this->assertInstanceOf(
                $this->intType,
                $this->object->add(2, 3));
    }

    public function testAddIntAndFloatReturnsFloatType()
    {
        $this->assertInstanceOf(
                $this->floatType,
                $this->object->add(2, 3.4));
        $this->assertInstanceOf(
                $this->floatType,
                $this->object->add(3.4, 2));
    }

    public function testAddTwoFloatsReturnsFloatType()
    {
        $this->assertInstanceOf(
                $this->floatType,
                $this->object->add(2.6, -3.067));
    }

    public function testAddTwoIntTypesReturnsIntType()
    {
        $this->assertInstanceOf(
                $this->intType,
                $this->object->add(new IntType(2), new IntType(3)));
    }

    public function testAddIntTypeAndFloatReturnsFloatType()
    {
        $this->assertInstanceOf(
                $this->floatType,
                $this->object->add(new IntType(2), 3.4));
        $this->assertInstanceOf(
                $this->floatType,
                $this->object->add(3.4, new IntType(2)));
    }

    public function testAddIntTypeAndFloatTypeReturnsFloatType()
    {
        $this->assertInstanceOf(
                $this->floatType,
                $this->object->add(new IntType(2), new FloatType(3.4)));
        $this->assertInstanceOf(
                $this->floatType,
                $this->object->add(new FloatType(3.4), new IntType(2)));
    }

    public function testAddTwoFloatTypesReturnsFloatType()
    {
        $this->assertInstanceOf(
                $this->floatType,
                $this->object->add(new FloatType(2.6), new FloatType(-3.067)));
    }

    public function testAddFloatTypeAndIntReturnsFloatType()
    {
        $this->assertInstanceOf(
                $this->floatType,
                $this->object->add(2, new FloatType(3.4)));
        $this->assertInstanceOf(
                $this->floatType,
                $this->object->add(new FloatType(3.4), 2));
    }

    public function testAddTwoWholeIntTypesReturnsWholeIntType()
    {
        $this->assertInstanceOf(
                $this->wintType,
                $this->object->add(new WholeIntType(2), new WholeIntType(5)));
    }

    public function testAddWholeIntTypeAndIntReturnsWholeIntType()
    {
        $this->assertInstanceOf(
                $this->wintType,
                $this->object->add(new WholeIntType(2), 5));
        $this->assertInstanceOf(
                $this->wintType,
                $this->object->add(5, new WholeIntType(2)));
    }

    public function testAddWholeIntTypeAndIntTypeReturnsWholeIntType()
    {
        $this->assertInstanceOf(
                $this->wintType,
                $this->object->add(new WholeIntType(2), new IntType(5)));
        $this->assertInstanceOf(
                $this->wintType,
                $this->object->add(new IntType(5), new WholeIntType(2)));
    }

    public function testAddWholeIntTypeAndFloatTypeReturnsFloatType()
    {
        $this->assertInstanceOf(
                $this->floatType,
                $this->object->add(new WholeIntType(2), new FloatType(5.5)));
        $this->assertInstanceOf(
                $this->floatType,
                $this->object->add(new FloatType(5.5), new WholeIntType(2)));
    }

    public function testAddWholeIntTypeAndFloatReturnsFloatType()
    {
        $this->assertInstanceOf(
                $this->floatType,
                $this->object->add(new WholeIntType(2), 5.5));
        $this->assertInstanceOf(
                $this->floatType,
                $this->object->add(5.5, new WholeIntType(2)));
    }

    public function testAddTwoNaturalIntTypesReturnsNaturalIntType()
    {
        $this->assertInstanceOf(
                $this->nintType,
                $this->object->add(new NaturalIntType(2), new NaturalIntType(5)));
    }

    public function testAddNaturalIntTypeAndIntReturnsNaturalIntType()
    {
        $this->assertInstanceOf(
                $this->nintType,
                $this->object->add(new NaturalIntType(2), 5));
        $this->assertInstanceOf(
                $this->nintType,
                $this->object->add(5, new NaturalIntType(2)));
    }

    public function testAddNaturalIntTypeAndIntTypeReturnsNaturalIntType()
    {
        $this->assertInstanceOf(
                $this->nintType,
                $this->object->add(new NaturalIntType(2), new IntType(5)));
        $this->assertInstanceOf(
                $this->nintType,
                $this->object->add(new IntType(5), new NaturalIntType(2)));
    }

    public function testAddNaturalIntTypeAndFloatTypeReturnsFloatType()
    {
        $this->assertInstanceOf(
                $this->floatType,
                $this->object->add(new NaturalIntType(2), new FloatType(5.5)));
        $this->assertInstanceOf(
                $this->floatType,
                $this->object->add(new FloatType(5.5), new NaturalIntType(2)));
    }

    public function testAddNaturalIntTypeAndFloatReturnsFloatType()
    {
        $this->assertInstanceOf(
                $this->floatType,
                $this->object->add(new NaturalIntType(2), 5.5));
        $this->assertInstanceOf(
                $this->floatType,
                $this->object->add(5.5, new NaturalIntType(2)));
    }

    public function testAddWholeIntTypeAndNaturalIntReturnsWholeIntType()
    {
        $this->assertInstanceOf(
                $this->wintType,
                $this->object->add(new WholeIntType(5), new NaturalIntType(2)));
        $this->assertInstanceOf(
                $this->wintType,
                $this->object->add(new NaturalIntType(2), new WholeIntType(5)));
    }

    public function testAddRationalTypeAndIntReturnsRationalType()
    {
        $this->assertInstanceOf(
                $this->ratType,
                $this->object->add(RationalTypeFactory::create(1,5), 2));
        $this->assertInstanceOf(
                $this->ratType,
                $this->object->add(2, RationalTypeFactory::create(1,5)));

    }

    public function testAddRationalTypeAndIntTypeReturnsRationalType()
    {
        $this->assertInstanceOf(
                $this->ratType,
                $this->object->add(RationalTypeFactory::create(1,5), new IntType(2)));
        $this->assertInstanceOf(
                $this->ratType,
                $this->object->add(new IntType(2), RationalTypeFactory::create(1,5)));

    }

    public function testAddRationalTypeAndWholeIntTypeReturnsRationalType()
    {
        $this->assertInstanceOf(
                $this->ratType,
                $this->object->add(RationalTypeFactory::create(1,5), new WholeIntType(2)));
        $this->assertInstanceOf(
                $this->ratType,
                $this->object->add(new WholeIntType(2), RationalTypeFactory::create(1,5)));

    }

    public function testAddRationalTypeAndNaturalIntTypeReturnsRationalType()
    {
        $this->assertInstanceOf(
                $this->ratType,
                $this->object->add(RationalTypeFactory::create(1,5), new NaturalIntType(2)));
        $this->assertInstanceOf(
                $this->ratType,
                $this->object->add(new NaturalIntType(2), RationalTypeFactory::create(1,5)));

    }

    public function testAddRationalTypeAndFloatReturnsRationalType()
    {
        $this->assertInstanceOf(
                $this->ratType,
                $this->object->add(RationalTypeFactory::create(1,5), 2.6));
        $this->assertInstanceOf(
                $this->ratType,
                $this->object->add(2.6, RationalTypeFactory::create(1,5)));

    }

    public function testAddRationalTypeAndFloatTypeReturnsRationalType()
    {
        $this->assertInstanceOf(
                $this->ratType,
                $this->object->add(RationalTypeFactory::create(1,5), new FloatType(2.6)));
        $this->assertInstanceOf(
                $this->ratType,
                $this->object->add(new FloatType(2.6), RationalTypeFactory::create(1,5)));

    }

    public function testAddTwoComplexNumbersReturnsComplexNumber()
    {
        $this->assertInstanceOf(
                $this->compType,
                $this->object->add(ComplexTypeFactory::create(1,5), ComplexTypeFactory::create(5,1)));
    }

    /**
     * @dataProvider nonComplexNumbers
     * @param numeric $nonComplex
     */
    public function testAddComplexNumbersWithNonComplexNumberReturnsComplexNumber($nonComplex)
    {
        $this->assertInstanceOf(
                $this->compType,
                $this->object->add(ComplexTypeFactory::create(1,5), $nonComplex));
    }

    /**
     * @dataProvider nonComplexNumbers
     * @param numeric $nonComplex
     */
    public function testAddNonComplexNumbersWithComplexNumberThrowsException($nonComplex)
    {
        $this->assertInstanceOf(
                $this->compType,
                $this->object->add($nonComplex, ComplexTypeFactory::create(1,5)));
    }

    public function nonComplexNumbers()
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
