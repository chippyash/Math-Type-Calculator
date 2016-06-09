<?php
/*
 * Arithmetic calculation support for Chippyash Strong Types
 *
 * @author Ashley Kitson <akitson@zf4.biz>
 * @copyright Ashley Kitson, UK, 2014
 * @licence GPL V3 or later : http://www.gnu.org/licenses/gpl.html
 */
namespace Chippyash\Math\Type\Calculator;

use Chippyash\Type\Interfaces\NumericTypeInterface as NI;
use Chippyash\Type\Number\IntType;
use Chippyash\Type\Number\FloatType;
use Chippyash\Type\Number\WholeIntType;
use Chippyash\Type\Number\NaturalIntType;
use Chippyash\Type\Number\Rational\RationalType;
use Chippyash\Type\Number\Rational\RationalTypeFactory;
use Chippyash\Type\Number\Complex\ComplexType;
use Chippyash\Type\Number\Complex\ComplexTypeFactory;
use Chippyash\Math\Type\Traits\NativeConvertNumeric;
use Chippyash\Math\Type\Traits\CheckRationalTypes;
use Chippyash\Math\Type\Traits\CheckIntTypes;
use Chippyash\Math\Type\Traits\CheckFloatTypes;
use Chippyash\Math\Type\Comparator;
use Chippyash\Type\RequiredType;

/**
 * PHP Native calculation
 */
class Native implements CalculatorEngineInterface
{
    use NativeConvertNumeric;
    use CheckRationalTypes;
    use CheckIntTypes;
    use CheckFloatTypes;

    /**
     * Native constructor.
     * Ensure that Type Factories use PHP Native types
     */
    public function __construct()
    {
        RequiredType::getInstance()->set(RequiredType::TYPE_NATIVE);
    }

    /**
     * Integer type addition
     *
     * @param NI $a
     * @param NI $b
     * @return IntType
     */
    public function intAdd(NI $a, NI $b)
    {
        list($a, $b) = $this->checkIntTypes($a, $b);

        return new IntType($a() + $b());
    }

    /**
     * Integer type subtraction
     *
     * @param NI $a
     * @param NI $b
     * @return IntType
     */
    public function intSub(NI $a, NI $b)
    {
        list($a, $b) = $this->checkIntTypes($a, $b);

        return new IntType($a() - $b());
    }

    /**
     * Integer type multiplication
     *
     * @param NI $a
     * @param NI $b
     * @return IntType
     */
    public function intMul(NI $a, NI $b)
    {
        list($a, $b) = $this->checkIntTypes($a, $b);

        return new IntType($a() * $b());
    }

    /**
     * Integer division
     *
     * @param NI $a
     * @param NI $b
     * @return RationalType
     */
    public function intDiv(NI $a, NI $b)
    {
        $ra = RationalTypeFactory::create($a);
        $rb = RationalTypeFactory::create($b);
        return $this->rationalDiv($ra, $rb);
    }
    
    /**
     * Integer Pow - raise number to the exponent
     * Will return an IntType, RationalType or ComplexType
     * 
     * @param IntType $a
     * @param NI $exp Exponent
     * @return NI
     */
    public function intPow(IntType $a, NI $exp)
    {
        if ($exp instanceof RationalType) {
            $b = new RationalType(clone $a, new IntType(1));
            return $this->rationalPow($b, $exp);
        }
        
        if ($exp instanceof ComplexType) {
            return $this->intComplexPow($a(), $exp);
        }
        
        //int and float types
        $p = pow($a(), $exp());
        if (($p - intval($p)) === 0) {
            return new IntType($p);
        }
        
        return RationalTypeFactory::fromFloat($p);
    }
    
    /**
     * Integer sqrt
     * Return IntType for perfect squares, else RationalType
     * 
     * @param IntType $a
     * @return IntType|RationalType result
     */
    public function intSqrt(IntType $a)
    {
        $res = $this->rationalSqrt(new RationalType($a, new IntType(1)));
        if ($res->isInteger()) {
            return $res->numerator();
        }

        return $res;
    }
    
    /**
     * Float addition
     *
     * @param NI $a
     * @param NI $b
     * @return \Chippyash\Type\Number\FloatType
     */
    public function floatAdd(NI $a, NI $b)
    {
        list($a, $b) = $this->checkFloatTypes($a, $b);
        return new FloatType($a() + $b());
    }

    /**
     * Float subtraction
     *
     * @param NI $a
     * @param NI $b
     * @return \Chippyash\Type\Number\FloatType
     */
    public function floatSub(NI $a, NI $b)
    {
        list($a, $b) = $this->checkFloatTypes($a, $b);
        return new FloatType($a() - $b());
    }

    /**
     * Float multiplication
     *
     * @param NI $a
     * @param NI $b
     * @return \Chippyash\Type\Number\FloatType
     */
    public function floatMul(NI $a, NI $b)
    {
        list($a, $b) = $this->checkFloatTypes($a, $b);
        return new FloatType($a() * $b());
    }

