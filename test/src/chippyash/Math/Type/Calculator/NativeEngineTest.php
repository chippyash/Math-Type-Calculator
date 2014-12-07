<?php
namespace chippyash\Test\Math\Type\Calculator;

use chippyash\Math\Type\Calculator\NativeEngine;
use chippyash\Math\Type\Calculator;
use chippyash\Type\Number\IntType;
use chippyash\Type\Number\WholeIntType;
use chippyash\Type\Number\NaturalIntType;
use chippyash\Type\Number\FloatType;
use chippyash\Type\TypeFactory;
use chippyash\Type\Number\Rational\RationalTypeFactory;
use chippyash\Type\Number\Complex\ComplexTypeFactory;

/**
 * Covers some areas not covered in the main calculator tests
 */
class NativeEngineTest extends \PHPUnit_Framework_TestCase
{
    protected $object;

    protected $smallInt;
    protected $bigInt;

    protected $smallWholeInt;
    protected $bigWholeInt;
    
    protected $smallNaturalInt;
    protected $bigNaturalInt;
    
    protected $smallFloat;
    protected $bigFloat;

    protected $smallRational;
    protected $bigRational;
    protected $zeroRational;

    protected $smallRealComplex;
    protected $bigRealComplex;
    protected $smallUnrealComplex;
    protected $bigUnrealComplex;
    protected $zeroComplex;
    
    public function setUp()
    {
        Calculator::setNumberType(Calculator::TYPE_NATIVE);
        $this->object = new NativeEngine(new Calculator());
        
        $this->smallInt = new IntType(2);
        $this->bigInt = new IntType(12);
        $this->smallFloat = new FloatType(2);
        $this->bigFloat = new FloatType(12);
        $this->smallWholeInt = new WholeIntType(2);
        $this->bigWholeInt = new WholeIntType(12);
        $this->smallNaturalInt = new NaturalIntType(2);
        $this->bigNaturalInt = new NaturalIntType(12);
        $this->smallRational = RationalTypeFactory::create($this->smallInt, new IntType(1));
        $this->bigRational = RationalTypeFactory::create($this->bigInt, new IntType(1));
        $this->zeroRational = RationalTypeFactory::create(new IntType(0), new IntType(1));
        $this->smallRealComplex = ComplexTypeFactory::create($this->smallRational, $this->zeroRational);
        $this->bigRealComplex = ComplexTypeFactory::create($this->bigRational, $this->zeroRational);
        //modulus = 2√37 = 12.16552506
        $this->smallUnrealComplex = ComplexTypeFactory::create($this->smallRational, $this->bigRational);
        //modulus = 12√2 = 16.97056375
        $this->bigUnrealComplex = ComplexTypeFactory::create($this->bigRational, $this->bigRational);
        $this->zeroComplex = ComplexTypeFactory::create($this->zeroRational, $this->zeroRational);
    }

    public function testAddingTwoIntTypesReturnsIntType()
    {
        $test = $this->object->intAdd($this->smallInt, $this->bigInt);
        $this->assertInstanceOf(
                'chippyash\Type\Number\IntType',
                $test);
        $this->assertEquals(14, $test());
    }

    public function testSubtractingTwoIntTypesReturnsIntType()
    {
        $test = $this->object->intSub($this->smallInt, $this->bigInt);
        $this->assertInstanceOf(
                'chippyash\Type\Number\IntType',
                $test);
        $this->assertEquals(-10, $test());
    }

    public function testDividingTwoIntTypesReturnsRationalType()
    {
        $test = $this->object->intDiv($this->bigInt, $this->smallInt);
        $this->assertInstanceOf(
                'chippyash\Type\Number\Rational\RationalType',
                $test);
        $this->assertEquals(6, $test());
    }

    public function testMultiplyingTwoIntTypesReturnsIntType()
    {
        $test = $this->object->intMul($this->smallInt, $this->bigInt);
        $this->assertInstanceOf(
                'chippyash\Type\Number\IntType',
                $test);
        $this->assertEquals(24, $test());
    }

    
    public function testIntAddWithNonIntTypesComputesResult()
    {
        $a = new WholeIntType(12);
        $b = new FloatType(12.0);
        $this->assertInstanceOf(
                'chippyash\Type\Number\IntType',
                $this->object->intAdd($a, $b));
        $this->assertInstanceOf(
                'chippyash\Type\Number\IntType',
                $this->object->intAdd($b, $a));
    }
    
    public function testSquareRootOfIntTypeReturnsIntTypeForPerfectSquare()
    {
        $test = $this->object->intSqrt(new IntType(4));
        $this->assertInstanceOf(
                'chippyash\Type\Number\IntType',
                $test);
        $this->assertEquals(2, $test());
    }
    
