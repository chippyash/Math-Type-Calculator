<?php
/*
 * Arithmetic calculation support for chippyash Strong Types
 *
 * @author Ashley Kitson <akitson@zf4.biz>
 * @copyright Ashley Kitson, UK, 2014
 * @licence GPL V3 or later : http://www.gnu.org/licenses/gpl.html
 */
namespace chippyash\Math\Type\Calculator;

use chippyash\Math\Type\Calculator\AbstractEngine;
use chippyash\Math\Type\Calculator\CalculatorEngineInterface;
use chippyash\Type\TypeFactory;
use chippyash\Type\Interfaces\NumericTypeInterface as NI;
use chippyash\Type\Number\GMPIntType;
use chippyash\Type\Number\FloatType;
use chippyash\Type\Number\Rational\GMPRationalType;
use chippyash\Type\Number\Rational\RationalTypeFactory;
use chippyash\Type\Number\Complex\AbstractComplexType;
use chippyash\Type\Number\Complex\GMPComplexType;
use chippyash\Type\Number\Complex\ComplexTypeFactory;
use chippyash\Math\Type\Traits\GmpConvertNumeric;
use chippyash\Math\Type\Traits\CheckGmpRationalTypes;
use chippyash\Math\Type\Traits\CheckGmpIntTypes;
use chippyash\Math\Type\Traits\CheckGmpFloatTypes;
use chippyash\Math\Type\Traits\CheckGmpComplexTypes;
use chippyash\Math\Type\Comparator;

/**
 * GMP calculation
 */
class GmpEngine extends AbstractEngine implements CalculatorEngineInterface
{
    use GmpConvertNumeric;
    use CheckGmpRationalTypes;
    use CheckGmpIntTypes;
    use CheckGmpFloatTypes;
    use CheckGmpComplexTypes;

    /**
     * Integer type addition
     *
     * @param chippyash\Type\Interfaces\NumericTypeInterface $a
     * @param chippyash\Type\Interfaces\NumericTypeInterface $b
     * @return \chippyash\Type\Number\GMPIntType
     */
    public function intAdd(NI $a, NI $b)
    {
        list($a, $b) = $this->checkIntTypes($a, $b);

        return new GMPIntType(gmp_add($a->gmp(), $b->gmp()));
    }

    /**
     * Integer type subtraction
     *
     * @param chippyash\Type\Interfaces\NumericTypeInterface $a
     * @param chippyash\Type\Interfaces\NumericTypeInterface $b
     * @return \chippyash\Type\Number\GMPIntType
     */
    public function intSub(NI $a, NI $b)
    {
        list($a, $b) = $this->checkIntTypes($a, $b);

        return new GMPIntType(gmp_sub($a->gmp(), $b->gmp()));
    }

    /**
     * Integer type multiplication
     *
     * @param chippyash\Type\Interfaces\NumericTypeInterface $a
     * @param chippyash\Type\Interfaces\NumericTypeInterface $b
     * @return \chippyash\Type\Number\GMPIntType
     */
    public function intMul(NI $a, NI $b)
    {
        list($a, $b) = $this->checkIntTypes($a, $b);

        return new GMPIntType(gmp_mul($a->gmp(), $b->gmp()));
    }

    /**
     * Integer division
     * Integer division is simply a case of creating a rational
     * number i.e. a/b
     *
     * @param chippyash\Type\Interfaces\NumericTypeInterface $a
     * @param chippyash\Type\Interfaces\NumericTypeInterface $b
     * @return \chippyash\Type\Number\Rational\RationalType
     */
    public function intDiv(NI $a, NI $b)
    {
        list($a, $b) = $this->checkIntTypes($a, $b);
        return RationalTypeFactory::create($a, $b);
    }
    
    /**
     * Integer Pow - raise number to the exponent
     * Will return an IntType, RationalType or ComplexType
     * 
     * @todo Implement taylor series POW method
     * @param chippyash\Type\Interfaces\NumericTypeInterface $a
     * @param chippyash\Type\Interfaces\NumericTypeInterface $exp Exponent
     * @return chippyash\Type\Interfaces\NumericTypeInterface
     */
    public function intPow(NI $a, NI $exp)
    {
        if ($exp instanceof GMPRationalType) {
            return $this->rationalPow(RationalTypeFactory::create(clone $a), $exp);
        }
        
        if ($exp instanceof GMPComplexType) {
            return $this->intComplexPow($a, $exp);
        }
        
        //int and float types
        $p = pow($a(), $exp());
        if (($p - intval($p)) === 0) {
            return new GMPIntType($p);
        }
        
        return RationalTypeFactory::fromFloat($p);
    }
    