    /**
     * Float division
     *
     * @param NI $a
     * @param NI $b
     * @return \Chippyash\Type\Number\FloatType
     */
    public function floatDiv(NI $a, NI $b)
    {
        list($a, $b) = $this->checkFloatTypes($a, $b);
        return new FloatType($a() / $b());
    }

    /**
     * Float reciprocal i.e. 1/a
     * @param NI $a
     * @return \Chippyash\Type\Number\FloatType
     */
    public function floatReciprocal(NI $a)
    {
        return $this->floatDiv(new IntType(1), $a);
    }

    /**
     * Float Pow - raise number to the exponent
     * Will return a float type
     * 
     * @param \Chippyash\Type\Number\FloatType $a
     * @param NI $exp Exponent
     * @return \Chippyash\Type\Number\FloatType
     */
    public function floatPow(FloatType $a, NI $exp)
    {
        if ($exp instanceof RationalType) {
            $b = RationalTypeFactory::fromFloat($a());
            return $this->rationalPow($b, $exp)->asFloatType();
        }
        
        if ($exp instanceof ComplexType) {
            return $this->floatComplexPow($a(), $exp);
        }
        
        //int and float types
        $p = pow($a(), $exp());
        
        return new FloatType($p);
    }
    
    /**
     * Float sqrt
     * 
     * @param \Chippyash\Type\Number\FloatType $a
     * @return \Chippyash\Type\Number\FloatType result
     */
    public function floatSqrt(FloatType $a)
    {
        return new FloatType(sqrt($a()));
    }

    /**
     * Whole number addition
     *
     * @param NI $a
     * @param NI $b
     * @return \Chippyash\Type\Number\WholeIntType
     */
    public function wholeAdd(NI $a, NI $b)
    {
        list($a, $b) = $this->checkIntTypes($a, $b);
        return new WholeIntType($a() + $b());
    }

    /**
     * Whole number subtraction
     *
     * @param NI $a
     * @param NI $b
     * @return \Chippyash\Type\Number\WholeIntType
     */
    public function wholeSub(NI $a, NI $b)
    {
        list($a, $b) = $this->checkIntTypes($a, $b);
        return new WholeIntType($a() - $b());
    }

    /**
     * Whole number multiplication
     *
     * @param NI $a
     * @param NI $b
     * @return \Chippyash\Type\Number\WholeIntType
     */
    public function wholeMul(NI $a, NI $b)
    {
        list($a, $b) = $this->checkIntTypes($a, $b);
        return new WholeIntType($a() * $b());
    }

    /**
     * Natural number addition
     *
     * @param NI $a
     * @param NI $b
     * @return \Chippyash\Type\Number\NaturalIntType
     */
    public function naturalAdd(NI $a, NI $b)
    {
        list($a, $b) = $this->checkIntTypes($a, $b);
        return new NaturalIntType($a() + $b());
    }

    /**
     * Natural number subtraction
     *
     * @param NI $a
     * @param NI $b
     * @return \Chippyash\Type\Number\NaturalIntType
     */
    public function naturalSub(NI $a, NI $b)
    {
        list($a, $b) = $this->checkIntTypes($a, $b);
        return new NaturalIntType($a() - $b());
    }

    /**
     * Natural number multiplication
     *
     * @param NI $a
     * @param NI $b
     * @return \Chippyash\Type\Number\NaturalIntType
     */
    public function naturalMul(NI $a, NI $b)
    {
        list($a, $b) = $this->checkIntTypes($a, $b);
        return new NaturalIntType($a() * $b());
    }

