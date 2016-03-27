<?php
namespace Chippyash\Test\Math\Type;

use Chippyash\Math\Type\Comparator;
use Chippyash\Math\Type\Comparator\NativeEngine;
use Chippyash\Type\Number\IntType;
use Chippyash\Type\RequiredType;

/**
 *
 */
class NativeComparatorTest extends \PHPUnit_Framework_TestCase
{
    protected function setUp()
    {
        RequiredType::getInstance()->set(RequiredType::TYPE_NATIVE);
    }

    public function testConstructWithNoParameterReturnsComparator()
    {
        $this->assertInstanceOf(
                'Chippyash\Math\Type\Comparator', new Comparator());
    }

    public function testConstructWithValidEngineTypeReturnsComparator()
    {
        $this->assertInstanceOf(
                'Chippyash\Math\Type\Comparator', new Comparator(Comparator::TYPE_NATIVE));
    }

    public function testConstructWithComparatorEngineInterfaceTypeReturnsComparator()
    {
        $this->assertInstanceOf(
                'Chippyash\Math\Type\Comparator', new Comparator(new NativeEngine()));
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessa No known comparator engine
     */
    public function testConstructWithInvalidComparatorEngineThrowsException()
    {
        $c = new Comparator('foo');
    }

    /**
     * Just check the method returns properly. No need to test
     * all type combinations, that is done in the engine test
     */
    public function testCompareReturnsResult()
    {
        $one = new IntType(1);
        $two = new IntType(2);
        $c = new Comparator(); //use default engine
        $this->assertEquals(0, $c->compare($one, $one));
        $this->assertEquals(1, $c->compare($two, $one));
        $this->assertEquals(-1, $c->compare($one, $two));
    }

    public function testMagicCallReturnsResultForKnownMethod()
    {
        $one = new IntType(1);
        $c = new Comparator(); //use default engine
        $this->assertEquals(true, $c->eq($one, $one));

    }

    /**
     * @expectedException BadMethodCallException
     * @expectedExceptionMessage Unsupported comparator method: foo
     */
    public function testMagicCallThrowsExceptionForUnknownMethod()
    {
        $one = new IntType(1);
        $c = new Comparator(); //use default engine
        $this->assertEquals(true, $c->foo($one, $one));

    }
}
