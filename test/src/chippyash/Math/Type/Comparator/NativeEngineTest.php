<?php
namespace chippyash\Test\Math\Type\Comparator;

use chippyash\Type\TypeFactory;
use chippyash\Type\Number\IntType;
use chippyash\Type\Number\FloatType;
use chippyash\Type\Number\Rational\RationalType;
use chippyash\Type\Number\Complex\ComplexType;
use chippyash\Math\Type\Comparator\NativeEngine;

/**
 *
 */
class NativeEngineTest extends \PHPUnit_Framework_TestCase
{
    protected $object;

    protected $smallInt;
    protected $bigInt;

    protected $smallFloat;
    protected $bigFloat;

    protected $smallRational;
    protected $bigRational;

    protected $zeroRational;
    protected $smallRealComplex;
    protected $bigRealComplex;

    public function setUp()
    {
        TypeFactory::setNumberType(TypeFactory::TYPE_NATIVE);
        $this->object = new NativeEngine();

        $this->smallInt = new IntType(2);
        $this->bigInt = new IntType(12);
        $this->smallFloat = new FloatType(2);
        $this->bigFloat = new FloatType(12);
        $this->smallRational = new RationalType($this->smallInt, new IntType(1));
        $this->bigRational = new RationalType($this->bigInt, new IntType(1));
        $this->zeroRational = new RationalType(new IntType(0), new IntType(1));
        $this->smallRealComplex = new ComplexType($this->smallRational, $this->zeroRational);
        $this->bigRealComplex = new ComplexType($this->bigRational, $this->zeroRational);
        //modulus = 2√37 = 12.16552506
        $this->smallUnrealComplex = new ComplexType($this->smallRational, $this->bigRational);
        //modulus = 12√2 = 16.97056375
        $this->bigUnrealComplex = new ComplexType($this->bigRational, $this->bigRational);
    }

    public function testCompareIntsReturnsCorrectResult()
    {
        $this->assertEquals(0, $this->object->compare($this->smallInt, $this->smallInt));
        $this->assertEquals(-1, $this->object->compare($this->smallInt, $this->bigInt));
        $this->assertEquals(1, $this->object->compare($this->bigInt, $this->smallInt));
    }

    public function testCompareFloatsReturnsCorrectResult()
    {
        $this->assertEquals(0, $this->object->compare($this->smallFloat, $this->smallFloat));
        $this->assertEquals(-1, $this->object->compare($this->smallFloat, $this->bigFloat));
        $this->assertEquals(1, $this->object->compare($this->bigFloat, $this->smallFloat));
    }

    public function testCompareRationalsReturnsCorrectResult()
    {
        $this->assertEquals(0, $this->object->compare($this->smallRational, $this->smallRational));
        $this->assertEquals(-1, $this->object->compare($this->smallRational, $this->bigRational));
        $this->assertEquals(1, $this->object->compare($this->bigRational, $this->smallRational));
    }

    public function testCompareRealComplexReturnsCorrectResultBasedOnRealPart()
    {
        $this->assertEquals(0, $this->object->compare($this->smallRealComplex, $this->smallRealComplex));
        $this->assertEquals(-1, $this->object->compare($this->smallRealComplex, $this->bigRealComplex));
        $this->assertEquals(1, $this->object->compare($this->bigRealComplex, $this->smallRealComplex));
    }

    public function testCompareUnrealComplexReturnsCorrectResultBasedOnRealPart()
    {
        $this->assertEquals(0, $this->object->compare($this->smallUnrealComplex, $this->smallUnrealComplex));
        $this->assertEquals(-1, $this->object->compare($this->smallUnrealComplex, $this->bigUnrealComplex));
        $this->assertEquals(1, $this->object->compare($this->bigUnrealComplex, $this->smallUnrealComplex));
    }

    public function testCanMixComplexAndNonComplexTypesForComparison()
    {
        $this->assertEquals(1, $this->object->compare($this->smallUnrealComplex, $this->smallInt));
        $this->assertEquals(-1, $this->object->compare($this->smallInt, $this->smallUnrealComplex));
    }

    /**
     * @dataProvider mixedTypes
     */
    public function testCanMixTypesForComparison($a, $b, $res)
    {
        $this->assertEquals($res, $this->object->compare($a, $b));
    }

    public function mixedTypes()
    {
        $this->setUp();
        return [
            [$this->smallInt, $this->smallFloat, 0],
            [$this->smallInt, $this->smallRational, 0],
            [$this->smallInt, $this->smallRealComplex, 0],
            [$this->smallFloat, $this->smallInt, 0],
            [$this->smallFloat, $this->smallRational, 0],
            [$this->smallFloat, $this->smallRealComplex, 0],
            [$this->smallRational, $this->smallInt, 0],
            [$this->smallRational, $this->smallFloat, 0],
            [$this->smallRational, $this->smallRealComplex,0],
            [$this->smallRealComplex, $this->smallInt, 0],
            [$this->smallRealComplex, $this->smallFloat, 0],
            [$this->smallRealComplex, $this->smallRational, 0],
        ];
    }
}