    /**
     * Rational number addition
     *
     * @param NI $a
     * @param NI $b
     * @return RationalType
     */
    public function rationalAdd(NI $a, NI $b)
    {
        if (!$a instanceof RationalType) {
            $a = $a->asRational();
        }
        if (!$b instanceof RationalType) {
            $b = $b->asRational();
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
     * @param NI $a
     * @param NI $b
     * @return RationalType
     */
    public function rationalSub(NI $a, NI $b)
    {
        list($a, $b) = $this->checkRationalTypes($a, $b);
        $d = RationalTypeFactory::create($this->lcm($a->denominator()->get(), $b->denominator()->get()));
        $nn = $this->rationalDiv($this->rationalMul($a->numerator(), $d), $a->denominator())->get();
        $nd = $this->rationalDiv($this->rationalMul($b->numerator(), $d), $b->denominator())->get();
        $n = $this->intSub(new IntType($nn), new IntType($nd));

        return RationalTypeFactory::create($n, $d->numerator());
    }

    /**
     * Rational number multiplication
     *
     * @param NI $a
     * @param NI $b
     * @return RationalType
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
     * @param NI $a
     * @param NI $b
     * @return RationalType
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
     * @param \RationalType $a
     * @return RationalType
     */
    public function rationalReciprocal(RationalType $a)
    {
        return RationalTypeFactory::create($a->denominator(), $a->numerator());
    }
    
    /**
     * Rational Pow - raise number to the exponent
     * Will return a RationalType
     * 
     * @param RationalType $a
     * @param NI $exp Exponent
     * @return NI
     */
    public function rationalPow(RationalType $a, NI $exp)
    {
        if ($exp instanceof ComplexType) {
            $r = $this->floatComplexPow($a(), $exp);
            if ($r instanceof FloatType) {
                return RationalTypeFactory::fromFloat($r());
            }
            return $r;
        }

        $exp2 = $exp->get();
        $numF = pow($a->numerator()->get(), $exp2);
        $denF = pow($a->denominator()->get(), $exp2);
        $numR = RationalTypeFactory::fromFloat($numF);
        $denR = RationalTypeFactory::fromFloat($denF);
        
        return $this->rationalDiv($numR, $denR);
    }
    
    /**
     * Rational sqrt
     * 
     * @param RationalType $a
     * @return RationalType result
     */
    public function rationalSqrt(RationalType $a)
    {
        $num = sqrt($a->numerator()->get());
        $den = sqrt($a->denominator()->get());
        return $this->rationalDiv(
                RationalTypeFactory::fromFloat($num), 
                RationalTypeFactory::fromFloat($den));
    }
    

    /**
     * Complex number addition
     *
     * @param \Chippyash\Type\Number\Complex\ComplexType $a
     * @param \Chippyash\Type\Number\Complex\ComplexType $b
     * @return \Chippyash\Type\Number\Complex\ComplexType
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
     * @param \Chippyash\Type\Number\Complex\ComplexType $a
     * @param \Chippyash\Type\Number\Complex\ComplexType $b
     * @return \Chippyash\Type\Number\Complex\ComplexType
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
     * @param \Chippyash\Type\Number\Complex\ComplexType $a
     * @param \Chippyash\Type\Number\Complex\ComplexType $b
     * @return \Chippyash\Type\Number\Complex\ComplexType
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
     * @param \Chippyash\Type\Number\Complex\ComplexType $a
     * @param \Chippyash\Type\Number\Complex\ComplexType $b
     * @return \Chippyash\Type\Number\Complex\ComplexType
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
     * @param \Chippyash\Type\Number\Complex\ComplexType $a
     * @return \Chippyash\Type\Number\Complex\ComplexType
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
     * Complex Pow - raise number to the exponent
     * Will return a ComplexType
     * Exponent must be non complex
     * 
     * @param \Chippyash\Type\Number\Complex\ComplexType $a
     * @param NI $exp Exponent
     * 
     * @return \Chippyash\Type\Number\Complex\ComplexType
     * 
     * @throws \InvalidArgumentException If exponent is complex
     */
    public function complexPow(ComplexType $a, NI $exp)
    {
        if ($exp instanceof ComplexType) {
            $comp = new Comparator();
            $zero = new IntType(0);
            $real = 0;
            $imaginary = 0;
            if (!($comp->eq($a->r(), $zero) && $comp->eq($a->i(), $zero))) {
                list($real, $imaginary) = $this->getPowExponentPartsFromPolar($a, $exp);
            }

            return new ComplexType(
                RationalTypeFactory::fromFloat($real),
                RationalTypeFactory::fromFloat($imaginary)
            );
        } 
        //non complex
        //de moivres theorum
        //z^n = r^n(cos(n.theta) + sin(n.theta)i)
        //where z is a complex number, r is the radius
        $n = $exp();
        $nTheta = $n * $a->theta()->get();
        $pow = pow($a->modulus()->get(), $n);
        $real = cos($nTheta) * $pow;
        $imaginary = sin($nTheta) * $pow;
        
        return new ComplexType(
                RationalTypeFactory::fromFloat($real),
                RationalTypeFactory::fromFloat($imaginary)
                );        
    }

    /**
     * @param ComplexType $a
     * @param ComplexType $exp
     * @return array [real, imaginary]
     */
    protected function getPowExponentPartsFromPolar(ComplexType $a, ComplexType $exp)
    {
        $eReal = $exp->r()->get();
        $eImaginary = $exp->i()->get();
        $logr = log($a->modulus()->get());
        $theta = $a->theta()->get();
        $rho = exp($logr * $eReal - $eImaginary * $theta);
        $beta = $theta * $eReal + $eImaginary * $logr;

        return [$rho * cos($beta), $rho * sin($beta)];
    }

    /**
     * Complex sqrt
     * 
     * @param \Chippyash\Type\Number\Complex\ComplexType $a
     * @return \Chippyash\Type\Number\Complex\ComplexType result
     */
    public function complexSqrt(ComplexType $a)
    {
        return $this->complexPow($a, RationalTypeFactory::create(1, 2));
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
