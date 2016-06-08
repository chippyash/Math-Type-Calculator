<?php
namespace Chippyash\Test\Math\Type\Calculator\Native;

use Chippyash\Math\Type\Calculator;
use Chippyash\Type\Number\FloatType;
use Chippyash\Type\Number\Rational\RationalTypeFactory;
use Chippyash\Type\Number\Complex\ComplexTypeFactory;
use Chippyash\Type\RequiredType;

class CalculatorNatLogTest extends \PHPUnit_Framework_TestCase
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

    public function testTheNatLogOfEulerConstantIsOne()
    {
        $this->assertEquals(1, $this->sut->natLog(M_E)->get());
        $this->assertEquals(1, $this->sut->natLog(new FloatType(M_E))->get());
        $this->assertEquals(1, $this->sut->natLog(RationalTypeFactory::fromFloat(M_E))->get());
        $this->assertEquals(1, $this->sut->natLog(ComplexTypeFactory::create(RationalTypeFactory::fromFloat(M_E)))->get());
        $this->assertEquals(1, $this->sut->natLog(M_E, ComplexTypeFactory::create(RationalTypeFactory::fromFloat(M_E)))->get());
        $this->assertEquals(1, $this->sut->natLog(M_E, M_E)->get());
        $this->assertEquals(1, $this->sut->natLog(ComplexTypeFactory::create(RationalTypeFactory::create(M_E, M_E)))->get());
    }
    
    public function testTheNatLogOfANonRealComplexIsTheNatLogOfItsModulus()
    {
        $c = ComplexTypeFactory::fromString('15+7i');
        $assertion = \log($c->modulus()->get());
        $this->assertEquals($assertion, $this->sut->natLog($c)->get());
    }
}
