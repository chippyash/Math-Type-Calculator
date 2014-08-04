<?php
/*
 * Arithmetic calculation support for chippyash Strong Types
 *
 * @author Ashley Kitson <akitson@zf4.biz>
 * @copyright Ashley Kitson, UK, 2014
 * @licence GPL V3 or later : http://www.gnu.org/licenses/gpl.html
 */
namespace chippyash\Math\Type\Calculator;

use chippyash\Math\Type\Calculator\CalculatorEngineInterface;
use chippyash\Type\Number\NumericTypeInterface as NI;
use chippyash\Type\Number\IntType;
use chippyash\Type\Number\FloatType;
use chippyash\Type\Number\WholeIntType;
use chippyash\Type\Number\NaturalIntType;
use chippyash\Type\Number\Rational\RationalType;
use chippyash\Type\Number\Rational\RationalTypeFactory;
use chippyash\Type\Number\Complex\ComplexType;
use chippyash\Type\Number\Complex\ComplexTypeFactory;
use chippyash\Math\Type\Comparator\Traits\NativeConvertNumeric;

/**
 * PHP Native calculation
 */
class Native implements CalculatorEngineInterface
{
    use NativeConvertNumeric;

    /**
     * Integer addition
     *
     * @param \chippyash\Type\Number\NumericTypeInterface $a
     * @param \chippyash\Type\Number\NumericTypeInterface $b
     * @return \chippyash\Type\Number\IntType
     */
    public function intAdd(NI $a, NI $b)
    {
        return new IntType($a() + $b());
    }

    /**
     * Integer subtraction
     *
     * @param \chippyash\Type\Number\NumericTypeInterface $a
     * @param \chippyash\Type\Number\NumericTypeInterface $b
     * @return \chippyash\Type\Number\IntType
     */
    public function intSub(NI $a, NI $b)
    {
        return new IntType($a() - $b());
    }

    /**
     * Integer multiplication
     *
     * @param \chippyash\Type\Number\NumericTypeInterface $a
     * @param \chippyash\Type\Number\NumericTypeInterface $b
     * @return \chippyash\Type\Number\IntType
     */
    public function intMul(NI $a, NI $b)
    {
        return new IntType($a() * $b());
    }

    /**
     * Float addition
     *
     * @param \chippyash\Type\Number\NumericTypeInterface $a
     * @param \chippyash\Type\Number\NumericTypeInterface $b
     * @return \chippyash\Type\Number\FloatType
     */
    public function floatAdd(NI $a, NI $b)
    {
        return new FloatType($a() + $b());
    }

    /**
     * Float subtraction
     *
     * @param \chippyash\Type\Number\NumericTypeInterface $a
     * @param \chippyash\Type\Number\NumericTypeInterface $b
     * @return \chippyash\Type\Number\FloatType
     */
    public function floatSub(NI $a, NI $b)
    {
        return new FloatType($a() - $b());
    }

    /**
     * Float multiplication
     *
     * @param \chippyash\Type\Number\NumericTypeInterface $a
     * @param \chippyash\Type\Number\NumericTypeInterface $b
     * @return \chippyash\Type\Number\FloatType
     */
    public function floatMul(NI $a, NI $b)
    {
        return new FloatType($a() * $b());
    }

    /**
     * Float division
     *
     * @param \chippyash\Type\Number\NumericTypeInterface $a
     * @param \chippyash\Type\Number\NumericTypeInterface $b
     * @return \chippyash\Type\Number\FloatType
     */
    public function floatDiv(NI $a, NI $b)
    {
        return new FloatType($a() / $b());
    }

    /**
     * Float reciprocal i.e. 1/a
     * @param \chippyash\Type\Number\NumericTypeInterface $a
     * @return \chippyash\Type\Number\FloatType
     */
    public function floatReciprocal(NI $a)
    {
        return $this->floatDiv(new IntType(1), $a);
    }

    /**
     * Whole number addition
     *
     * @param \chippyash\Type\Number\NumericTypeInterface $a
     * @param \chippyash\Type\Number\NumericTypeInterface $b
     * @return \chippyash\Type\Number\WholeIntType
     */
    public function wholeAdd(NI $a, NI $b)
    {
        return new WholeIntType($a() + $b());
    }

