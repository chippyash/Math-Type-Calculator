<?php
namespace Chippyash\Test\Math\Type\Calculator\Gmp;

use Chippyash\Math\Type\Calculator;
use Chippyash\Type\Number\GMPIntType;
use Chippyash\Type\Number\Rational\RationalTypeFactory;
use Chippyash\Type\Number\Complex\ComplexTypeFactory;
use Chippyash\Type\RequiredType;

/**
 * @requires ext gmp
 */
class CalculatorAddTest extends \PHPUnit_Framework_TestCase
{
    /**
     * System under test
     * @var Calculator
     */
    protected $sut;

    public function setUp()
    {
        RequiredType::getInstance()->set(RequiredType::TYPE_GMP);
        $this->sut = new Calculator();
    }

    public function testAddTwoIntsReturnsIntType()
    {
        $this->assertInstanceOf(
                'Chippyash\Type\Number\GMPIntType',
                $this->sut->add(2, 3));
    }

    public function testAddTwoIntTypesReturnsIntType()
    {
        $this->assertInstanceOf(
                'Chippyash\Type\Number\GMPIntType',
                $this->sut->add(new GMPIntType(2), new GMPIntType(3)));
    }

    public function testAddRationalTypeAndIntReturnsRationalType()
    {
        $this->assertInstanceOf(
                'Chippyash\Type\Number\Rational\GMPRationalType',
                $this->sut->add(RationalTypeFactory::create(1,5), 2));
        $this->assertInstanceOf(
                'Chippyash\Type\Number\Rational\GMPRationalType',
                $this->sut->add(2, RationalTypeFactory::create(1,5)));

    }

    public function testAddRationalTypeAndIntTypeReturnsRationalType()
    {
        $this->assertInstanceOf(
                'Chippyash\Type\Number\Rational\GMPRationalType',
                $this->sut->add(RationalTypeFactory::create(1,5), new GMPIntType(2)));
        $this->assertInstanceOf(
                'Chippyash\Type\Number\Rational\GMPRationalType',
                $this->sut->add(new GMPIntType(2), RationalTypeFactory::create(1,5)));

    }
    
    public function testAddTwoComplexNumbersReturnsComplexNumber()
    {
        $this->assertInstanceOf(
                'Chippyash\Type\Number\Complex\GMPComplexType',
                $this->sut->add(ComplexTypeFactory::create(1,5), ComplexTypeFactory::create(5,1)));
    }

    /**
     * @dataProvider nonComplexNumbers
     * @param numeric $nonComplex
     */
    public function testAddComplexNumbersWithNonComplexNumberReturnsComplexNumber($nonComplex)
    {
        $this->assertInstanceOf(
                'Chippyash\Type\Number\Complex\GMPComplexType',
                $this->sut->add(ComplexTypeFactory::create(1,5), $nonComplex));
    }

    /**
     * @dataProvider nonComplexNumbers
     * @param numeric $nonComplex
     */
    public function testAddNonComplexNumbersWithComplexNumberThrowsException($nonComplex)
    {
        $this->assertInstanceOf(
                'Chippyash\Type\Number\Complex\GMPComplexType',
                $this->sut->add($nonComplex, ComplexTypeFactory::create(1,5)));
    }

    public function nonComplexNumbers()
    {
        //set required type as data created before tests are run
        RequiredType::getInstance()->set(RequiredType::TYPE_GMP);
        return [
            [2],
            [-2.4],
            [new GMPIntType(2)],
            [RationalTypeFactory::create(1,5)],
        ];
    }

    public function testAdditionIsCommutative()
    {
        $a = $this->sut->add(12, 3);
        $b = $this->sut->add(3, 12);
        //a+b = b+a
        $this->assertEquals($a(), $b());
    }

    public function testAdditionIsAssociative()
    {
        $a = 12;
        $b = 3;
        $c = 5;
        //a+(b+c) = (a+b)_c
        $r1 = $this->sut->add($a, $this->sut->add($b, $c));
        $r2 = $this->sut->add($this->sut->add($a, $b), $c);

        $this->assertEquals($r1(), $r2());
    }

    /**
     * @dataProvider correctResults
     * @param mixed $a
     * @param mixed $b
     * @param mixed $r
     */
    public function testAdditionGivesCorrectResults($a, $b, $r)
    {
        $this->assertEquals($r(), $this->sut->add($a, $b)->get());
    }

    public function correctResults()
    {
        //set required type as data created before tests are run
        RequiredType::getInstance()->set(RequiredType::TYPE_GMP);
        return [
            [1,2,new GMPIntType(3)],
            [new GMPIntType(1),2,new GMPIntType(3)],
            [1,new GMPIntType(2),new GMPIntType(3)],
            [new GMPIntType(1),new GMPIntType(2),new GMPIntType(3)],
            [RationalTypeFactory::create(4),RationalTypeFactory::create(4),RationalTypeFactory::create(8)]
        ];
    }
}
