<?php
namespace Chippyash\Test\Math\Type\Comparator;

use Chippyash\Math\Type\Comparator\GmpEngine;
use Chippyash\Type\Number\GMPIntType;
use Chippyash\Type\Number\Rational\GMPRationalType;
use Chippyash\Type\Number\Complex\GMPComplexType;
use Chippyash\Type\RequiredType;
use Chippyash\Type\Number\Rational\RationalTypeFactory;

/**
 * @requires ext gmp
 */
class GmpEngineTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var GmpEngine
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
        RequiredType::getInstance()->set(RequiredType::TYPE_GMP);
        $this->sut = new GmpEngine();

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
    }

    public function testCompareIntsReturnsCorrectResult()
    {
        $this->assertEquals(0, $this->sut->compare($this->smallInt, $this->smallInt));
        $this->assertEquals(-1, $this->sut->compare($this->smallInt, $this->bigInt));
        $this->assertEquals(1, $this->sut->compare($this->bigInt, $this->smallInt));
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
        $this->assertEquals(1, $this->sut->compare($this->smallUnrealComplex, $this->bigUnrealComplex));
        $this->assertEquals(-1, $this->sut->compare($this->bigUnrealComplex, $this->smallUnrealComplex));
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
            [$this->smallInt, $this->smallRational, 0],
            [$this->smallInt, $this->smallRealComplex, 0],
            [$this->smallRational, $this->smallRealComplex,0],
            [$this->smallRealComplex, $this->smallInt, 0],
            [$this->smallRealComplex, $this->smallRational, 0],
        ];
    }

    public function testYouCanGetApproximatelyEqualsWithTheAeqMethod()
    {
        $tolerance = RationalTypeFactory::fromString('1/10000000000');
        $a = new GMPIntType(1);
        $b = RationalTypeFactory::create(1.1);
        $c = RationalTypeFactory::fromString('10000000001/10000000000');
        $this->assertFalse($this->sut->aeq($a, $b, $tolerance));
        $this->assertTrue($this->sut->aeq($a, $c, $tolerance));
    }
}
