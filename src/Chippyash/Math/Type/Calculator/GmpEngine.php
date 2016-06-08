<?php
/*
 * Arithmetic calculation support for Chippyash Strong Types
 *
 * @author Ashley Kitson <akitson@zf4.biz>
 * @copyright Ashley Kitson, UK, 2014
 * @licence GPL V3 or later : http://www.gnu.org/licenses/gpl.html
 */
namespace Chippyash\Math\Type\Calculator;

use Chippyash\Type\TypeFactory;
use Chippyash\Type\Interfaces\NumericTypeInterface as NTI;
use Chippyash\Type\Interfaces\RationalTypeInterface as RTI;
use Chippyash\Type\Interfaces\ComplexTypeInterface as CTI;
use Chippyash\Type\Number\IntType;
use Chippyash\Type\Number\FloatType;
use Chippyash\Type\Number\GMPIntType;
use Chippyash\Type\Number\Rational\GMPRationalType;
use Chippyash\Type\Number\Rational\RationalTypeFactory;
use Chippyash\Type\Number\Complex\AbstractComplexType;
use Chippyash\Type\Number\Complex\GMPComplexType;
use Chippyash\Type\Number\Complex\ComplexTypeFactory;
use Chippyash\Math\Type\Traits\GmpConvertNumeric;
use Chippyash\Math\Type\Traits\CheckGmpRationalTypes;
use Chippyash\Math\Type\Traits\CheckGmpIntTypes;
use Chippyash\Math\Type\Traits\CheckGmpFloatTypes;
use Chippyash\Math\Type\Traits\CheckGmpComplexTypes;
use Chippyash\Math\Type\Comparator;

/**
 * GMP calculation
 */
class GmpEngine implements CalculatorEngineInterface
{
    use GmpConvertNumeric;
    use CheckGmpRationalTypes;
    use CheckGmpIntTypes;
    use CheckGmpFloatTypes;
    use CheckGmpComplexTypes;

    /**
     * Convergence epsilon for natural logarithm method
     * @see natLog()
     */
    const NATLOG_EPSILON = 1e-20;
    
    /**
     * Integer type addition
     *
     * @param NTI $a
     * @param NTI $b
     * @return \Chippyash\Type\Number\GMPIntType
     */
    public function intAdd(NTI $a, NTI $b)
    {
        list($a, $b) = $this->checkIntTypes($a, $b);

        return new GMPIntType(gmp_add($a->gmp(), $b->gmp()));
    }

    /**
     * Integer type subtraction
     *
     * @param NTI $a
     * @param NTI $b
     * @return \Chippyash\Type\Number\GMPIntType
     */
    public function intSub(NTI $a, NTI $b)
    {
        list($a, $b) = $this->checkIntTypes($a, $b);

        return new GMPIntType(gmp_sub($a->gmp(), $b->gmp()));
    }

    /**
     * Integer type multiplication
     *
     * @param NTI $a
     * @param NTI $b
     * @return \Chippyash\Type\Number\GMPIntType
     */
    public function intMul(NTI $a, NTI $b)
    {
        list($a, $b) = $this->checkIntTypes($a, $b);

        return new GMPIntType(gmp_mul($a->gmp(), $b->gmp()));
    }

    /**
     * Integer division
     * Integer division is simply a case of creating a rational
     * number i.e. a/b
     *
     * @param NTI $a
     * @param NTI $b
     * @return \Chippyash\Type\Number\Rational\RationalType
     */
    public function intDiv(NTI $a, NTI $b)
    {
        list($a, $b) = $this->checkIntTypes($a, $b);
        return RationalTypeFactory::create($a, $b);
    }
    
    /**
     * Integer Pow - raise number to the exponent
     * Will return an IntType, RationalType or ComplexType
     * 
     * @todo Implement taylor series POW method
     * @param IntType $a
     * @param NTI $exp Exponent
     * @return NTI
     */
    public function intPow(IntType $a, NTI $exp)
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
     * @param IntType $a
     * @return GmpIntType|GMPRationalType result
     */
    public function intSqrt(IntType $a)
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
     * @param NTI $a
     * @param NTI $b
     * @return \Chippyash\Type\Number\Rational\GMPRationalType
     */
    public function floatAdd(NTI $a, NTI $b)
    {
        list($a, $b) = $this->checkFloatTypes($a, $b);
        
        return $this->rationalAdd($a, $b);
    }

