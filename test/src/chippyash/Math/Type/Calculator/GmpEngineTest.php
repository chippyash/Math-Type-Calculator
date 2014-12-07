<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of GmpEngineTest
 *
 * @author akitson
 */
class GmpEngineTest
{
    public function testNatLogReturnsRationalType()
    {
        $this->assertInstanceOf(
                'chippyash\Type\Number\Rational\RationalType',
                $this->object->natLog($this->bigInt));
    }
    
    public function testNatLogReturnsCorrectResultForIntType()
    {
        $this->assertEquals(2.4849066497880008, $this->object->natLog($this->bigInt)->get());
    }

    public function testNatLogReturnsCorrectResultForWholintType()
    {
        $this->assertEquals(2.4849066497880008, $this->object->natLog(TypeFactory::create('whole', 12))->get());
    }

    public function testNatLogReturnsCorrectResultForNaturalintType()
    {
        $this->assertEquals(2.4849066497880008, $this->object->natLog(TypeFactory::create('natural', 12))->get());
    }

    public function testNatLogReturnsCorrectResultForFloatType()
    {
        $this->assertEquals(2.4849066497880008, $this->object->natLog(TypeFactory::create('float', 12))->get());
    }

    public function testNatLogReturnsCorrectResultForRationalType()
    {
        $this->assertEquals(2.4849066497880008, $this->object->natLog(TypeFactory::create('rational', 12))->get());
    }

    public function testNatLogReturnsCorrectResultForRationalComplexType()
    {
        $this->assertEquals(2.4849066497880008, $this->object->natLog(TypeFactory::create('complex', '12+0i'))->get());
    }

    public function testNatLogReturnsCorrectResultForNonRationalComplexTypeByUsingModulus()
    {
        $this->assertEquals(
                2.5152189606962181, 
                $this->object->natLog(TypeFactory::create('complex', '12+3i'))->get());
    }
    

}
