<?php
namespace Chippyash\Test\Math\Type;

use Chippyash\Math\Type\Calculator;
use Chippyash\Type\Number\IntType;
use Chippyash\Type\Number\WholeIntType;
use Chippyash\Type\Number\NaturalIntType;
use Chippyash\Type\Number\FloatType;
use Chippyash\Type\Number\Rational\RationalTypeFactory;
use Chippyash\Type\Number\Complex\ComplexTypeFactory;

/**
 *
 */
class CalculatorSqrtTest extends \PHPUnit_Framework_TestCase
{
    protected $object;

    public function setUp()
    {
        $this->object = new Calculator();
    }

    public function testSqrtIntTypeReturnsIntTypeForPerfectSquares()
    {
        $res = $this->object->sqrt(new IntType(9));
        $this->assertInstanceOf(
                '\Chippyash\Type\Number\IntType',
                $res);
        $this->assertEquals(3, $res());
    }
    
    public function testSqrtIntTypeReturnsRationalTypeForImperfectSquares()
    {
        $res = $this->object->sqrt(new IntType(7));
        $this->assertInstanceOf(
                '\Chippyash\Type\Number\Rational\RationalType',
                $res);
        $this->assertEquals('46256493/17483311', (string) $res);
    }
    
    public function testSqrtRationalTypeReturnsRationalType()
    {
        $res = $this->object->sqrt(RationalTypeFactory::create(7));
        $this->assertInstanceOf(
                '\Chippyash\Type\Number\Rational\RationalType',
                $res);
        $this->assertEquals('46256493/17483311', (string) $res);
    }
    
    public function testSqrtFloatTypeReturnsFloatType()
    {
        $res = $this->object->sqrt(new FloatType(4));
        $this->assertInstanceOf(
                '\Chippyash\Type\Number\FloatType',
                $res);
        $this->assertEquals(2, $res());
    }
    
    public function testSqrtComplexTypeReturnsComplexType()
    {
        $res = $this->object->sqrt(ComplexTypeFactory::fromString('3+2i'));
        $this->assertInstanceOf(
                '\Chippyash\Type\Number\Complex\ComplexType',
                $res);
        $this->assertEquals('32479891/17872077+17872077/32479891i', (string) $res);
    }

}