    /**
     * Float subtraction
     *
     * @param NTI $a
     * @param NTI $b
     * @return \Chippyash\Type\Number\Rational\GMPRationalType
     */
    public function floatSub(NTI $a, NTI $b)
    {
        list($a, $b) = $this->checkFloatTypes($a, $b);
        
        return $this->rationalSub($a, $b);
    }

    /**
     * Float multiplication
     *
     * @param NTI $a
     * @param NTI $b
     * @return \Chippyash\Type\Number\Rational\GMPRationalType
     */
    public function floatMul(NTI $a, NTI $b)
    {
        list($a, $b) = $this->checkFloatTypes($a, $b);
        
        return $this->rationalMul($a, $b);
    }

    /**
     * Float division
     *
     * @param NTI $a
     * @param NTI $b
     * @return \Chippyash\Type\Number\Rational\GMPRationalType
     */
    public function floatDiv(NTI $a, NTI $b)
    {
        list($a, $b) = $this->checkFloatTypes($a, $b);
        
        return $this->rationalDiv($a, $b);
    }

    /**
     * Float reciprocal i.e. 1/a
     * @param NTI $a
     * @return \Chippyash\Type\Number\Rational\GMPRationalType
     */
    public function floatReciprocal(NTI $a)
    {
        return $this->rationalReciprocal($this->checkFloatType($a));
    }

    /**
     * Float Pow - raise number to the exponent
     * Will return a float type
     * 
     * @param FloatType $a
     * @param NTI $exp Exponent
     * @return \Chippyash\Type\Number\Rational\GMPRationalType
     */
    public function floatPow(FloatType $a, NTI $exp)
    {
        return $this->rationalPow($this->checkFloatType($a), $exp);
    }
    
    /**
     * Float sqrt
     * 
     * @param FloatType $a
     * @return \Chippyash\Type\Number\Rational\GMPRationalType
     */
    public function floatSqrt(FloatType $a)
    {
        return $this->rationalSqrt($this->checkFloatType($a));
    }

    /**
     * Whole number addition
     * Proxy to intAdd
     * NB you lose the protection of whole types
     * 
     * @param NTI $a
     * @param NTI $b
     * @return \Chippyash\Type\Number\GmpIntType
     */
    public function wholeAdd(NTI $a, NTI $b)
    {
        return $this->intAdd($a, $b);
    }

    /**
     * Whole number subtraction
     * Proxy to intSub
     * NB you lose the protection of whole types
     * 
     * @param NTI $a
     * @param NTI $b
     * @return \Chippyash\Type\Number\GmpIntType
     */
    public function wholeSub(NTI $a, NTI $b)
    {
        return $this->intSub($a, $b);
    }

    /**
     * Whole number multiplication
     * Proxy to intMul
     * NB you lose the protection of whole types
     * 
     * @param NTI $a
     * @param NTI $b
     * @return \Chippyash\Type\Number\GmpIntType
     */
    public function wholeMul(NTI $a, NTI $b)
    {
        return $this->intMul($a, $b);
    }

    /**
     * Natural number addition
     * Proxy to IntAdd
     * NB you lose the protection of natural types
     * 
     * @param NTI $a
     * @param NTI $b
     * @return \Chippyash\Type\Number\GmpIntType
     */
    public function naturalAdd(NTI $a, NTI $b)
    {
        return $this->intAdd($a, $b);
    }

    /**
     * Natural number subtraction
     * Proxy to intSub
     * NB you lose the protection of natural types
     * 
     * @param NTI $a
     * @param NTI $b
     * @return \Chippyash\Type\Number\GmpIntType
     */
    public function naturalSub(NTI $a, NTI $b)
    {
        return $this->intSub($a, $b);
    }

    /**
     * Natural number multiplication
     * Proxy to intMul
     * NB you lose the protection of natural types
     * 
     * @param NTI $a
     * @param NTI $b
     * @return \Chippyash\Type\Number\GmpIntType
     */
    public function naturalMul(NTI $a, NTI $b)
    {
        return $this->intMul($a, $b);
    }

