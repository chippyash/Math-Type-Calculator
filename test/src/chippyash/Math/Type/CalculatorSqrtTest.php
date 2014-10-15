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
class CalculatorSqrtTest extends \PHPUnit_Framework_TestCase
{
    protected $object;

    public function setUp()
    {
        Calculator::setNumberType(Calculator::TYPE_NATIVE);
        $this->object = new Calculator();
    }

    public function testSqrtIntTypeReturnsIntTypeForPerfectSquares()
    {
        $res = $this->object->sqrt(new IntType(9));
        $this->assertInstanceOf(
                '\chippyash\Type\Number\IntType', 
                $res);
        $this->assertEquals(3, $res());
    }
    
    public function testSqrtIntTypeReturnsRationalTypeForImperfectSquares()
    {
        $res = $this->object->sqrt(new IntType(7));
        $this->assertInstanceOf(
                '\chippyash\Type\Number\Rational\RationalType', 
                $res);
        $this->assertEquals('46256493/17483311', (string) $res);
    }
    
    public function testSqrtRationalTypeReturnsRationalType()
    {
        $res = $this->object->sqrt(RationalTypeFactory::create(7));
        $this->assertInstanceOf(
                '\chippyash\Type\Number\Rational\RationalType', 
                $res);
        $this->assertEquals('46256493/17483311', (string) $res);
    }
    
    public function testSqrtFloatTypeReturnsFloatType()
    {
        $res = $this->object->sqrt(new FloatType(4));
        $this->assertInstanceOf(
                '\chippyash\Type\Number\FloatType', 
                $res);
        $this->assertEquals(2, $res());
    }
    
    public function testSqrtComplexTypeReturnsComplexType()
    {
        $res = $this->object->sqrt(ComplexTypeFactory::fromString('3+2i'));
        $this->assertInstanceOf(
                '\chippyash\Type\Number\Complex\ComplexType', 
                $res);
        $this->assertEquals('32479891/17872077+17872077/32479891i', (string) $res);
    }

}
