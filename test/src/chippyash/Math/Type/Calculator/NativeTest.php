<?php
namespace chippyash\Test\Math\Type\Calculator;

use chippyash\Math\Type\Calculator\Native;
use chippyash\Type\Number\IntType;
use chippyash\Type\Number\WholeIntType;
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
}
