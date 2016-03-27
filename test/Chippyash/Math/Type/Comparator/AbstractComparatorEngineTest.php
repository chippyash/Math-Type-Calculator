<?php
namespace Chippyash\Test\Math\Type\Comparator;

use Chippyash\Type\Number\IntType;

/**
 *
 */
class AbstractComparatorEngineTest extends \PHPUnit_Framework_TestCase
{
    protected $object;

    protected $number;

    public function setUp()
    {
        $this->object = $this->getMockForAbstractClass(
                'Chippyash\Math\Type\Comparator\AbstractComparatorEngine');


        $this->number = new IntType(2);
    }

    public function testEqReturnsBoolean()
    {
         $this->object->expects($this->once())
                ->method('compare')
                ->will($this->returnValue(0));
         $this->assertInternalType('boolean', $this->object->eq($this->number, $this->number));
    }

    public function testNeqReturnsBoolean()
    {
         $this->object->expects($this->once())
                ->method('compare')
                ->will($this->returnValue(1));
         $this->assertInternalType('boolean', $this->object->neq($this->number, $this->number));
    }

    public function testLtReturnsBoolean()
    {
         $this->object->expects($this->once())
                ->method('compare')
                ->will($this->returnValue(-1));
         $this->assertInternalType('boolean', $this->object->lt($this->number, $this->number));
    }

    public function testLteReturnsBoolean()
    {
         $this->object->expects($this->once())
                ->method('compare')
                ->will($this->returnValue(-1));
         $this->assertInternalType('boolean', $this->object->lte($this->number, $this->number));
    }

    public function testGtReturnsBoolean()
    {
         $this->object->expects($this->once())
                ->method('compare')
                ->will($this->returnValue(1));
         $this->assertInternalType('boolean', $this->object->gt($this->number, $this->number));
    }

    public function testGteReturnsBoolean()
    {
         $this->object->expects($this->once())
                ->method('compare')
                ->will($this->returnValue(1));
         $this->assertInternalType('boolean', $this->object->gte($this->number, $this->number));
    }

}
