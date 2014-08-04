<?php
namespace chippyash\Test\Math\Type\Calculator;

use chippyash\Math\Type\Calculator\Native;
use chippyash\Type\Number\IntType;
use chippyash\Type\Number\WholeIntType;
use chippyash\Type\Number\NaturalIntType;
use chippyash\Type\Number\FloatType;
use chippyash\Type\Number\Rational\RationalTypeFactory;
use chippyash\Type\Number\Complex\ComplexTypeFactory;

/**
 * Covers some areas not covered in the main calculator tests
 */
class NativeTest extends \PHPUnit_Framework_TestCase
{
    protected $object;

    public function setUp()
    {
        $this->object = new Native();
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
}
