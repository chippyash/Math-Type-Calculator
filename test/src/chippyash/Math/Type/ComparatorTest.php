<?php
namespace chippyash\Test\Math\Type;

use chippyash\Math\Type\Comparator;
use chippyash\Math\Type\Comparator\Native;
use chippyash\Type\Number\IntType;
use chippyash\Type\Number\WholeIntType;
use chippyash\Type\Number\NaturalIntType;
use chippyash\Type\Number\FloatType;
use chippyash\Type\Number\Rational\RationalTypeFactory;
use chippyash\Type\Number\Complex\ComplexTypeFactory;

/**
 *
 */
class ComparatorTest extends \PHPUnit_Framework_TestCase
{
    public function testConstructWithNoParameterReturnsComparator()
    {
        $this->assertInstanceOf(
                'chippyash\Math\Type\Comparator', new Comparator());
    }

    public function testConstructWithValidEngineTypeReturnsComparator()
    {
        $this->assertInstanceOf(
                'chippyash\Math\Type\Comparator', new Comparator(Comparator::ENGINE_NATIVE));
    }

    public function testConstructWithComparatorEngineInterfaceTypeReturnsComparator()
    {
        $this->assertInstanceOf(
                'chippyash\Math\Type\Comparator', new Comparator(new Native()));
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