    /**
     * Integer sqrt
     * Return GmpIntType for perfect squares, else GMPRationalType
     * 
     * @param \chippyash\Type\Interfaces\NumericTypeInterface $a
     * @return \chippyash\Type\Number\GmpIntType|\chippyash\Type\Number\Rational\GMPRationalType result
     */
    public function intSqrt(NI $a)
    {
        $res = $this->rationalSqrt(RationalTypeFactory::create($a));
        if ($res->isInteger()) {
            return $res->numerator();
        } else {
            return $res;
        }
    }
    
    /**
     * Float addition
     *
     * @param chippyash\Type\Interfaces\NumericTypeInterface $a
     * @param chippyash\Type\Interfaces\NumericTypeInterface $b
     * @return \chippyash\Type\Number\Rational\GMPRationalType
     */
    public function floatAdd(NI $a, NI $b)
    {
        list($a, $b) = $this->checkFloatTypes($a, $b);
        
        return $this->rationalAdd($a, $b);
    }

    /**
     * Float subtraction
     *
     * @param chippyash\Type\Interfaces\NumericTypeInterface $a
     * @param chippyash\Type\Interfaces\NumericTypeInterface $b
     * @return \chippyash\Type\Number\Rational\GMPRationalType
     */
    public function floatSub(NI $a, NI $b)
    {
        list($a, $b) = $this->checkFloatTypes($a, $b);
        
        return $this->rationalSub($a, $b);
    }

    /**
     * Float multiplication
     *
     * @param chippyash\Type\Interfaces\NumericTypeInterface $a
     * @param chippyash\Type\Interfaces\NumericTypeInterface $b
     * @return \chippyash\Type\Number\Rational\GMPRationalType
     */
    public function floatMul(NI $a, NI $b)
    {
        list($a, $b) = $this->checkFloatTypes($a, $b);
        
        return $this->rationalMul($a, $b);
    }

    /**
     * Float division
     *
     * @param chippyash\Type\Interfaces\NumericTypeInterface $a
     * @param chippyash\Type\Interfaces\NumericTypeInterface $b
     * @return \chippyash\Type\Number\Rational\GMPRationalType
     */
    public function floatDiv(NI $a, NI $b)
    {
        list($a, $b) = $this->checkFloatTypes($a, $b);
        
        return $this->rationalDiv($a, $b);
    }

    /**
     * Float reciprocal i.e. 1/a
     * @param chippyash\Type\Interfaces\NumericTypeInterface $a
     * @return \chippyash\Type\Number\Rational\GMPRationalType
     */
    public function floatReciprocal(NI $a)
    {
        return $this->rationalReciprocal($this->checkFloatType($a));
    }

    /**
     * Float Pow - raise number to the exponent
     * Will return a float type
     * 
     * @param chippyash\Type\Interfaces\NumericTypeInterface $a
     * @param chippyash\Type\Interfaces\NumericTypeInterface $exp Exponent
     * @return \chippyash\Type\Number\Rational\GMPRationalType
     */
    public function floatPow(NI $a, NI $exp)
    {
        return $this->rationalPow($this->checkFloatType($a), $exp);
    }
    
    /**
     * Float sqrt
     * 
     * @param chippyash\Type\Interfaces\NumericTypeInterface $a
     * @return \chippyash\Type\Number\Rational\GMPRationalType
     */
    public function floatSqrt(NI $a)
    {
        return $this->rationalSqrt($this->checkFloatType($a));
    }

    /**
     * Whole number addition
     * Proxy to intAdd
     * NB you lose the protection of whole types
     * 
     * @param chippyash\Type\Interfaces\NumericTypeInterface $a
     * @param chippyash\Type\Interfaces\NumericTypeInterface $b
     * @return \chippyash\Type\Number\GmpIntType
     */
    public function wholeAdd(NI $a, NI $b)
    {
        return $this->intAdd($a, $b);
    }

    /**
     * Whole number subtraction
     * Proxy to intSub
     * NB you lose the protection of whole types
     * 
     * @param chippyash\Type\Interfaces\NumericTypeInterface $a
     * @param chippyash\Type\Interfaces\NumericTypeInterface $b
     * @return \chippyash\Type\Number\GmpIntType
     */
    public function wholeSub(NI $a, NI $b)
    {
        return $this->intSub($a, $b);
    }

