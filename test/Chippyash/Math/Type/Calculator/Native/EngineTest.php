<?php
namespace Chippyash\Test\Math\Type\Calculator;

use Chippyash\Math\Type\Calculator\NativeEngine;
use Chippyash\Type\Number\IntType;
use Chippyash\Type\Number\WholeIntType;
use Chippyash\Type\Number\FloatType;
use Chippyash\Type\Number\Rational\RationalTypeFactory;
use Chippyash\Type\Number\Complex\ComplexTypeFactory;
use Chippyash\Type\RequiredType;
use Chippyash\Type\TypeFactory;

/**
 * Covers some areas not covered in the main calculator tests
 */
class EngineTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var NativeEngine
     */
    protected $sut;

    public function setUp()
    {
        RequiredType::getInstance()->set(RequiredType::TYPE_NATIVE);
        $this->sut = new NativeEngine();
    }


    public function testIntAddWithNonIntTypesComputesResult()
    {
        $a = new WholeIntType(12);
        $b = new FloatType(12.0);
        $this->assertInstanceOf(
                'Chippyash\Type\Number\IntType',
                $this->sut->intAdd($a, $b));
        $this->assertInstanceOf(
                'Chippyash\Type\Number\IntType',
                $this->sut->intAdd($b, $a));
    }
    
    public function testIntPowReturnsRationalOrIntOrComplexTypes()
    {
        $base = new IntType(5);
        $exp = new IntType(3);
        $this->assertInstanceOf(
                '\Chippyash\Type\Number\IntType',
                $this->sut->intPow($base, $exp));
        $this->assertEquals(125, $this->sut->intPow($base, $exp)->get());
        
        $exp2 = new FloatType(3.5);
        $this->assertInstanceOf(
                '\Chippyash\Type\Number\Rational\RationalType',
                $this->sut->intPow($base, $exp2));
        $this->assertEquals('332922571/1191100', (string) $this->sut->intPow($base, $exp2));
        
        $exp3 = RationalTypeFactory::fromFloat(3.5);
        $this->assertInstanceOf(
                '\Chippyash\Type\Number\Rational\RationalType',
                $this->sut->intPow($base, $exp3));
        $this->assertEquals('332922571/1191100', (string) $this->sut->intPow($base, $exp3));
        
        $base2 = new IntType(4);
        $exp4 = ComplexTypeFactory::fromString('5+3i');
        $pow = $this->sut->intPow($base2, $exp4);
        $this->assertInstanceOf(
                '\Chippyash\Type\Number\Complex\ComplexType',
                $pow);
        $this->assertEquals('-778299179/1445876', (string) $pow->r());
        $this->assertEquals('-861158767/988584', (string) $pow->i());
        
        $exp5 = ComplexTypeFactory::fromString('0+3i');
        $pow = $this->sut->intPow($base2, $exp5);
        $this->assertInstanceOf(
                '\Chippyash\Type\Number\Complex\ComplexType',
                $pow);
        $this->assertEquals('-1722722/3277175', (string) $pow->r());
        $this->assertEquals('-20905959/24575389', (string) $pow->i());
        
        $exp6 = ComplexTypeFactory::fromString('5+0i');
        $pow = $this->sut->intPow($base2, $exp6);
        $this->assertInstanceOf(
                '\Chippyash\Type\Number\Rational\RationalType',
                $pow);
        $this->assertEquals(1024, $pow->get());
    }

}
