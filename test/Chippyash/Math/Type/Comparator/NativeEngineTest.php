<?php
namespace Chippyash\Test\Math\Type\Comparator;

use Chippyash\Type\Number\IntType;
use Chippyash\Type\Number\FloatType;
use Chippyash\Type\Number\Rational\RationalType;
use Chippyash\Type\Number\Complex\ComplexType;
use Chippyash\Math\Type\Comparator\NativeEngine;
use Chippyash\Type\RequiredType;
use Chippyash\Type\TypeFactory;

/**
 *
 */
class NativeEngineTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var NativeEngine
     */
    protected $sut;

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
        RequiredType::getInstance()->set(RequiredType::TYPE_NATIVE);
        $this->sut = new NativeEngine();

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
        $this->assertEquals(0, $this->sut->compare($this->smallInt, $this->smallInt));
        $this->assertEquals(-1, $this->sut->compare($this->smallInt, $this->bigInt));
        $this->assertEquals(1, $this->sut->compare($this->bigInt, $this->smallInt));
    }

    public function testCompareFloatsReturnsCorrectResult()
    {
        $this->assertEquals(0, $this->sut->compare($this->smallFloat, $this->smallFloat));
        $this->assertEquals(-1, $this->sut->compare($this->smallFloat, $this->bigFloat));
        $this->assertEquals(1, $this->sut->compare($this->bigFloat, $this->smallFloat));
    }

    public function testCompareRationalsReturnsCorrectResult()
    {
        $this->assertEquals(0, $this->sut->compare($this->smallRational, $this->smallRational));
        $this->assertEquals(-1, $this->sut->compare($this->smallRational, $this->bigRational));
        $this->assertEquals(1, $this->sut->compare($this->bigRational, $this->smallRational));
    }

    public function testCompareRealComplexReturnsCorrectResultBasedOnRealPart()
    {
        $this->assertEquals(0, $this->sut->compare($this->smallRealComplex, $this->smallRealComplex));
        $this->assertEquals(-1, $this->sut->compare($this->smallRealComplex, $this->bigRealComplex));
        $this->assertEquals(1, $this->sut->compare($this->bigRealComplex, $this->smallRealComplex));
    }

    public function testCompareUnrealComplexReturnsCorrectResultBasedOnRealPart()
    {
        $this->assertEquals(0, $this->sut->compare($this->smallUnrealComplex, $this->smallUnrealComplex));
        $this->assertEquals(-1, $this->sut->compare($this->smallUnrealComplex, $this->bigUnrealComplex));
        $this->assertEquals(1, $this->sut->compare($this->bigUnrealComplex, $this->smallUnrealComplex));
    }

    public function testCanMixComplexAndNonComplexTypesForComparison()
    {
        $this->assertEquals(1, $this->sut->compare($this->smallUnrealComplex, $this->smallInt));
        $this->assertEquals(-1, $this->sut->compare($this->smallInt, $this->smallUnrealComplex));
    }

    /**
     * @dataProvider mixedTypes
     */
    public function testCanMixTypesForComparison($a, $b, $res)
    {
        $this->assertEquals($res, $this->sut->compare($a, $b));
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

    public function testYouCanSetAToleranceForAComparison()
    {
        $tolerance = TypeFactory::createFloat(0.0001);
        $a = TypeFactory::createInt(1);
        $b = TypeFactory::createFloat(1.1);
        $c = TypeFactory::createFloat(1.0001);
        $this->assertEquals(-1, $this->sut->compare($a, $b, $tolerance));
        $this->assertEquals(0, $this->sut->compare($a, $c, $tolerance));

        $a1 = TypeFactory::createRational(1);
        $b1 = TypeFactory::createRational(1.1);
        $c1 = TypeFactory::createRational(1.0001);
        $this->assertEquals(-1, $this->sut->compare($a1, $b1, $tolerance));
        $this->assertEquals(0, $this->sut->compare($a1, $c1, $tolerance));

        //real complex
        $a2 = TypeFactory::createComplex(1, 0);
        $b2 = TypeFactory::createComplex(1.1, 0);
        $c2 = TypeFactory::createComplex(1.0001, 0);
        $this->assertEquals(-1, $this->sut->compare($a2, $b2, $tolerance));
        $this->assertEquals(0, $this->sut->compare($a2, $c2, $tolerance));

        //unreal complex
        $a3 = TypeFactory::createComplex(1, 2);
        $b3 = TypeFactory::createComplex(1.1, 2);
        $c3 = TypeFactory::createComplex(1.0001, 2);
        $this->assertEquals(-1, $this->sut->compare($a3, $b3, $tolerance));
        $this->assertEquals(0, $this->sut->compare($a3, $c3, $tolerance));
    }

    public function testYouCanGetApproximatelyEqualsWithTheAeqMethod()
    {
        $tolerance = TypeFactory::createFloat(0.0001);
        $a = TypeFactory::createInt(1);
        $b = TypeFactory::createFloat(1.1);
        $c = TypeFactory::createFloat(1.0001);
        $this->assertFalse($this->sut->aeq($a, $b, $tolerance));
        $this->assertTrue($this->sut->aeq($a, $c, $tolerance));
    }
}
