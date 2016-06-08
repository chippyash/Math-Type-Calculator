<?php
namespace Chippyash\Test\Math\Type\Calculator\Native;

use Chippyash\Math\Type\Calculator;
use Chippyash\Type\Number\IntType;
use Chippyash\Type\Number\WholeIntType;
use Chippyash\Type\Number\NaturalIntType;
use Chippyash\Type\Number\FloatType;
use Chippyash\Type\Number\Rational\RationalTypeFactory;
use Chippyash\Type\Number\Complex\ComplexTypeFactory;
use Chippyash\Type\RequiredType;

/**
 *
 */
class CalculatorPowTest extends \PHPUnit_Framework_TestCase
{
    /**
     * System under test
     * @var Calculator
     */
    protected $sut;

    public function setUp()
    {
        RequiredType::getInstance()->set(RequiredType::TYPE_NATIVE);
        $this->sut = new Calculator();
    }

    /**
     * 
     * @dataProvider integerTypes
     */
    public function testPowWithIntegerBaseAndIntegerExponentReturnsIntType($n)
    {
        $this->assertInstanceOf(
                'Chippyash\Type\Number\IntType',
                $this->sut->pow($n, new IntType(3)));
    }
    
    /**
     * 
     * @dataProvider integerTypes
     */
    public function testPowWithIntegerBaseAndFloatExponentReturnsRationalType($n)
    {
        $this->assertInstanceOf(
                'Chippyash\Type\Number\Rational\RationalType',
                $this->sut->pow($n, new FloatType(3.2)));
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
        $test = $this->sut->pow(new IntType(56), ComplexTypeFactory::fromString('0+0i'));
        $this->assertInstanceOf(
                'Chippyash\Type\Number\IntType',
                $test);
        $this->assertEquals(1, $test());
    }
    
    public function testPowWithFloatBaseAndIntegerExponentReturnsFloatType()
    {
        $this->assertInstanceOf(
                'Chippyash\Type\Number\FloatType',
                $this->sut->pow(new FloatType(3.2), new IntType(3)));
    }
    
    public function testPowWithFloatBaseAndFloatExponentReturnsFloatType()
    {
        $this->assertInstanceOf(
                'Chippyash\Type\Number\FloatType',
                $this->sut->pow(new FloatType(3.2), new FloatType(3.2)));
    }

    public function testPowWithFloatBaseAndRationalExponentReturnsFloatType()
    {
        $this->assertInstanceOf(
                'Chippyash\Type\Number\FloatType',
                $this->sut->pow(new FloatType(3.2), RationalTypeFactory::fromFloat(3.2)));
    }

    public function testPowWithFloatTypeBaseAndZeroComplexExponentReturnsIntTypeOne()
    {
        $test = $this->sut->pow(new FloatType(56), ComplexTypeFactory::fromString('0+0i'));
        $this->assertInstanceOf(
                'Chippyash\Type\Number\FloatType',
                $test);
        $this->assertEquals(1, $test());
    }

    public function testPowWithFloatBaseAndComplexExponentReturnsComplexType()
    {
        $this->assertInstanceOf(
            'Chippyash\Type\Number\Complex\ComplexType',
            $this->sut->pow(new FloatType(3.2), ComplexTypeFactory::fromString('3.2+1i')));
    }

    public function testPowWithRationalBaseAndComplexExponentReturnsComplexType()
    {
        $this->assertInstanceOf(
            'Chippyash\Type\Number\Complex\ComplexType',
            $this->sut->pow(RationalTypeFactory::fromFloat(3.2), ComplexTypeFactory::fromString('3.2+1i')));
    }

    public function testPowWithRationalBaseAndZeroComplexExponentReturnsComplexType()
    {
        $this->assertInstanceOf(
            'Chippyash\Type\Number\Complex\ComplexType',
            $this->sut->pow(RationalTypeFactory::fromFloat(3.2), ComplexTypeFactory::fromString('3.2+1i')));
    }

    public function testPowWithRationalBaseReturnsRationalType()
    {
        $r = RationalTypeFactory::fromFloat(2.5);
        $p = $this->sut->pow($r, new IntType(3));
        $this->assertInstanceOf('Chippyash\Type\Number\Rational\RationalType', $p);
        $this->assertEquals('125/8', (string) $p);
        
        $p1 = $this->sut->pow($r, new FloatType(3.2));
        $this->assertInstanceOf('Chippyash\Type\Number\Rational\RationalType', $p1);
        $this->assertEquals('9893770810229553/527173799766761', (string) $p1);
    }
    
    public function testPowWithComplexBaseReturnsComplexType()
    {
        $c1 = ComplexTypeFactory::fromString('3+3i');
        $p = $this->sut->pow($c1, new IntType(3));
        $this->assertInstanceOf('Chippyash\Type\Number\Complex\ComplexType', $p);
        
        $c2 = ComplexTypeFactory::fromString('3+3i');
        $p2 = $this->sut->pow($c1, $c2);
        $this->assertInstanceOf('Chippyash\Type\Number\Complex\ComplexType', $p2);
        
    }
    
    public function testPowWithZeroComplexBaseAndComplexExponentReturnsZeroComplex()
    {
        $c1 = ComplexTypeFactory::fromString('0+0i');
        $c2 = ComplexTypeFactory::fromString('3+3i');
        $p = $this->sut->pow($c1, $c2);
        $this->assertInstanceOf('Chippyash\Type\Number\Complex\ComplexType', $p);
        $this->assertTrue($p->isZero());
    }
    
    public function testCanComputeRootsUsingPow()
    {
        $this->assertEquals(
                3, 
                $this->sut->pow(
                        new IntType(27), RationalTypeFactory::create(1, 3))
                ->get());
        $this->assertEquals(
                '3/4', 
                (string) $this->sut->pow(
                RationalTypeFactory::create(27, 64), RationalTypeFactory::create(1, 3)));
        $this->assertEquals(
                '32479891/17872077+17872077/32479891i',
                (string) $this->sut->pow(
                ComplexTypeFactory::fromString('3+2i'),
                RationalTypeFactory::create(1, 2)));
    }
}
