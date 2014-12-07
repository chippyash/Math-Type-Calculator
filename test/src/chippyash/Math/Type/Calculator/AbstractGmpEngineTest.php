<?php

namespace chippyash\Math\Type\Calculator;

use chippyash\Math\Type\Calculator;
use chippyash\Type\TypeFactory;

/**
 * Test abstract engine using Gmp calculator
 * 
 * @requires extension gmp
 * @runTestsInSeparateProcesses
 */
class AbstractGmpEngineTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var AbstractEngine
     */
    protected $object;

    protected $bigInt;
    
    /**
     * Set up abstract using PHP native calculations
     */
    protected function setUp()
    {
        Calculator::setNumberType(Calculator::TYPE_GMP);
        $this->object = $this->getMockForAbstractClass(
                'chippyash\Math\Type\Calculator\AbstractEngine',
                [new Calculator()]);
        $this->bigInt = TypeFactory::createInt(12);
    }

    public function testIncReplacesOriginalValueAndDefaultsIncToOne()
    {
        $a = $this->bigInt;
        $val = $a();
        $this->object->inc($a);
        $this->assertEquals($val + 1, $a());
    }
    
    public function testIncAcceptsAnIncrementValue()
    {
        $a = $this->bigInt;
        $val = $a();
        $this->object->inc($a, TypeFactory::createRational(2, 3));
        $this->assertEquals($val + (2/3), $a());
    }
    
    public function testIncCanIncrementAnInteger()
    {
        $a = TypeFactory::create('int', 12);
        $v = $a();
        $this->object->inc($a);
        $this->assertEquals($v+1, $a());
    }
    
    public function testIncCanIncrementAWholeint()
    {
        $a = TypeFactory::create('whole', 12);
        $v = $a();
        $this->object->inc($a);
        $this->assertEquals($v+1, $a());
    }
    
    public function testIncCanIncrementANaturalint()
    {
        $a = TypeFactory::create('natural', 12);
        $v = $a();
        $this->object->inc($a);
        $this->assertEquals($v+1, $a());
    }
    
    public function testIncCanIncrementAFloat()
    {
        $a = TypeFactory::create('float', 12);
        $v = $a();
        $this->object->inc($a);
        $this->assertEquals($v+1, $a());
    }
    
    public function testIncCanIncrementARational()
    {
        $a = TypeFactory::create('rational', '12/5');
        $v = $a();
        $this->object->inc($a);
        $this->assertEquals($v+1, $a());
    }
    
    public function testIncCanIncrementARationalComplex()
    {
        $a = TypeFactory::create('complex', '12+0i');
        $v = $a();
        $this->object->inc($a);
        $this->assertEquals($v+1, $a());
    }
    
    public function testIncCanIncrementANonRationalComplex()
    {
        $a = TypeFactory::create('complex', '12+3i');
        $v = $a();
        $this->object->inc($a);
        $this->assertEquals('13+3i', $a());
    }
    
    public function testIncCanIncrementWithIntegerIncrementor()
    {
        $inc = TypeFactory::create('int', 2);
        $a = TypeFactory::create('int', 12);
        $v = $a();
        $this->object->inc($a, $inc);
        $this->assertEquals($v+2, $a());
    }
    
    public function testIncCanIncrementWithFloatIncrementor()
    {
        $inc = TypeFactory::create('float', 2);
        $a = TypeFactory::create('int', 12);
        $v = $a();
        $this->object->inc($a, $inc);
        $this->assertEquals($v+2, $a());
    }
    
    public function testIncCanIncrementWithRationalIncrementor()
    {
        $inc = TypeFactory::create('rational', 2);
        $a = TypeFactory::create('int', 12);
        $v = $a();
        $this->object->inc($a, $inc);
        $this->assertEquals($v+2, $a());
    }
    
    public function testIncCanIncrementWithRealComplexIncrementor()
    {
        $inc = TypeFactory::create('complex', '2+0i');
        $a = TypeFactory::create('int', 12);
        $v = $a();
        $this->object->inc($a, $inc);
        $this->assertEquals($v+2, $a());
    }
    
    public function testIncCanIncrementWithNonRealComplexIncrementor()
    {
        $inc = TypeFactory::create('complex', '2+3i');
        $a = TypeFactory::create('int', 12);
        $v = $a();
        $this->object->inc($a, $inc);
        $this->assertEquals('14+3i', $a());
    }
    
    public function testDecReplacesOriginalValueAndDefaultsIncToOne()
    {
        $a = $this->bigInt;
        $val = $a();
        $this->object->dec($a);
        $this->assertEquals($val - 1, $a());
    }
    
    public function testDecAcceptsADecrementValue()
    {
        $a = $this->bigInt;
        $val = $a();
        $this->object->dec($a, TypeFactory::createRational(2, 3));
        $this->assertEquals($val - (2/3), $a());
    }

    public function testDecCanDecrementAnInteger()
    {
        $a = TypeFactory::create('int', 12);
        $v = $a();
        $this->object->dec($a);
        $this->assertEquals($v-1, $a());
    }
    
    public function testDecCanDecrementAWholeint()
    {
        $a = TypeFactory::create('whole', 12);
        $v = $a();
        $this->object->dec($a);
        $this->assertEquals($v-1, $a());
    }
    
    public function testDecCanDecrementANaturalint()
    {
        $a = TypeFactory::create('natural', 12);
        $v = $a();
        $this->object->dec($a);
        $this->assertEquals($v-1, $a());
    }
    
    public function testDecCanDecrementAFloat()
    {
        $a = TypeFactory::create('float', 12);
        $v = $a();
        $this->object->dec($a);
        $this->assertEquals($v-1, $a());
    }
    
    public function testDecCanDecrementARational()
    {
        $a = TypeFactory::create('rational', '12/5');
        $v = $a();
        $this->object->dec($a);
        $this->assertEquals($v-1, $a());
    }
    
    public function testDecCanDecrementARationalComplex()
    {
        $a = TypeFactory::create('complex', '12+0i');
        $v = $a();
        $this->object->dec($a);
        $this->assertEquals($v-1, $a());
    }
    
    public function testDecCanDecrementANonRationalComplex()
    {
        $a = TypeFactory::create('complex', '12+3i');
        $v = $a();
        $this->object->dec($a);
        $this->assertEquals('11+3i', $a());
    }
    
    public function testDecCanDecrementWithIntegerDecrementor()
    {
        $dec = TypeFactory::create('int', 2);
        $a = TypeFactory::create('int', 12);
        $v = $a();
        $this->object->dec($a, $dec);
        $this->assertEquals($v-2, $a());
    }
    
    public function testDecCanDecrementWithFloatDecrementor()
    {
        $dec = TypeFactory::create('float', 2);
        $a = TypeFactory::create('int', 12);
        $v = $a();
        $this->object->dec($a, $dec);
        $this->assertEquals($v-2, $a());
    }
    
    public function testDecCanDecrementWithRationalDecrementor()
    {
        $dec = TypeFactory::create('rational', 2);
        $a = TypeFactory::create('int', 12);
        $v = $a();
        $this->object->dec($a, $dec);
        $this->assertEquals($v-2, $a());
    }
    
    public function testDecCanDecrementWithRealComplexDecrementor()
    {
        $dec = TypeFactory::create('complex', '2+0i');
        $a = TypeFactory::create('int', 12);
        $v = $a();
        $this->object->dec($a, $dec);
        $this->assertEquals($v-2, $a());
    }
    
    public function testDecCanDecrementWithNonRealComplexDecrementor()
    {
        $dec = TypeFactory::create('complex', '2+3i');
        $a = TypeFactory::create('int', 12);
        $v = $a();
        $this->object->dec($a, $dec);
        $this->assertEquals('10-3i', $a());
    }
}