    /**
     * Whole number multiplication
     * Proxy to intMul
     * NB you lose the protection of whole types
     * 
     * @param chippyash\Type\Interfaces\NumericTypeInterface $a
     * @param chippyash\Type\Interfaces\NumericTypeInterface $b
     * @return \chippyash\Type\Number\GmpIntType
     */
    public function wholeMul(NI $a, NI $b)
    {
        return $this->intMul($a, $b);
    }

    /**
     * Natural number addition
     * Proxy to IntAdd
     * NB you lose the protection of natural types
     * 
     * @param chippyash\Type\Interfaces\NumericTypeInterface $a
     * @param chippyash\Type\Interfaces\NumericTypeInterface $b
     * @return \chippyash\Type\Number\GmpIntType
     */
    public function naturalAdd(NI $a, NI $b)
    {
        return $this->intAdd($a, $b);
    }

    /**
     * Natural number subtraction
     * Proxy to intSub
     * NB you lose the protection of natural types
     * 
     * @param chippyash\Type\Interfaces\NumericTypeInterface $a
     * @param chippyash\Type\Interfaces\NumericTypeInterface $b
     * @return \chippyash\Type\Number\GmpIntType
     */
    public function naturalSub(NI $a, NI $b)
    {
        return $this->intSub($a, $b);
    }

    /**
     * Natural number multiplication
     * Proxy to intMul
     * NB you lose the protection of natural types
     * 
     * @param chippyash\Type\Interfaces\NumericTypeInterface $a
     * @param chippyash\Type\Interfaces\NumericTypeInterface $b
     * @return \chippyash\Type\Number\GmpIntType
     */
    public function naturalMul(NI $a, NI $b)
    {
        return $this->intMul($a, $b);
    }

    /**
     * Rational number addition
     * 
     * @param chippyash\Type\Interfaces\NumericTypeInterface $a
     * @param chippyash\Type\Interfaces\NumericTypeInterface $b
     * @return \chippyash\Type\Number\Rational\RationalType
     */
    public function rationalAdd(NI $a, NI $b)
    {
        list($a, $b) = $this->checkRationalTypes($a, $b);

        $d = RationalTypeFactory::create($this->lcm($a->denominator()->get(), $b->denominator()->get()));
        $nn = $this->rationalDiv($this->rationalMul($a->numerator(), $d), $a->denominator())->get();
        $nd = $this->rationalDiv($this->rationalMul($b->numerator(), $d), $b->denominator())->get();
        $n = $this->intAdd(TypeFactory::createInt($nn), TypeFactory::createInt($nd));

        return RationalTypeFactory::create($n, $d->numerator());
    }

    /**
     * Rational number subtraction
     *
     * @param chippyash\Type\Interfaces\NumericTypeInterface $a
     * @param chippyash\Type\Interfaces\NumericTypeInterface $b
     * @return \chippyash\Type\Number\Rational\RationalType
     */
    public function rationalSub(NI $a, NI $b)
    {
        list($a, $b) = $this->checkRationalTypes($a, $b);
        $d = RationalTypeFactory::create($this->lcm($a->denominator()->get(), $b->denominator()->get()));
        $nn = $this->rationalDiv($this->rationalMul($a->numerator(), $d), $a->denominator())->get();
        $nd = $this->rationalDiv($this->rationalMul($b->numerator(), $d), $b->denominator())->get();
        $n = $this->intSub(new GMPIntType($nn), new GMPIntType($nd));

        return RationalTypeFactory::create($n, $d->numerator());
    }

    /**
     * Rational number multiplication
     *
     * @param chippyash\Type\Interfaces\NumericTypeInterface $a
     * @param chippyash\Type\Interfaces\NumericTypeInterface $b
     * @return \chippyash\Type\Number\Rational\RationalType
     */
    public function rationalMul(NI $a, NI $b)
    {
        list($a, $b) = $this->checkRationalTypes($a, $b);
        $n = $this->intMul($a->numerator(), $b->numerator());
        $d = $this->intMul($a->denominator(), $b->denominator());

        return RationalTypeFactory::create($n, $d);
    }

    /**
     * Rational number division
     *
     * @param chippyash\Type\Interfaces\NumericTypeInterface $a
     * @param chippyash\Type\Interfaces\NumericTypeInterface $b
     * @return \chippyash\Type\Number\Rational\RationalType
     */
    public function rationalDiv(NI $a, NI $b)
    {
        list($a, $b) = $this->checkRationalTypes($a, $b);
        $n = $this->intMul($a->numerator(), $b->denominator());
        $d = $this->intMul($a->denominator(), $b->numerator());

        return RationalTypeFactory::create($n, $d);
    }

