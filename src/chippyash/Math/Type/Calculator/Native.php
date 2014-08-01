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

/**
 * PHP Native calculation
 */
class Native implements CalculatorEngineInterface
{
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
     * Integer division
     * 
     * @param \chippyash\Type\Number\NumericTypeInterface $a
     * @param \chippyash\Type\Number\NumericTypeInterface $b
     * @return \chippyash\Type\Number\Rational\RationalType
     */
    public function intDiv(NI $a, NI $b)
    {
        $ra = RationalTypeFactory::create($a);
        $rb = RationalTypeFactory::create($b);
        return $this->rationalDiv($ra, $rb);
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
        $d = RationalTypeFactory::create($this->lcm($a->denominator()->get(), $b->denominator()->get()));
        $nn = $this->rationalDiv($this->rationalMul($a->numerator(), $d), $a->denominator())->get();
        $nd = $this->rationalDiv($this->rationalMul($b->numerator(), $d), $b->denominator())->get();
        $n = $this->intAdd(new IntType($nn), new IntType($nd));

        return RationalTypeFactory::create($n, $d->numerator());
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
        $d = RationalTypeFactory::create($this->lcm($a->denominator()->get(), $b->denominator()->get()));
        $nn = $this->rationalDiv($this->rationalMul($a->numerator(), $d), $a->denominator())->get();
        $nd = $this->rationalDiv($this->rationalMul($b->numerator(), $d), $b->denominator())->get();
        $n = $this->intSub(new IntType($nn), new IntType($nd));
        
        return RationalTypeFactory::create($n, $d->numerator());
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
        $n = $this->intMul($a->numerator(), $b->numerator());
        $d = $this->intMul($a->denominator(), $b->denominator());

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
        $n = $this->intMul($a->numerator(), $b->denominator());
        $d = $this->intMul($a->denominator(), $b->numerator());

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
        $r = $this->rationalAdd($a->r(), $b->r());
        $i = $this->rationalAdd($a->i(), $b->i());
        return ComplexTypeFactory::create($r, $i);
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
        $r = $this->rationalSub($a->r(), $b->r());
        $i = $this->rationalSub($a->i(), $b->i());
        return ComplexTypeFactory::create($r, $i);
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
        $r = $this->rationalSub($this->rationalMul($a->r(), $b->r()), $this->rationalMul($a->i(), $b->i()));
        $i = $this->rationalAdd($this->rationalMul($a->i(), $b->r()), $this->rationalMul($a->r(), $b->i()));
        return ComplexTypeFactory::create($r, $i);
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
        //div = br^2 + bi^2
        $div = $this->rationalAdd($this->rationalMul($b->r(), $b->r()), $this->rationalMul($b->i(), $b->i()));
        //r = ((ar * br) + (ai * bi))/div
        $r = $this->rationalDiv($this->rationalAdd($this->rationalMul($a->r(), $b->r()), $this->rationalMul($a->i(), $b->i())), $div);
        //i = ((ai * br) - (ar * bi)) / div
        $i = $this->rationalDiv($this->rationalSub($this->rationalMul($a->i(), $b->r()), $this->rationalMul($a->r(), $b->i())), $div);

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

        //div = ar^2 + ai^2
        $div = $this->rationalAdd($this->rationalMul($a->r(), $a->r()), $this->rationalMul($a->i(), $a->i()));
        $r = $this->rationalDiv($a->r(), $div);
        $i = $this->rationalDiv($a->i(), $div);

        return ComplexTypeFactory::create($r, $i);
    }

    /**
     * Convert float or int into relevant strong type
     *
     * @param numeric $num
     * @return \chippyash\Type\Number\FloatType|\chippyash\Type\Number\IntType
     */
    public function convertNumeric($num)
    {
        if (is_float($num)) {
            return new FloatType($num);
        }
        //default
        return new IntType($num);
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