    /**
     * Rational number addition
     * 
     * @param RTI $a
     * @param RTI $b
     * @return GMPRationalType
     */
    public function rationalAdd(RTI $a, RTI $b)
    {
        list($a, $b) = $this->checkRationalTypes($a, $b);

        $d = RationalTypeFactory::create(
            $this->lcm(
                $a->denominator()->get(), 
                $b->denominator()->get()
            )
        )->asGMPRational();
        
        $nn = $this->rationalDiv(
            $this->rationalMul(
                $a->numerator()->asGMPRational(), 
                $d
            ), 
            $a->denominator()->asGMPRational()
        )->get();
        
        $nd = $this->rationalDiv(
            $this->rationalMul(
                $b->numerator()->asGMPRational(), 
                $d
            ), 
            $b->denominator()->asGMPRational()
        )->get();
        
        $n = $this->intAdd(TypeFactory::createInt($nn), TypeFactory::createInt($nd));

        return RationalTypeFactory::create($n, $d->numerator());
    }

    /**
     * Rational number subtraction
     *
     * @param RTI $a
     * @param RTI $b
     * @return GMPRationalType
     */
    public function rationalSub(RTI $a, RTI $b)
    { 
        list($a, $b) = $this->checkRationalTypes($a, $b);
        $d = RationalTypeFactory::create(
            $this->lcm(
                $a->denominator()->get(),
                $b->denominator()->get()
            )
        )->asGMPRational();

        $nn = $this->rationalDiv(
            $this->rationalMul(
                $a->numerator()->asGMPRational(),
                $d
            ),
            $a->denominator()->asGMPRational()
        )->get();


        $nd = $this->rationalDiv(
            $this->rationalMul(
                $b->numerator()->asGMPRational(),
                $d
            ),
            $b->denominator()->asGMPRational()
        )->get();

        $n = $this->intSub(TypeFactory::createInt($nn), TypeFactory::createInt($nd));
        $aa = (string) $a; $bb = (string) $b; $dd = (string) $d;
        $nnn = (string) $nn; $nnd = (string) $nd;
        $ret = RationalTypeFactory::create($n, $d->numerator());
        
        return $ret;
    }

    /**
     * Rational number multiplication
     *
     * @param RTI $a
     * @param RTI $b
     * @return GMPRationalType
     */
    public function rationalMul(RTI $a, RTI $b)
    {
        list($a, $b) = $this->checkRationalTypes($a, $b);
        $n = $this->intMul($a->numerator(), $b->numerator());
        $d = $this->intMul($a->denominator(), $b->denominator());

        return RationalTypeFactory::create($n, $d);
    }

    /**
     * Rational number division
     *
     * @param RTI $a
     * @param RTI $b
     * @return GMPRationalType
     */
    public function rationalDiv(RTI $a, RTI $b)
    {
        list($a, $b) = $this->checkRationalTypes($a, $b);
        $n = $this->intMul($a->numerator(), $b->denominator());
        $d = $this->intMul($a->denominator(), $b->numerator());

        return RationalTypeFactory::create($n, $d);
    }

    /**
     * Rational number reciprocal: 1/r
     *
     * @param RTI $a
     * @return GMPRationalType
     */
    public function rationalReciprocal(RTI $a)
    {
        $a = $this->checkRationalType($a);
        return RationalTypeFactory::create($a->denominator(), $a->numerator());
    }
    