    public function testSquareRootOfIntTypeReturnsRationalTypeForNonPerfectSquare()
    {
        $test = $this->object->intSqrt(new IntType(5));
        $this->assertInstanceOf(
                'chippyash\Type\Number\Rational\RationalType',
                $test);
        $this->assertEquals(sqrt(5), $test());
    }
    
    public function testIntPowReturnsRationalOrIntOrComplexTypes()
    {
        $base = new IntType(5);
        $exp = new IntType(3);
        $this->assertInstanceOf(
                '\chippyash\Type\Number\IntType', 
                $this->object->intPow($base, $exp));
        $this->assertEquals(125, $this->object->intPow($base, $exp)->get());
        
        $exp2 = new FloatType(3.5);
        $this->assertInstanceOf(
                '\chippyash\Type\Number\Rational\RationalType', 
                $this->object->intPow($base, $exp2));
        $this->assertEquals('332922571/1191100', (string) $this->object->intPow($base, $exp2));
        
        $exp3 = RationalTypeFactory::fromFloat(3.5);
        $this->assertInstanceOf(
                '\chippyash\Type\Number\Rational\RationalType', 
                $this->object->intPow($base, $exp3));
        $this->assertEquals('332922571/1191100', (string) $this->object->intPow($base, $exp3));
        
        $base2 = new IntType(4);
        $exp4 = ComplexTypeFactory::fromString('5+3i');
        $pow = $this->object->intPow($base2, $exp4);
        $this->assertInstanceOf(
                '\chippyash\Type\Number\Complex\ComplexType',
                $pow);
        $this->assertEquals('-778299179/1445876', (string) $pow->r());
        $this->assertEquals('-861158767/988584', (string) $pow->i());
        
        $exp5 = ComplexTypeFactory::fromString('0+3i');
        $pow = $this->object->intPow($base2, $exp5);
        $this->assertInstanceOf(
                '\chippyash\Type\Number\Complex\ComplexType',
                $pow);
        $this->assertEquals('-1722722/3277175', (string) $pow->r());
        $this->assertEquals('-20905959/24575389', (string) $pow->i());
        
        $exp6 = ComplexTypeFactory::fromString('5+0i');
        $pow = $this->object->intPow($base2, $exp6);
        $this->assertInstanceOf(
                '\chippyash\Type\Number\Rational\RationalType',
                $pow);
        $this->assertEquals(1024, $pow->get());
    }
    
    public function testAddingFloatsReturnsAFloat()
    {
        $test = $this->object->floatAdd($this->bigFloat, $this->smallFloat);
        $this->assertInstanceOf(
                '\chippyash\Type\Number\FloatType',
                $test);
        $this->assertEquals(14, $test());
    }
    
    public function testSubtractingFloatsReturnsAFloat()
    {
        $test = $this->object->floatSub($this->bigFloat, $this->smallFloat);
        $this->assertInstanceOf(
                '\chippyash\Type\Number\FloatType',
                $test);
        $this->assertEquals(10, $test());
    }
    
    public function testDividingFloatsReturnsAFloat()
    {
        $test = $this->object->floatDiv($this->bigFloat, $this->smallFloat);
        $this->assertInstanceOf(
                '\chippyash\Type\Number\FloatType',
                $test);
        $this->assertEquals(6, $test());
    }

    public function testMultiplyingFloatsReturnsAFloat()
    {
        $test = $this->object->floatMul($this->bigFloat, $this->smallFloat);
        $this->assertInstanceOf(
                '\chippyash\Type\Number\FloatType',
                $test);
        $this->assertEquals(24, $test());
    }

    public function testReciprocalOfAFloatsReturnsAFloat()
    {
        $test = $this->object->floatReciprocal($this->bigFloat);
        $this->assertInstanceOf(
                '\chippyash\Type\Number\FloatType',
                $test);
        $this->assertEquals(1/12, $test());
    }

    public function testPowOfFloatsReturnsAFloat()
    {
        $test = $this->object->floatPow($this->bigFloat, $this->smallFloat);
        $this->assertInstanceOf(
                '\chippyash\Type\Number\FloatType',
                $test);
        $this->assertEquals(144, $test());
    }
    
    public function testPowOfFloatWithRationalExponentReturnsAFloat()
    {
        $test = $this->object->floatPow($this->bigFloat, $this->smallRational);
        $this->assertInstanceOf(
                '\chippyash\Type\Number\FloatType',
                $test);
        $this->assertEquals(144, $test());
    }
    
    public function testPowOfFloatWithZeroComplexExponentReturnsAFloatEqualsOne()
    {
        $test = $this->object->floatPow($this->bigFloat, $this->zeroComplex);
        $this->assertInstanceOf(
                '\chippyash\Type\Number\FloatType',
                $test);
        $this->assertEquals(1, $test());
    }

