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
    
    public function testPowWithComplexBaseReturnsComplexType()
    {
        $c1 = ComplexTypeFactory::fromString('3+3i');
        $p = $this->object->pow($c1, new IntType(3));
        $this->assertInstanceOf('chippyash\Type\Number\Complex\ComplexType', $p);
    }
}