    /**
     * Rational Pow - raise number to the exponent
     * Will return a GMPRationalType
     * 
     * @param RTI $a
     * @param NTI $exp Exponent
     * @return GMPRationalType
     */
    public function rationalPow(RTI $a, NTI $exp)
    {
        $a = $this->checkRationalType($a);
        if ($exp instanceof \Chippyash\Type\Number\Complex\GMPComplexType) {
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
     * @param RTI $a
     * @return GMPRationalType result
     */
    public function rationalSqrt(RTI $a)
    {
        $exp = RationalTypeFactory::create(1, 2);
        return $this->rationalPow($a, $exp);
    }
    

    /**
     * Complex number addition
     *
     * @param CTI $a
     * @param CTI $b
     * @return GMPComplexType
     */
    public function complexAdd(CTI $a, CTI $b)
    {
        $r = $this->rationalAdd($a->r(), $b->r());
        $i = $this->rationalAdd($a->i(), $b->i());
        return ComplexTypeFactory::create($r, $i);
    }

    /**
     * Complex number subtraction
     *
     * @param CTI $a
     * @param CTI $b
     * @return GMPComplexType
     */
    public function complexSub(CTI $a, CTI $b)
    {
        $r = $this->rationalSub($a->r(), $b->r());
        $i = $this->rationalSub($a->i(), $b->i());
        return ComplexTypeFactory::create($r, $i);
    }

    /**
     * Complex number multiplication
     *
     * @param CTI $a
     * @param CTI $b
     * @return GMPComplexType
     */
    public function complexMul(CTI $a, CTI $b)
    {
        $r = $this->rationalSub($this->rationalMul($a->r(), $b->r()), $this->rationalMul($a->i(), $b->i()));
        $i = $this->rationalAdd($this->rationalMul($a->i(), $b->r()), $this->rationalMul($a->r(), $b->i()));
        return ComplexTypeFactory::create($r, $i);
    }

    /**
     * Complex number division
     *
     * @param CTI $a
     * @param CTI $b
     * @return GMPComplexType
     * @throws \BadMethodCallException
     */
    public function complexDiv(CTI $a, CTI $b)
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
     * @param CTI $a
     * @return GMPComplexType
     * @throws \BadMethodCallException
     */
    public function complexReciprocal(CTI $a)
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
     * @param CTI $a
     * @param NTI $exp Exponent
     * 
     * @return GMPComplexType
     * 
     * @throws \InvalidArgumentException If exponent is complex
     */
    public function complexPow(CTI $a, NTI $exp)
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
     * @param CTI $a
     * @return GMPComplexType
     */
    public function complexSqrt(CTI $a)
    {
        return $this->complexPow($a, RationalTypeFactory::create(1, 2));
    }
    
    
    /**
     * @param NTI $a
     * @param numeric|NTI|int $inc
     * @return mixed
     */
    public function incInt(NTI $a, $inc = 1)
    {
        $increment = ($inc instanceof NTI ? $inc : $this->convertNumeric($inc));
        $a->set($this->intAdd($a, $increment)->gmp());
    }

    /**
     * @param NTI $a
     * @param numeric|NTI|int $inc
     * @return mixed
     * @throws \BadMethodCallException
     */
    public function incFloat(NTI $a, $inc = 1)
    {
        throw new \BadMethodCallException('decFloat not implemented for GMP calculator');
    }

    /**
     * @param RTI $a
     * @param numeric|NTI|int $inc
     * @return mixed
     */
    public function incRational(RTI $a, $inc = 1)
    {
        $this->incInt($a->numerator(), $inc);
    }

    /**
     * @param CTI $a
     * @param numeric|NTI|int $inc
     * @return mixed
     */
    public function incComplex(CTI $a, $inc = 1)
    {
        $this->incRational($a->r(), $inc);
    }

    /**
     * @param NTI $a
     * @param numeric|NTI|int $dec
     * @return mixed
     */
    public function decInt(NTI $a, $dec = 1)
    {
        $decrement = ($dec instanceof NTI ? $dec : $this->convertNumeric($dec));
        $a->set($this->intSub($a, $decrement)->gmp());
    }

    /**
     * @param NTI $a
     * @param numeric|NTI|int $dec
     * @return mixed
     * @throws \BadMethodCallException
     */
    public function decFloat(NTI $a, $dec = 1)
    {
        throw new \BadMethodCallException('decFloat not implemented for GMP calculator');
    }

    /**
     * @param RTI $a
     * @param numeric|NTI|int $dec
     * @return mixed
     */
    public function decRational(RTI $a, $dec = 1)
    {
        $this->decInt($a->numerator(), $dec);
    }

    /**
     * @param CTI $a
     * @param numeric|NTI|int $dec
     * @return mixed
     */
    public function decComplex(CTI $a, $dec = 1)
    {
        $this->decRational($a->r(), $dec);
    }

    /**
     * @param NTI $a
     * @return RTI
     */
    public function intNatLog(NTI $a)
    {
        return $this->natLog2(new GMPRationalType($a, new GMPIntType(1)));
    }

    /**
     * @param NTI $a
     * @return mixed
     * @throws \BadMethodCallException
     */
    public function floatNatLog(NTI $a)
    {
        throw new \BadMethodCallException('floatNatLog method not implemented for GMP engine');
    }

    /**
     * @param RTI $a
     * @return RTI
     */
    public function rationalNatLog(RTI $a)
    {
        return $this->natLog2($a);
    }

    /**
     * @param CTI $a
     * @return RTI
     */
    public function complexNatLog(CTI $a)
    {
        if ($a instanceof GMPComplexType) {
            if($a->isReal()) {
                $y = $a->r();
            } else {
                $y = $a->modulus();
            }
        } else {
            $y = $a;
        }
        
        return $this->natLog2($y);
    }

    /**
     * Return the natural (base e) logarithm for a number
     *
     * This function will use a Taylor Series algorithm to compute the log
     *
     * @param GMPRationalType $y
     *
     * @return GMPRationalType
     */
    private function natLog(GMPRationalType $y)
    {
        $epsilon = RationalTypeFactory::fromFloat(self::NATLOG_EPSILON);
        $comp = new Comparator();
        $one = RationalTypeFactory::create(1);
        $two = RationalTypeFactory::create(2);
        
        //x = (y-1)/(y+1)
        $x = $this->rationalDiv($this->rationalSub($y, $one), $this->rationalAdd($y, $one));
        //z = x^2
        $z = $this->rationalMul($x, $x);
        //initial log value
        $L = RationalTypeFactory::create(0);
        

        //run the Taylor Series until we meet the epsilon limiter
        for ($k=$one; $comp->gt($x, $epsilon); $this->incRational($k, $two)) {
            $tx = $x->get();

            //$L += 2 * $x / $k;
            $this->incRational($L, $this->rationalDiv($this->rationalMul($two, $x), $k));
            //$x *= $z;
            $x = $this->rationalMul($x, $z);

            $tk = $k->get();
            $tx = $x->get();
            $tL = $L->get();
        }

        return $L;
    }

    /**
     * ln(x) = pi/(2M(1,4/s)) - m.ln(2)
     *
     * where :
     *  M = arithemetic geometric mean of (1, 4/s)
     *  s = x2^m, with m precision bits (8 regarded as sufficient)
     *
     * @link https://en.wikipedia.org/wiki/Natural_logarithm
     *
     * @param GMPRationalType $x
     *
     * @return GMPRationalType
     */
    private function natLog2($x)
    {
        //s
        $m = RationalTypeFactory::create(8);
        $two = RationalTypeFactory::create(2);
        $m2 = $this->rationalPow($two, $m);
        $s = $this->rationalMul($x, $m2);

        //M
        $s4 = $this->rationalDiv(RationalTypeFactory::create(4), $s);
        $precision = RationalTypeFactory::create(1,1000000000000000000);
        $M = $this->agm(RationalTypeFactory::create(1), $s4, $precision);

        //pi
        $pi = RationalTypeFactory::fromFloat(M_PI);
        //ln(2)
        $ln2 = RationalTypeFactory::fromFloat(log(2));

        $ret = $this->rationalSub(
            $this->rationalDiv($pi, $this->rationalMul($two, $M)),
            $this->rationalMul($m, $ln2)
        );
        echo  sprintf("ln(%s) = %s\n\n", (string) $x, (string) $ret);
        return $ret;
    }

    /**
     * Arithmetic geometric mean
     *
     * @link https://en.wikipedia.org/wiki/Arithmetic%E2%80%93geometric_mean
     *
     * a1 = (a+g)/2
     * g1 = sqrt(ag)
     * until precision
     * 
     * @param GMPRationalType $a
     * @param GMPRationalType $g
     * @param GMPRationalType $precision
     * 
     * @return GMPRationalType
     */
    private function agm(GMPRationalType $a, GMPRationalType $g, GMPRationalType $precision)
    {
        echo sprintf("initial a: %s, g; %s", (string) $a, (string) $g) . PHP_EOL;
        $comp = new Comparator();
        $two = RationalTypeFactory::create(2);
        //have we reached precision?
        //diff(a,b) <= precision
        do {
            echo sprintf("diff: %s", (string) $this->rationalSub($a, $g)->abs()) . PHP_EOL;
            $ai = $this->rationalDiv($this->rationalAdd($a, $g), $two);
            $gi = $this->rationalSqrt($this->rationalMul($a, $g));
            echo sprintf("a: %s, g: %s, p: %s", (string) $ai, (string) $gi, (string) $precision) . PHP_EOL;
            unset($a, $g);
            $a = clone $ai; $g = clone $gi;
            unset ($ai, $gi);
            echo sprintf("aeq = %s", $comp->aeq($a, $g, $precision) ? 'true' : 'false') . PHP_EOL;
        } while (false === $comp->aeq($a, $g, $precision));
        echo PHP_EOL;

        //return mean of two numbers
        $ret = $this->rationalDiv($this->rationalAdd($a, $g), $two);
        return $ret;
    }
    
    private function intComplexPow($a, ComplexType $exp)
    {
        if ($exp->isZero()) {
            return new IntType(1);
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
