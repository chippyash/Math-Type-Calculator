<?php
/**
 * Type-Calculator
 *
 * @author Ashley Kitson
 * @copyright Ashley Kitson, 2016, UK
 * @license GPL V3+ See LICENSE.md
 */

namespace Chippyash\Test\Math\Type\IssuesRaised;


use Chippyash\Math\Type\Calculator;
use Chippyash\Type\RequiredType;
use Chippyash\Type\Number\Rational\RationalTypeFactory;

class Issue1Test extends \PHPUnit_Framework_TestCase
{
    /**
     * Calculator
     * @var
     */
    protected $sut;

    protected function setUp()
    {
        RequiredType::getInstance()->set(RequiredType::TYPE_NATIVE);
        $this->sut = new Calculator();
    }

    public function tCase()
    {
        $a = RationalTypeFactory::fromFloat(M_PI);
        $b = RationalTypeFactory::fromFloat(M_E);
        $aa = $a->get();
        $bb = $b->get();
        $mPi = M_PI;
        $mE = M_E;
        $x = $this->sut->sub($a,$b);
        $xx = $x();
        $xRaw = M_PI - M_E;
        $y = $this->sut->add($a,$b);
        $yy = $y();
        $yRaw = M_PI + M_E;
    }

    public function testBigDivision()
    {
        $a = RationalTypeFactory::fromFloat(M_PI);
        $b = RationalTypeFactory::fromFloat(M_E);
        $expected = M_PI / M_E;
        $test = $this->sut->div($a, $b)->get();
        $this->assertEquals($expected, $test);
        RequiredType::getInstance()->set(RequiredType::TYPE_GMP);
        $a = RationalTypeFactory::fromFloat(M_PI);
        $b = RationalTypeFactory::fromFloat(M_E);
        $expected = M_PI / M_E;
        $test = $this->sut->div($a, $b)->get();
        $this->assertEquals($expected, $test);
    }

    public function testBigMultiplication()
    {
        RequiredType::getInstance()->set(RequiredType::TYPE_NATIVE);
        $a = RationalTypeFactory::fromFloat(M_PI);
        $b = RationalTypeFactory::fromFloat(M_E);
        $expected = M_PI * M_E;
        $test = $this->sut->mul($a, $b)->get();
        $this->assertEquals($expected, $test);
    }

    public function testVBigMulDiv()
    {
        $a = 80143857;
        $b = 265081044305386;
        $c = 25510582;

        $aa = RationalTypeFactory::create($a);
        $bb = RationalTypeFactory::create($b);
        $cc = RationalTypeFactory::create($c);

        $expected = $a * $b;
        $test = $this->sut->mul($aa, $bb)->get();
        $this->assertEquals($expected, $test);

//        $expected = 8327766614;
//        $expected = $a * $b / $c;
//        $test = $this->sut->div($this->sut->mul($aa, $bb), $cc)->get();
//        $this->assertEquals($expected, $test);
    }

    public function testIntval()
    {
        $a = 2.1244617308222E+22;
        $this->assertTrue($a > PHP_INT_MAX);
    }
}
