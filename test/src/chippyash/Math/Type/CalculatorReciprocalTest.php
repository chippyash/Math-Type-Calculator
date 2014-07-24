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
class CalculatorReciprocalTest extends \PHPUnit_Framework_TestCase
{
    protected $object;

    public function setUp()
    {
        $this->object = new Calculator();
    }

    /**
     * @dataProvider numericTypes
     * @param chippyash\Type\Number\NumericTypeInterface $n
     */
    public function testReciprocalOfNumberTypesReturnsFloatType($n)
    {
        $this->assertInstanceOf(
                'chippyash\Type\Number\FloatType',
                $this->object->reciprocal($n));
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
                'chippyash\Type\Number\Rational\RationalType',
                $this->object->reciprocal(RationalTypeFactory::create(2,1)));
    }

    public function testReciprocalOfComplexTypeReturnsComplexType()
    {
        $this->assertInstanceOf(
                'chippyash\Type\Number\Complex\ComplexType',
                $this->object->reciprocal(ComplexTypeFactory::create(2,1)));
    }

    /**
     * @expectedException BadMethodCallException
     * @expectedExceptionMessage Cannot compute reciprocal of zero complex number
     */
    public function testReciprocalOfZeroComplexThrowsException()
    {
        $this->object->reciprocal(ComplexTypeFactory::create(0,0));

    }

    /**
     * @expectedException BadMethodCallException
     * @expectedExceptionMessage No solution for unknown type: stdClass
     */
    public function testReciprocalOfUnknowTypeThrowsException()
    {
        $this->object->reciprocal(new \stdClass());

    }
}