    /**
     * Rational number reciprocal: 1/r
     *
     * @param \chippyash\Type\Interfaces\NumericTypeInterface $a
     * @return \chippyash\Type\Number\Rational\GMPRationalType
     */
    public function rationalReciprocal(NI $a)
    {
        $a = $this->checkRationalType($a);
        return RationalTypeFactory::create($a->denominator(), $a->numerator());
    }
    
    /**
     * Rational Pow - raise number to the exponent
     * Will return a GMPRationalType
     * 
     * @param \chippyash\Type\Interfaces\NumericTypeInterface $a
     * @param \chippyash\Type\Interfaces\NumericTypeInterface $exp Exponent
     * @return \chippyash\Type\Number\Rational\GMPRationalType
     */
    public function rationalPow(NI $a, NI $exp)
    {
        $a = $this->checkRationalType($a);
        if ($exp instanceof \chippyash\Type\Number\Complex\GMPComplexType) {
            $r = $this->floatComplexPow($a(), $exp);
            if ($r instanceof FloatType) {
                return RationalTypeFactory::fromFloat($r());
            } else {
                return $r;
            }
        } else {
            $exp2 = $exp->get();
        }
        
        $numF = pow($a->numerator()->get(), $exp2);
        $denF = pow($a->denominator()->get(), $exp2);
        $numR = RationalTypeFactory::fromFloat($numF);
        $denR = RationalTypeFactory::fromFloat($denF);
        return $this->rationalDiv($numR, $denR);
        
    }
    
    /**
     * Rational sqrt
     * 
     * @param \chippyash\Type\Interfaces\NumericTypeInterface $a
     * @return \chippyash\Type\Number\Rational\GMPRationalType result
     */
    public function rationalSqrt(NI $a)
    {
        $exp = RationalTypeFactory::create(1, 2);
        return $this->rationalPow($a, $exp);
    }
    

    /**
     * Complex number addition
     *
     * @param \chippyash\Type\Interfaces\NumericTypeInterface $a
     * @param \chippyash\Type\Interfaces\NumericTypeInterface $b
     * @return chippyash\Type\Number\Complex\GMPComplexType
     */
    public function complexAdd(NI $a, NI $b)
    {
        $r = $this->rationalAdd($a->r(), $b->r());
        $i = $this->rationalAdd($a->i(), $b->i());
        return ComplexTypeFactory::create($r, $i);
    }

    /**
     * Complex number subtraction
     *
     * @param \chippyash\Type\Interfaces\NumericTypeInterface $a
     * @param \chippyash\Type\Interfaces\NumericTypeInterface $b
     * @return chippyash\Type\Number\Complex\GMPComplexType
     */
    public function complexSub(NI $a, NI $b)
    {
        $r = $this->rationalSub($a->r(), $b->r());
        $i = $this->rationalSub($a->i(), $b->i());
        return ComplexTypeFactory::create($r, $i);
    }

    /**
     * Complex number multiplication
     *
     * @param \chippyash\Type\Interfaces\NumericTypeInterface $a
     * @param \chippyash\Type\Interfaces\NumericTypeInterface $b
     * @return \chippyash\Type\Number\Complex\GMPComplexType
     */
    public function complexMul(NI $a, NI $b)
    {
        $r = $this->rationalSub($this->rationalMul($a->r(), $b->r()), $this->rationalMul($a->i(), $b->i()));
        $i = $this->rationalAdd($this->rationalMul($a->i(), $b->r()), $this->rationalMul($a->r(), $b->i()));
        return ComplexTypeFactory::create($r, $i);
    }

