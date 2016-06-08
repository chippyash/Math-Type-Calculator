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
class CalculatorSqrtTest extends \PHPUnit_Framework_TestCase
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

    public function testSqrtIntTypeReturnsIntTypeForPerfectSquares()
    {
        $res = $this->sut->sqrt(new IntType(9));
        $this->assertInstanceOf(
                '\Chippyash\Type\Number\IntType',
                $res);
        $this->assertEquals(3, $res());
    }
    
    public function testSqrtIntTypeReturnsRationalTypeForImperfectSquares()
    {
        $res = $this->sut->sqrt(new IntType(7));
        $this->assertInstanceOf(
                '\Chippyash\Type\Number\Rational\RationalType',
                $res);
        $this->assertEquals('46256493/17483311', (string) $res);
    }
    
    public function testSqrtRationalTypeReturnsRationalType()
    {
        $res = $this->sut->sqrt(RationalTypeFactory::create(7));
        $this->assertInstanceOf(
                '\Chippyash\Type\Number\Rational\RationalType',
                $res);
        $this->assertEquals('46256493/17483311', (string) $res);
    }
    
    public function testSqrtFloatTypeReturnsFloatType()
    {
        $res = $this->sut->sqrt(new FloatType(4));
        $this->assertInstanceOf(
                '\Chippyash\Type\Number\FloatType',
                $res);
        $this->assertEquals(2, $res());
    }
    
    public function testSqrtComplexTypeReturnsComplexType()
    {
        $res = $this->sut->sqrt(ComplexTypeFactory::fromString('3+2i'));
        $this->assertInstanceOf(
                '\Chippyash\Type\Number\Complex\ComplexType',
                $res);
        $this->assertEquals('32479891/17872077+17872077/32479891i', (string) $res);
    }

}