    public function testPowOfFloatWithComplexHavingZeroRealPartExponentReturnsAComplex()
    {
        $complex = ComplexTypeFactory::create(0,2.3);
        $test = $this->object->floatPow($this->bigFloat, $complex);
        $this->assertInstanceOf(
                '\chippyash\Type\Number\Complex\ComplexType',
                $test);
        $this->assertEquals('11114986/13184531-4368724/8122375i', $test());
    }
    
    public function testSqrtOfAFloatTypeReturnsAFloatType()
    {
        $test = $this->object->floatSqrt($this->smallFloat);
        $this->assertInstanceOf('\chippyash\Type\Number\FloatType', $test);
        $this->assertEquals(sqrt(2), $test());
    }
    
    public function testWholeIntAdditionReturnsAWholeInt()
    {
        $test = $this->object->wholeAdd($this->bigWholeInt, $this->smallWholeInt);
        $this->assertInstanceOf('\chippyash\Type\Number\WholeIntType', $test);
        $this->assertEquals(14, $test());
    }
    
    public function testWholeIntSubtractReturnsAWholeInt()
    {
        $test = $this->object->wholeSub($this->bigWholeInt, $this->smallWholeInt);
        $this->assertInstanceOf('\chippyash\Type\Number\WholeIntType', $test);
        $this->assertEquals(10, $test());
    }
    
    /**
     * @expectedException chippyash\Type\Exceptions\InvalidTypeException
     */
    public function testWholeIntSubtractThrowsExceptionIfResultIsOutOfBounds()
    {
        $test = $this->object->naturalSub($this->smallWholeInt, $this->bigWholeInt);
    }

    public function testWholeIntMultiplicationReturnsAWholeInt()
    {
        $test = $this->object->wholeMul($this->bigWholeInt, $this->smallWholeInt);
        $this->assertInstanceOf('\chippyash\Type\Number\WholeIntType', $test);
        $this->assertEquals(24, $test());
    }
    
    public function testNaturalIntAdditionReturnsANaturalInt()
    {
        $test = $this->object->naturalAdd($this->bigNaturalInt, $this->smallNaturalInt);
        $this->assertInstanceOf('\chippyash\Type\Number\NaturalIntType', $test);
        $this->assertEquals(14, $test());
    }
    
    public function testNaturalIntSubtractReturnsANaturalInt()
    {
        $test = $this->object->naturalSub($this->bigNaturalInt, $this->smallNaturalInt);
        $this->assertInstanceOf('\chippyash\Type\Number\NaturalIntType', $test);
        $this->assertEquals(10, $test());
    }
    
    /**
     * @expectedException chippyash\Type\Exceptions\InvalidTypeException
     */
    public function testNaturalIntSubtractThrowsExceptionIfResultIsOutOfBounds()
    {
        $test = $this->object->naturalSub($this->smallNaturalInt, $this->bigNaturalInt);
    }

    public function testNaturalIntMultiplicationReturnsANaturalInt()
    {
        $test = $this->object->naturalMul($this->bigNaturalInt, $this->smallNaturalInt);
        $this->assertInstanceOf('\chippyash\Type\Number\NaturalIntType', $test);
        $this->assertEquals(24, $test());
    }
    
    public function testRationalAdditionReturnsARational()
    {
        $test = $this->object->rationalAdd($this->bigRational, $this->smallRational);
        $this->assertInstanceOf('\chippyash\Type\Number\Rational\RationalType', $test);
        $this->assertEquals(14, $test());
    }
    
    public function testRationalAdditionCanAddNonRationalsAndReturnARational()
    {
        $test = $this->object->rationalAdd($this->bigInt, $this->smallFloat);
        $this->assertInstanceOf('\chippyash\Type\Number\Rational\RationalType', $test);
        $this->assertEquals(14, $test());
    }
    
    public function testRationalSubtractionReturnsARational()
    {
        $test = $this->object->rationalSub($this->bigRational, $this->smallRational);
        $this->assertInstanceOf('\chippyash\Type\Number\Rational\RationalType', $test);
        $this->assertEquals(10, $test());
    }
    
    public function testRationalSubtractionCanAddNonRationalsAndReturnARational()
    {
        $test = $this->object->rationalSub($this->bigInt, $this->smallFloat);
        $this->assertInstanceOf('\chippyash\Type\Number\Rational\RationalType', $test);
        $this->assertEquals(10, $test());
    }
    
    public function testRationalReciprocalReturnsARational()
    {
        $test = $this->object->rationalReciprocal($this->bigRational);
        $this->assertInstanceOf('\chippyash\Type\Number\Rational\RationalType', $test);
        $this->assertEquals(1/12, $test());
    }
    