    /**
     * Complex number division
     *
     * @param \chippyash\Type\Interfaces\NumericTypeInterface $a
     * @param \chippyash\Type\Interfaces\NumericTypeInterface $b
     * @return \chippyash\Type\Number\Complex\GMPComplexType
     * @throws \BadMethodCallException
     */
    public function complexDiv(NI $a, NI $b)
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
     * @param \chippyash\Type\Interfaces\NumericTypeInterface $a
     * @return \chippyash\Type\Number\Complex\GMPComplexType
     * @throws \BadMethodCallException
     */
    public function complexReciprocal(NI $a)
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
     * Complex Pow - raise number to the exponent
     * Will return a ComplexType
     * Exponent must be non complex
     * 
     * @param \chippyash\Type\Interfaces\NumericTypeInterface $a
     * @param \chippyash\Type\Interfaces\NumericTypeInterface $exp Exponent
     * 
     * @return \chippyash\Type\Number\Complex\GMPComplexType
     * 
     * @throws \InvalidArgumentException If exponent is complex
     */
    public function complexPow(NI $a, NI $exp)
    {
        $a = $this->checkGmpComplexType($a);
        if ($exp instanceof AbstractComplexType) {
            $exp = $this->checkGmpComplexType($exp);
            $comp = new Comparator();
            $zero = new GMPIntType(0);
            if ($comp->eq($a->r(), $zero) && $comp->eq($a->i(), $zero)) {
                $real = 0;
                $imaginary = 0;
            } else {
                $er = $exp->r()->get();
                $ei = $exp->i()->get();
                
                $logr = log($a->modulus()->get());
                $theta = $a->theta()->get();
                $rho = exp($logr * $er - $ei * $theta);
                $beta = $theta * $er + $ei * $logr;
                $real = $rho * cos($beta);
                $imaginary = $rho * sin($beta);
            }
        } else {
            //non complex
            //de moivres theorum
            //z^n = r^n(cos(n.theta) + sin(n.theta)i)
            //where z is a complex number, r is the radius
            $n = $exp();
            $nTheta = $n * $a->theta()->get();
            $pow = pow($a->modulus()->get(), $n);
            $real = cos($nTheta) * $pow;
            $imaginary = sin($nTheta) * $pow;
        }
        
        return ComplexTypeFactory::create(
                RationalTypeFactory::fromFloat($real),
                RationalTypeFactory::fromFloat($imaginary)
                );        
    }
    
    /**
     * Complex sqrt
     * 
     * @param chippyash\Type\Interfaces\NumericTypeInterface $a
     * @return \chippyash\Type\Number\Complex\ComplexType result
     */
    public function complexSqrt(NI $a)
    {
        return $this->complexPow($a, RationalTypeFactory::create(1, 2));
    }
    
    
    /**
     * Return the natural (base e) logarithm for a number
     * 
     * This function will use a Taylor Series algorithm to compute the log
     * for GMP calculator else use PHP inbuilt log() method
     * 
     * @param \chippyash\Type\Interfaces\NumericTypeInterface $a
     * 
     * @return \chippyash\Type\Numeric\Rational\GMPRationalType
     */
    public function natLog(NI $a)
    {
        $epsilon = RationalTypeFactory::fromFloat(self::NATLOG_EPSILON);
        $calc = $this->calculator;
        $comp = new Comparator();
        if ($a instanceof \chippyash\Type\Number\Complex\GMPComplexType) {
            if($a->isReal()) {
                $y = $a->r();
            } else {
                $y = $a->modulus();
            }
        } else {
            $y = $a;
        }
        
        //x = (y-1)/(y+1)
        $x = $calc->div($calc->sub($y, 1), $calc->add($y, 1));
        //x = x^2
        $z = $calc->mul($x, $x);
        //initial log value
        $L = RationalTypeFactory::create(0);
        $two = RationalTypeFactory::create(2);

        //run the Taylor Series until we meet the epsilon limiter
        for ($k=RationalTypeFactory::create(1); $comp->gt($x, $epsilon); $calc->inc($k, $two)) {
            //$L += 2 * $x / $k;
            $calc->inc($L, $calc->div($calc->mul($two, $x), $k));
            //$x *= $z;
            $x = $calc->mul($x, $z);
        }

        return $L;

    }
    
    private function intComplexPow($a, ComplexType $exp)
    {
        if ($exp->isZero()) {
            return new IntType(1);
        }
        return $this->complexExponent($a, $exp);        
    }
    
    private function floatComplexPow($a, ComplexType $exp)
    {
        if ($exp->isZero()) {
            return new FloatType(1);
        }
        return $this->complexExponent($a, $exp);
    }
    
    private function complexExponent($base, ComplexType $exp)
    {
        if ($exp->isReal()) {
            return $this->rationalPow(
                    RationalTypeFactory::fromFloat($base), 
                    $exp->r());
        }
        
        //do the imaginary part
        //n^bi = cos(b.lg(n)) + i.sin(b.lg(n))
        $b = $exp->i()->get();
        $n = log($base);
        $r = cos($b * $n);
        $i = sin($b * $n);     
        
        //no real part
        if ($exp->r()->get() == 0) {
            return new ComplexType(
                    RationalTypeFactory::fromFloat($r),
                    RationalTypeFactory::fromFloat($i));
        }
        //real and imaginary part
        //n^a+bi = n^a(cos(b.lg(n)) + i.sin(b.lg(n)))
        $na = pow($base, $exp->r()->get());
        $rr = $na * $r;
        $ii = $na * $i;
        return new ComplexType(
                RationalTypeFactory::fromFloat($rr),
                RationalTypeFactory::fromFloat($ii)
                ); 
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
