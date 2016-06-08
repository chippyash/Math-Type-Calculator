<?php
namespace chippyash\Test\Math\Type\Comparator;

use chippyash\Type\TypeFactory;
use chippyash\Type\Number\GMPIntType;
use chippyash\Type\Number\Rational\GMPRationalType;
use chippyash\Type\Number\Complex\GMPComplexType;
use chippyash\Type\Number\FloatType;
use chippyash\Math\Type\Comparator\GmpEngine;
use Chippyash\Type\RequiredType;

/**
 *
 */
class GmpEngineTest extends \PHPUnit_Framework_TestCase
{
    protected $object;

    protected $smallInt;
    protected $bigInt;

    protected $smallFloat;

    protected $smallRational;
    protected $bigRational;

    protected $zeroRational;
    protected $smallRealComplex;
    protected $bigRealComplex;

    public function setUp()
    {
        RequiredType::getInstance()->set(RequiredType::TYPE_GMP);
        $this->object = new GmpEngine();

        $this->smallInt = new GMPIntType(2);
        $this->bigInt = new GMPIntType(12);
        $this->smallRational = new GMPRationalType($this->smallInt, new GMPIntType(1));
        $this->bigRational = new GMPRationalType($this->bigInt, new GMPIntType(1));
        $this->zeroRational = new GMPRationalType(new GMPIntType(0), new GMPIntType(1));
        $this->smallRealComplex = new GMPComplexType($this->smallRational, $this->zeroRational);
        $this->bigRealComplex = new GMPComplexType($this->bigRational, $this->zeroRational);
        //modulus = 2√37 = 12.16552506
        $this->smallUnrealComplex = new GMPComplexType($this->smallRational, $this->bigRational);
        //modulus = 12√2 = 16.97056375
        $this->bigUnrealComplex = new GMPComplexType($this->bigRational, $this->bigRational);
        
        $this->smallFloat = new FloatType(1.2);
    }

    public function testCompareIntsReturnsCorrectResult()
    {
        $this->assertEquals(0, $this->object->compare($this->smallInt, $this->smallInt));
        $this->assertEquals(-1, $this->object->compare($this->smallInt, $this->bigInt));
        $this->assertEquals(1, $this->object->compare($this->bigInt, $this->smallInt));
    }

    /**
     * @expectedException Exception
     * @expectedExceptionMessage Unsupported type: float
     */
    public function testCompareFloatAsFirstParamThrowsAnException()
    {
        $this->object->compare($this->smallFloat, $this->smallInt);
    }

    /**
     * @expectedException Exception
     * @expectedExceptionMessage Unsupported type: float
     */
    public function testCompareFloatAsSecondParamThrowsAnException()
    {
        $this->object->compare($this->smallInt, $this->smallFloat);
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