    public function testRationalPowReturnsARationalWhenExponentIsRealComplex()
    {
        $test = $this->object->rationalPow($this->bigRational, $this->smallRealComplex);
        $this->assertInstanceOf('\chippyash\Type\Number\Rational\RationalType', $test);
        $this->assertEquals(144, $test());
    }
    
    public function testRationalPowReturnsAComplexWhenExponentIsUnrealComplex()
    {
        $test = $this->object->rationalPow($this->bigRational, $this->bigUnrealComplex);
        $this->assertInstanceOf('\chippyash\Type\Number\Complex\ComplexType', $test);
        $this->assertEquals('-65994888641369/282-276303888245403/31i', $test());
    }
    
    public function testRationalPowReturnsAComplexWhenExponentIsZeroComplex()
    {
        $test = $this->object->rationalPow($this->bigRational, $this->zeroComplex);
        $this->assertInstanceOf('\chippyash\Type\Number\Rational\RationalType', $test);
        $this->assertEquals(1, $test());
    }
    
    public function testComplexAddReturnsComplex()
    {
        $test = $this->object->complexAdd($this->bigUnrealComplex, $this->smallUnrealComplex);
        $this->assertInstanceOf('\chippyash\Type\Number\Complex\ComplexType', $test);
        $this->assertEquals('14+24i', $test());
    }

    public function testComplexSubReturnsComplex()
    {
        $test = $this->object->complexSub($this->bigUnrealComplex, $this->smallUnrealComplex);
        $this->assertInstanceOf('\chippyash\Type\Number\Complex\ComplexType', $test);
        $this->assertEquals(10, $test());
    }
    
    public function testComplexMulReturnsComplex()
    {
        $test = $this->object->complexMul($this->bigUnrealComplex, $this->smallUnrealComplex);
        $this->assertInstanceOf('\chippyash\Type\Number\Complex\ComplexType', $test);
        $this->assertEquals('-120+168i', $test());
    }
    
    /**
     * @expectedException \BadMethodCallException
     * @expectedExceptionMessage Cannot divide complex number by zero complex number
     */
    public function testComplexDivWithZeroDivisorThrowsException()
    {
        $test = $this->object->complexDiv($this->bigUnrealComplex, $this->zeroComplex);
    }
    
    public function testComplexDivReturnsComplex()
    {
        $test = $this->object->complexDiv($this->bigUnrealComplex, $this->smallUnrealComplex);
        $this->assertInstanceOf('\chippyash\Type\Number\Complex\ComplexType', $test);
        $this->assertEquals('42/37-30/37i', $test());
    }
    
    /**
     * @expectedException \BadMethodCallException
     * @expectedExceptionMessage Cannot compute reciprocal of zero complex number
     */
    public function testComplexReciprocalWithZeroComplexThrowsException()
    {
        $test = $this->object->complexReciprocal($this->zeroComplex);
    }

    public function testComplexReciprocalWithNonZeroComplexReturnsComplex()
    {
        $test = $this->object->complexReciprocal($this->bigUnrealComplex);
        $this->assertInstanceOf('\chippyash\Type\Number\Complex\ComplexType', $test);
        $this->assertEquals('1/24+1/24i', $test());        
    }    
    
    public function testNatLogReturnsRationalType()
    {
        $this->assertInstanceOf(
                'chippyash\Type\Number\Rational\RationalType',
                $this->object->natLog($this->bigInt));
    }
    
    public function testNatLogReturnsCorrectResultForIntType()
    {
        $this->assertEquals(2.4849066497880008, $this->object->natLog($this->bigInt)->get());
    }

    public function testNatLogReturnsCorrectResultForWholintType()
    {
        $this->assertEquals(2.4849066497880008, $this->object->natLog(TypeFactory::create('whole', 12))->get());
    }

    public function testNatLogReturnsCorrectResultForNaturalintType()
    {
        $this->assertEquals(2.4849066497880008, $this->object->natLog(TypeFactory::create('natural', 12))->get());
    }

    public function testNatLogReturnsCorrectResultForFloatType()
    {
        $this->assertEquals(2.4849066497880008, $this->object->natLog(TypeFactory::create('float', 12))->get());
    }

    public function testNatLogReturnsCorrectResultForRationalType()
    {
        $this->assertEquals(2.4849066497880008, $this->object->natLog(TypeFactory::create('rational', 12))->get());
    }

    public function testNatLogReturnsCorrectResultForRationalComplexType()
    {
        $this->assertEquals(2.4849066497880008, $this->object->natLog(TypeFactory::create('complex', '12+0i'))->get());
    }

    public function testNatLogReturnsCorrectResultForNonRationalComplexTypeByUsingModulus()
    {
        $this->assertEquals(
                2.5152189606962181, 
                $this->object->natLog(TypeFactory::create('complex', '12+3i'))->get());
    }
    

}
