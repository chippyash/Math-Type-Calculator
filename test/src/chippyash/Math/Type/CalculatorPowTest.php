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
class CalculatorPowTest extends \PHPUnit_Framework_TestCase
{
    protected $object;

    public function setUp()
    {
        Calculator::setNumberType(Calculator::TYPE_NATIVE);
        $this->object = new Calculator();
    }

    /**
     * 
     * @dataProvider integerTypes
     */
    public function testPowWithIntegerBaseAndIntegerExponentReturnsIntType($n)
    {
        $this->assertInstanceOf(
                'chippyash\Type\Number\IntType',
                $this->object->pow($n, new IntType(3)));
    }
    
    /**
     * 
     * @dataProvider integerTypes
     */
    public function testPowWithIntegerBaseAndFloatExponentReturnsRationalType($n)
    {
        $this->assertInstanceOf(
                'chippyash\Type\Number\Rational\RationalType',
                $this->object->pow($n, new FloatType(3.2)));
    }

    public function integerTypes()
    {
        return [
            [new IntType(2)],
            [new WholeIntType(2)],
            [new NaturalIntType(2)]
        ];
    }

    public function testPowWithIntTypeBaseAndZeroComplexExponentReturnsIntTypeOne()
    {
        $test = $this->object->pow(new IntType(56), ComplexTypeFactory::fromString('0+0i'));
        $this->assertInstanceOf(
                'chippyash\Type\Number\IntType',
                $test);
        $this->assertEquals(1, $test());
    }
    
    public function testPowWithFloatBaseAndIntegerExponentReturnsFloatType()
    {
        $this->assertInstanceOf(
                'chippyash\Type\Number\FloatType',
                $this->object->pow(new FloatType(3.2), new IntType(3)));
    }
    
    public function testPowWithFloatBaseAndFloatExponentReturnsFloatType()
    {
        $this->assertInstanceOf(
                'chippyash\Type\Number\FloatType',
                $this->object->pow(new FloatType(3.2), new FloatType(3.2)));
    }

    public function testPowWithFloatBaseAndRationalExponentReturnsFloatType()
    {
        $this->assertInstanceOf(
                'chippyash\Type\Number\FloatType',
                $this->object->pow(new FloatType(3.2), RationalTypeFactory::fromFloat(3.2)));
    }

    public function testPowWithFloatTypeBaseAndZeroComplexExponentReturnsIntTypeOne()
    {
        $test = $this->object->pow(new FloatType(56), ComplexTypeFactory::fromString('0+0i'));
        $this->assertInstanceOf(
                'chippyash\Type\Number\FloatType',
                $test);
        $this->assertEquals(1, $test());
    }
    
    public function testPowWithFloatBaseAndComplexExponentReturnsComplexType()
    {
        $this->assertInstanceOf(
                'chippyash\Type\Number\Complex\ComplexType',
                $this->object->pow(new FloatType(3.2), ComplexTypeFactory::fromString('3.2+1i')));
    }

    public function testPowWithRationalBaseReturnsRationalType()
    {
        $r = RationalTypeFactory::fromFloat(2.5);
        $p = $this->object->pow($r, new IntType(3));
        $this->assertInstanceOf('chippyash\Type\Number\Rational\RationalType', $p);
        $this->assertEquals('125/8', (string) $p);
        
        $p1 = $this->object->pow($r, new FloatType(3.2));
        $this->assertInstanceOf('chippyash\Type\Number\Rational\RationalType', $p1);
        $this->assertEquals('9893770810229553/527173799766761', (string) $p1);
        
    }

    public function testPowWithRationalBaseAndComplexExponentReturnsComplexType()
    {
        $r = RationalTypeFactory::fromFloat(2.5);
        $c = ComplexTypeFactory::fromString('1+5i');
        $p = $this->object->pow($r, $c);
        $this->assertInstanceOf('chippyash\Type\Number\Complex\ComplexType', $p);
    }
    
    public function testPowWithRationalBaseAndRealComplexExponentReturnsRationalType()
    {
        $r = RationalTypeFactory::fromFloat(2.5);
        $c = ComplexTypeFactory::fromString('1+0i');
        $p = $this->object->pow($r, $c);
        $this->assertInstanceOf('chippyash\Type\Number\Rational\RationalType', $p);
    }
    
    public function testPowWithRationalBaseAndZeroComplexExponentReturnsRationalTypeWithValueOne()
    {
        $r = RationalTypeFactory::fromFloat(2.5);
        $c = ComplexTypeFactory::fromString('0+0i');
        $p = $this->object->pow($r, $c);
        $this->assertInstanceOf('chippyash\Type\Number\Rational\RationalType', $p);
        $this->assertEquals(1, $p());
    }
    
    public function testPowWithComplexBaseReturnsComplexType()
    {
        $c1 = ComplexTypeFactory::fromString('3+3i');
        $p = $this->object->pow($c1, new IntType(3));
        $this->assertInstanceOf('chippyash\Type\Number\Complex\ComplexType', $p);
        
        $c2 = ComplexTypeFactory::fromString('3+3i');
        $p2 = $this->object->pow($c1, $c2);
        $this->assertInstanceOf('chippyash\Type\Number\Complex\ComplexType', $p2);
        
    }
    
    public function testPowWithZeroComplexBaseAndComplexExponentReturnsZeroComplex()
    {
        $c1 = ComplexTypeFactory::fromString('0+0i');
        $c2 = ComplexTypeFactory::fromString('3+3i');
        $p = $this->object->pow($c1, $c2);
        $this->assertInstanceOf('chippyash\Type\Number\Complex\ComplexType', $p);
        $this->assertTrue($p->isZero());
    }
    
    public function testCanComputeRootsUsingPow()
    {
        $this->assertEquals(
                3, 
                $this->object->pow(
                        new IntType(27), RationalTypeFactory::create(1, 3))
                ->get());
        $this->assertEquals(
                '3/4', 
                (string) $this->object->pow(
                RationalTypeFactory::create(27, 64), RationalTypeFactory::create(1, 3)));
        $this->assertEquals(
                '32479891/17872077+17872077/32479891i',
                (string) $this->object->pow(
                ComplexTypeFactory::fromString('3+2i'),
                RationalTypeFactory::create(1, 2)));
    }
}