    /**
     * Whole number subtraction
     *
     * @param \chippyash\Type\Number\NumericTypeInterface $a
     * @param \chippyash\Type\Number\NumericTypeInterface $b
     * @return \chippyash\Type\Number\WholeIntType
     */
    public function wholeSub(NI $a, NI $b)
    {
        return new WholeIntType($a() - $b());
    }

    /**
     * Whole number multiplication
     *
     * @param \chippyash\Type\Number\NumericTypeInterface $a
     * @param \chippyash\Type\Number\NumericTypeInterface $b
     * @return \chippyash\Type\Number\WholeIntType
     */
    public function wholeMul(NI $a, NI $b)
    {
        return new WholeIntType($a() * $b());
    }

    /**
     * Natural number addition
     *
     * @param \chippyash\Type\Number\NumericTypeInterface $a
     * @param \chippyash\Type\Number\NumericTypeInterface $b
     * @return \chippyash\Type\Number\NaturalIntType
     */
    public function naturalAdd(NI $a, NI $b)
    {
        return new NaturalIntType($a() + $b());
    }

    /**
     * Natural number subtraction
     *
     * @param \chippyash\Type\Number\NumericTypeInterface $a
     * @param \chippyash\Type\Number\NumericTypeInterface $b
     * @return \chippyash\Type\Number\NaturalIntType
     */
    public function naturalSub(NI $a, NI $b)
    {
        return new NaturalIntType($a() - $b());
    }

    /**
     * Natural number multiplication
     *
     * @param \chippyash\Type\Number\NumericTypeInterface $a
     * @param \chippyash\Type\Number\NumericTypeInterface $b
     * @return \chippyash\Type\Number\NaturalIntType
     */
    public function naturalMul(NI $a, NI $b)
    {
        return new NaturalIntType($a() * $b());
    }

    /**
     * Rational number addition
     *
     * @param \chippyash\Type\Number\NumericTypeInterface $a
     * @param \chippyash\Type\Number\NumericTypeInterface $nonR
     * @return \chippyash\Type\Number\Rational\RationalType
     */
    public function rationalAdd(NI $a, NI $b)
    {
        if (!$a instanceof RationalType) {
            $a = RationalTypeFactory::create($a);
        }
        if (!$b instanceof RationalType) {
            $b = RationalTypeFactory::create($b);
        }
        $d = $this->lcm($a->denominator(), $b->denominator());
        $n = ($a->numerator() * $d / $a->denominator()) +
             ($b->numerator() * $d / $b->denominator());
        return RationalTypeFactory::create($n, $d);
    }

    /**
     * Rational number subtraction
     *
     * @param \chippyash\Type\Number\NumericTypeInterface $a
     * @param \chippyash\Type\Number\NumericTypeInterface $b
     * @return \chippyash\Type\Number\Rational\RationalType
     */
    public function rationalSub(NI $a, NI $b)
    {
        if (!$a instanceof RationalType) {
            $a = RationalTypeFactory::create($a);
        }
        if (!$b instanceof RationalType) {
            $b = RationalTypeFactory::create($b);
        }
        $d = $this->lcm($a->denominator(), $b->denominator());
        $n = ($a->numerator() * $d / $a->denominator()) -
             ($b->numerator() * $d / $b->denominator());

        return RationalTypeFactory::create($n, $d);
    }

    /**
     * Rational number multiplication
     *
     * @param \chippyash\Type\Number\NumericTypeInterface $a
     * @param \chippyash\Type\Number\NumericTypeInterface $b
     * @return \chippyash\Type\Number\Rational\RationalType
     */
    public function rationalMul(NI $a, NI $b)
    {
        if (!$a instanceof RationalType) {
            $a = RationalTypeFactory::create($a);
        }
        if (!$b instanceof RationalType) {
            $b = RationalTypeFactory::create($b);
        }
        $n = $a->numerator() * $b->numerator();
        $d = $a->denominator() * $b->denominator();

        return RationalTypeFactory::create($n, $d);
    }

