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
class CalculatorReciprocalTest extends \PHPUnit_Framework_TestCase
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
     * @dataProvider numericTypes
     * @param Chippyash\Type\Interfaces\NumericTypeInterface $n
     */
    public function testReciprocalOfNumberTypesReturnsFloatType($n)
    {
        $this->assertInstanceOf(
                'Chippyash\Type\Number\FloatType',
                $this->sut->reciprocal($n));
    }

    public function numericTypes()
    {
        return [
            [new IntType(2)],
            [new WholeIntType(2)],
            [new NaturalIntType(2)],
            [new FloatType(2.3)]
        ];
    }

    public function testReciprocalOfRationalTypeReturnsRationalType()
    {
        $this->assertInstanceOf(
                'Chippyash\Type\Number\Rational\RationalType',
                $this->sut->reciprocal(RationalTypeFactory::create(2,1)));
    }

    public function testReciprocalOfComplexTypeReturnsComplexType()
    {
        $this->assertInstanceOf(
                'Chippyash\Type\Number\Complex\ComplexType',
                $this->sut->reciprocal(ComplexTypeFactory::create(2,1)));
    }

    /**
     * @expectedException BadMethodCallException
     * @expectedExceptionMessage Cannot compute reciprocal of zero complex number
     */
    public function testReciprocalOfZeroComplexThrowsException()
    {
        $this->sut->reciprocal(ComplexTypeFactory::create(0,0));

    }

    /**
     * @expectedException BadMethodCallException
     * @expectedExceptionMessage No solution for unknown type: stdClass
     */
    public function testReciprocalOfUnknownTypeThrowsException()
    {
        $this->sut->reciprocal(new \stdClass());

    }
}