    /**
     * Rational number division
     *
     * @param \chippyash\Type\Number\NumericTypeInterface $a
     * @param \chippyash\Type\Number\NumericTypeInterface $b
     * @return \chippyash\Type\Number\Rational\RationalType
     */
    public function rationalDiv(NI $a, NI $b)
    {
        if (!$a instanceof RationalType) {
            $a = RationalTypeFactory::create($a);
        }
        if (!$b instanceof RationalType) {
            $b = RationalTypeFactory::create($b);
        }
        $n = $a->numerator() * $b->denominator();
        $d = $a->denominator() * $b->numerator();

        return RationalTypeFactory::create($n, $d);
    }

    /**
     * Rational number reciprocal: 1/r
     *
     * @param \\chippyash\Type\Number\Rational\RationalType $a
     * @return \chippyash\Type\Number\Rational\RationalType
     */
    public function rationalReciprocal(RationalType $a)
    {
        return RationalTypeFactory::create($a->denominator(), $a->numerator());
    }

    /**
     * Complex number addition
     *
     * @param \chippyash\Type\Number\Complex\ComplexType $a
     * @param \chippyash\Type\Number\Complex\ComplexType $b
     * @return \chippyash\Type\Number\Complex\ComplexType
     */
    public function complexAdd(ComplexType $a, ComplexType $b)
    {
        return ComplexTypeFactory::create($a->r() + $b->r(), $a->i() + $b->i());
    }

    /**
     * Complex number subtraction
     *
     * @param \chippyash\Type\Number\Complex\ComplexType $a
     * @param \chippyash\Type\Number\Complex\ComplexType $b
     * @return \chippyash\Type\Number\Complex\ComplexType
     */
    public function complexSub(ComplexType $a, ComplexType $b)
    {
        return ComplexTypeFactory::create($a->r() - $b->r(), $a->i() - $b->i());
    }

    /**
     * Complex number multiplication
     *
     * @param \chippyash\Type\Number\Complex\ComplexType $a
     * @param \chippyash\Type\Number\Complex\ComplexType $b
     * @return \chippyash\Type\Number\Complex\ComplexType
     */
    public function complexMul(ComplexType $a, ComplexType $b)
    {
        return ComplexTypeFactory::create(
                ($a->r() * $b->r()) - ($a->i() * $b->i()),
                ($a->i() * $b->r()) + ($a->r() * $b->i()));
    }

    /**
     * Complex number division
     *
     * @param \chippyash\Type\Number\Complex\ComplexType $a
     * @param \chippyash\Type\Number\Complex\ComplexType $b
     * @return \chippyash\Type\Number\Complex\ComplexType
     * @throws \BadMethodCallException
     */
    public function complexDiv(ComplexType $a, ComplexType $b)
    {
        if ($b->isZero()) {
            throw new \BadMethodCallException('Cannot divide complex number by zero complex number');
        }
        $div = pow($b->r(),2) + pow($b->i(),2);
        $r = (($a->r() * $b->r()) + ($a->i() * $b->i()))/$div;
        $i = (($a->i() * $b->r()) - ($a->r() * $b->i()))/$div;

        return ComplexTypeFactory::create($r, $i);
    }

    /**
     * Complex number reciprocal: 1/a+bi
     *
     * @param \chippyash\Type\Number\Complex\ComplexType $a
     * @return \chippyash\Type\Number\Complex\ComplexType
     * @throws \BadMethodCallException
     */
    public function complexReciprocal(ComplexType $a)
    {
        if ($a->isZero()) {
            throw new \BadMethodCallException('Cannot compute reciprocal of zero complex number');
        }

        $div = pow($a->r(),2) + pow($a->i(),2);
        $r = $a->r() / $div;
        $i = $a->i() / $div;

        return ComplexTypeFactory::create($r, $i);
    }

    /**
     * Return Greatest Common Denominator of two numbers
     *
     * @param int $a
     * @param int $b
     * @return int
     */
    private function gcd($a, $b)
    {
        return $b ? $this->gcd($b, $a % $b) : $a;
    }

    /**
     * Return Least Common Multiple of two numbers
     * @param int $a
     * @param int $b
     * @return int
     */
    private function lcm($a, $b)
    {
        return \abs(($a * $b) / $this->gcd($a, $b));
    }
}
