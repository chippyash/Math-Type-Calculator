<?php
/**
 * Arithmetic calculation support for Chippyash Strong Types
 *
 * @author    Ashley Kitson <akitson@zf4.biz>
 * @copyright Ashley Kitson, UK, 2014
 * @licence   GPL V3 or later : http://www.gnu.org/licenses/gpl.html
 */
namespace Chippyash\Math\Type\Calculator;

use Chippyash\Math\Type\Comparator;
use Chippyash\Math\Type\Traits\CheckFloatTypes;
use Chippyash\Math\Type\Traits\CheckIntTypes;
use Chippyash\Math\Type\Traits\CheckRationalTypes;
use Chippyash\Math\Type\Traits\NativeConvertNumeric;
use Chippyash\Type\Interfaces\ComplexTypeInterface as CTI;
use Chippyash\Type\Interfaces\NumericTypeInterface as NTI;
use Chippyash\Type\Interfaces\RationalTypeInterface as RTI;
use Chippyash\Type\Number\Complex\ComplexType;
use Chippyash\Type\Number\Complex\ComplexTypeFactory;
use Chippyash\Type\Number\FloatType;
use Chippyash\Type\Number\IntType;
use Chippyash\Type\Number\NaturalIntType;
use Chippyash\Type\Number\Rational\RationalType;
use Chippyash\Type\Number\Rational\RationalTypeFactory;
use Chippyash\Type\Number\WholeIntType;

/**
 * PHP Native calculation
 */
class NativeEngine implements CalculatorEngineInterface
{
    use NativeConvertNumeric;
    use CheckRationalTypes;
    use CheckIntTypes;
    use CheckFloatTypes;

    /**
     * Integer type addition
     *
     * @param  NTI $a
     * @param  NTI $b
     * @return IntType
     */
    public function intAdd(NTI $a, NTI $b)
    {
        list($a, $b) = $this->checkIntTypes($a, $b);

        return new IntType($a() + $b());
    }

    /**
     * Integer type subtraction
     *
     * @param  NTI $a
     * @param  NTI $b
     * @return IntType
     */
    public function intSub(NTI $a, NTI $b)
    {
        list($a, $b) = $this->checkIntTypes($a, $b);

        return new IntType($a() - $b());
    }

    /**
     * Integer type multiplication
     *
     * @param  NTI $a
     * @param  NTI $b
     * @return IntType
     */
    public function intMul(NTI $a, NTI $b)
    {
        list($a, $b) = $this->checkIntTypes($a, $b);

        return new IntType($a() * $b());
    }

    /**
     * Integer division
     *
     * @param  NTI $a
     * @param  NTI $b
     * @return RTI
     */
    public function intDiv(NTI $a, NTI $b)
    {
        $ra = RationalTypeFactory::create($a);
        $rb = RationalTypeFactory::create($b);
        return $this->rationalDiv($ra, $rb);
    }

    /**
     * Integer Pow - raise number to the exponent
     * Will return an IntType, RationalType or ComplexType
     *
     * @param  IntType $a
     * @param  NTI $exp Exponent
     * @return NTI
     */
    public function intPow(IntType $a, NTI $exp)
    {
        if ($exp instanceof RationalType) {
            return $this->rationalPow(RationalTypeFactory::create($a), $exp);
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
     * @param  IntType $a
     * @return IntType|RationalType result
     */
    public function intSqrt(IntType $a)
    {
        $res = $this->rationalSqrt(RationalTypeFactory::create($a));

        if ($res->isInteger()) {
            return $res->numerator();
        }

        return $res;
    }

    /**
     * Return the natural (base e) logarithm for an integer
     *
     * By definition this is a float
     *
     * @param NTI $a
     *
     * @return FloatType
     */
    public function intNatLog(NTI $a)
    {
        return $this->floatNatLog($a);
    }

    /**
     * Float addition
     *
     * @param  NTI $a
     * @param  NTI $b
     * @return FloatType
     */
    public function floatAdd(NTI $a, NTI $b)
    {
        list($a, $b) = $this->checkFloatTypes($a, $b);
        return new FloatType($a() + $b());
    }

    /**
     * Float subtraction
     *
     * @param  NTI $a
     * @param  NTI $b
     * @return FloatType
     */
    public function floatSub(NTI $a, NTI $b)
    {
        list($a, $b) = $this->checkFloatTypes($a, $b);
        return new FloatType($a() - $b());
    }

    /**
     * Float multiplication
     *
     * @param  NTI $a
     * @param  NTI $b
     * @return FloatType
     */
    public function floatMul(NTI $a, NTI $b)
    {
        list($a, $b) = $this->checkFloatTypes($a, $b);
        return new FloatType($a() * $b());
    }

    /**
     * Float division
     *
     * @param  NTI $a
     * @param  NTI $b
     * @return FloatType
     */
    public function floatDiv(NTI $a, NTI $b)
    {
        list($a, $b) = $this->checkFloatTypes($a, $b);
        return new FloatType($a() / $b());
    }

    /**
     * Float reciprocal i.e. 1/a
     *
     * @param  NTI $a
     * @return FloatType
     */
    public function floatReciprocal(NTI $a)
    {
        return $this->floatDiv(new IntType(1), $a);
    }

    /**
     * Float Pow - raise number to the exponent
     * Will return a float type
     *
     * @param  FloatType $a
     * @param  NTI $exp Exponent
     * @return FloatType
     */
    public function floatPow(FloatType $a, NTI $exp)
    {
        if ($exp instanceof RationalType) {
            return $this->rationalPow(RationalTypeFactory::fromFloat($a()), $exp)->asFloatType();
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
     * @param  FloatType $a
     * @return FloatType result
     */
    public function floatSqrt(FloatType $a)
    {
        return new FloatType(sqrt($a()));
    }

    /**
     * Return the natural (base e) logarithm for a number
     *
     * By definition this is a float (or rational)
     *
     * @param NTI $a
     *
     * @return FloatType
     */
    public function floatNatLog(NTI $a)
    {
        return new FloatType(\log($a()));
    }

    /**
     * Whole number addition
     *
     * @param  NTI $a
     * @param  NTI $b
     * @return WholeIntType
     */
    public function wholeAdd(NTI $a, NTI $b)
    {
        list($a, $b) = $this->checkIntTypes($a, $b);
        return new WholeIntType($a() + $b());
    }

    /**
     * Whole number subtraction
     *
     * @param  NTI $a
     * @param  NTI $b
     * @return WholeIntType
     */
    public function wholeSub(NTI $a, NTI $b)
    {
        list($a, $b) = $this->checkIntTypes($a, $b);
        return new WholeIntType($a() - $b());
    }

    /**
     * Whole number multiplication
     *
     * @param  NTI $a
     * @param  NTI $b
     * @return WholeIntType
     */
    public function wholeMul(NTI $a, NTI $b)
    {
        list($a, $b) = $this->checkIntTypes($a, $b);
        return new WholeIntType($a() * $b());
    }

    /**
     * Natural number addition
     *
     * @param  NTI $a
     * @param  NTI $b
     * @return NaturalIntType
     */
    public function naturalAdd(NTI $a, NTI $b)
    {
        list($a, $b) = $this->checkIntTypes($a, $b);
        return new NaturalIntType($a() + $b());
    }

    /**
     * Natural number subtraction
     *
     * @param  NTI $a
     * @param  NTI $b
     * @return NaturalIntType
     */
    public function naturalSub(NTI $a, NTI $b)
    {
        list($a, $b) = $this->checkIntTypes($a, $b);
        return new NaturalIntType($a() - $b());
    }

    /**
     * Natural number multiplication
     *
     * @param  NTI $a
     * @param  NTI $b
     * @return NaturalIntType
     */
    public function naturalMul(NTI $a, NTI $b)
    {
        list($a, $b) = $this->checkIntTypes($a, $b);
        return new NaturalIntType($a() * $b());
    }

    /**
     * Rational number addition
     *
     * @param  RTI $a
     * @param  RTI $b
     * @return RTI
     */
    public function rationalAdd(RTI $a, RTI $b)
    {
        $lcm = RationalTypeFactory::create($this->lcm($a->denominator()->get(), $b->denominator()->get()));
        $nn = $this->rationalDiv(
            $this->rationalMul(
                RationalTypeFactory::create($a->numerator()),
                $lcm
            ),
            RationalTypeFactory::create($a->denominator())
        )->get();
        $nd = $this->rationalDiv(
            $this->rationalMul(
                RationalTypeFactory::create($b->numerator()),
                $lcm
            ),
            RationalTypeFactory::create($b->denominator())
        )->get();
        $n = $this->intAdd(new IntType($nn), new IntType($nd));

        return RationalTypeFactory::create($n, $lcm->numerator());
    }

    /**
     * Rational number subtraction
     *
     * @param  RTI $a
     * @param  RTI $b
     * @return RTI
     */
    public function rationalSub(RTI $a, RTI $b)
    {
        list($a, $b) = $this->checkRationalTypes($a, $b);
        $lcm = RationalTypeFactory::create($this->lcm($a->denominator()->get(), $b->denominator()->get()));
        $nn = $this->rationalDiv(
            $this->rationalMul(
                RationalTypeFactory::create($a->numerator()),
                $lcm
            ),
            RationalTypeFactory::create($a->denominator())
        )->get();
        $nd = $this->rationalDiv(
            $this->rationalMul(
                RationalTypeFactory::create($b->numerator()),
                $lcm
            ),
            RationalTypeFactory::create($b->denominator())
        )->get();
        $n = $this->intSub(new IntType($nn), new IntType($nd));

        return RationalTypeFactory::create($n, $lcm->numerator());
    }

    /**
     * Rational number multiplication
     *
     * @param  RTI $a
     * @param  RTI $b
     * @return RTI
     */
    public function rationalMul(RTI $a, RTI $b)
    {
        list($a, $b) = $this->checkRationalTypes($a, $b);
        return RationalTypeFactory::fromFloat($a() * $b());
    }

    /**
     * Rational number division
     *
     * @param  RTI $a
     * @param  RTI $b
     * @return RTI
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
     * @param  RTI $a
     * @return RTI
     */
    public function rationalReciprocal(RTI $a)
    {
        return RationalTypeFactory::create($a->denominator(), $a->numerator());
    }

    /**
     * Rational Pow - raise number to the exponent
     * Will return a RationalType
     *
     * @param  RTI $a
     * @param  NTI $exp Exponent
     * @return RTI
     */
    public function rationalPow(RTI $a, NTI $exp)
    {
        if ($exp instanceof ComplexType) {
            $r = $this->floatComplexPow($a(), $exp);
            return ($r instanceof FloatType ? RationalTypeFactory::fromFloat($r()) : $r);
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
     * @param  RTI $a
     * @return RTI result
     */
    public function rationalSqrt(RTI $a)
    {
        $num = sqrt($a->numerator()->get());
        $den = sqrt($a->denominator()->get());
        return $this->rationalDiv(
            RationalTypeFactory::fromFloat($num),
            RationalTypeFactory::fromFloat($den)
        );
    }

    /**
     * Return the natural (base e) logarithm for a rational
     *
     * By definition this is a rational given a rational
     *
     * @param RTI $a
     *
     * @return RationalType
     */
    public function rationalNatLog(RTI $a)
    {
        return RationalTypeFactory::fromFloat($this->floatNatLog($a));
    }

    /**
     * Complex number addition
     *
     * @param  CTI $a
     * @param  CTI $b
     * @return CTI
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
     * @param  CTI $a
     * @param  CTI $b
     * @return CTI
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
     * @param  CTI $a
     * @param  CTI $b
     * @return CTI
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
     * @param  CTI $a
     * @param  CTI $b
     * @return CTI
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
        $r = $this->rationalDiv(
            $this->rationalAdd(
                $this->rationalMul($a->r(), $b->r()),
                $this->rationalMul($a->i(), $b->i())
            ),
            $div
        );
        //i = ((ai * br) - (ar * bi)) / div
        $i = $this->rationalDiv(
            $this->rationalSub(
                $this->rationalMul($a->i(), $b->r()),
                $this->rationalMul($a->r(), $b->i())
            ),
            $div
        );

        return ComplexTypeFactory::create($r, $i);
    }

    /**
     * Complex number reciprocal: 1/a+bi
     *
     * @param  CTI $a
     * @return CTI
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
     * @return \Chippyash\Type\Number\Complex\ComplexType
     *
     * @throws \InvalidArgumentException If exponent is complex
     */
    public function complexPow(CTI $a, NTI $exp)
    {
        if ($exp instanceof ComplexType) {
            $comp = new Comparator();
            $zero = new IntType(0);
            $real = 0;
            $imaginary = 0;
            if (!($comp->eq($a->r(), $zero) && $comp->eq($a->i(), $zero))) {
                $er = $exp->r()->get();
                $ei = $exp->i()->get();
                $logr = log($a->modulus()->get());
                $theta = $a->theta()->get();
                $rho = exp($logr * $er - $ei * $theta);
                $beta = $theta * $er + $ei * $logr;
                $real = $rho * cos($beta);
                $imaginary = $rho * sin($beta);
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
     * Complex sqrt
     *
     * @param  CTI $a
     * @return CTI result
     */
    public function complexSqrt(CTI $a)
    {
        return $this->complexPow($a, RationalTypeFactory::create(1, 2));
    }

    /**
     * Return the natural (base e) logarithm for a complex number
     *
     * By definition this is a rational
     *
     * If the C isReal then log(C.realPart) else log(modulus(C))
     *
     * @param CTI $a
     *
     * @return RationalType
     */
    public function complexNatLog(CTI $a)
    {
        if ($a->isReal()) {
            return RationalTypeFactory::fromFloat(\log($a()));
        }

        return RationalTypeFactory::fromFloat(\log($a->modulus()->get()));
    }


    /**
     * In place increment an IntType
     *
     * @param NTI $a
     * @param int|float|NTI $inc
     */
    public function incInt(NTI $a, $inc = 1)
    {
        $increment = ($inc instanceof NTI ? intval($inc()) : intval($inc));
        $a->set($a() + $increment);
    }

    /**
     * In place increment a FloatType
     *
     * @param NTI $a
     * @param int|float|NTI $inc
     */
    public function incFloat(NTI $a, $inc = 1)
    {
        $increment = ($inc instanceof NTI ? floatval($inc()) : floatval($inc));
        $a->set($a() + $increment);
    }

    /**
     * In place increment a RationalType
     *
     * @param RTI $a
     * @param int|float|NTI $inc
     */
    public function incRational(RTI $a, $inc = 1)
    {
        $this->incInt($a->numerator(), $inc);
    }

    /**
     * In place increment a ComplexType
     *
     * @param CTI $a
     * @param int|float|NTI $inc
     */
    public function incComplex(CTI $a, $inc = 1)
    {
        $this->incRational($a->r(), $inc);
    }

    /**
     * In place decrement an IntType
     *
     * @param NTI $a
     * @param int|float|NTI $dec
     */
    public function decInt(NTI $a, $dec = 1)
    {
        $decrement = ($dec instanceof NTI ? intval($dec()) : intval($dec));
        $a->set($a() - $decrement);
    }

    /**
     * In place decrement a FloatType
     *
     * @param NTI $a
     * @param int|float|NTI $dec
     */
    public function decFloat(NTI $a, $dec = 1)
    {
        $decrement = ($dec instanceof NTI ? floatval($dec()) : floatval($dec));
        $a->set($a() - $decrement);
    }

    /**
     * In place decrement a RationalType
     *
     * @param RTI $a
     * @param int|float|NTI $dec
     */
    public function decRational(RTI $a, $dec = 1)
    {
        $this->decInt($a->numerator(), $dec);
    }

    /**
     * In place decrement a ComplexType
     *
     * @param CTI $a
     * @param int|float|NTI $dec
     */
    public function decComplex(CTI $a, $dec = 1)
    {
        $this->decRational($a->r(), $dec);
    }

    /**
     * @param int|float|NTI $a base
     * @param ComplexType $exp exponent
     *
     * @return RTI|ComplexType|IntType
     */
    private function intComplexPow($a, ComplexType $exp)
    {
        if ($exp->isZero()) {
            return new IntType(1);
        }
        return $this->complexExponent($a, $exp);
    }

    /**
     * @param int|float|NTI $a base
     * @param ComplexType $exp exponent
     *
     * @return RTI|ComplexType|FloatType
     */
    private function floatComplexPow($a, ComplexType $exp)
    {
        if ($exp->isZero()) {
            return new FloatType(1);
        }
        return $this->complexExponent($a, $exp);
    }

    /**
     * @param int|float|NTI $base base
     * @param ComplexType $exp exponent
     *
     * @return RTI|ComplexType
     */
    private function complexExponent($base, ComplexType $exp)
    {
        if ($exp->isReal()) {
            return $this->rationalPow(
                RationalTypeFactory::fromFloat($base),
                $exp->r()
            );
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
                RationalTypeFactory::fromFloat($i)
            );
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
     * @param  int $a
     * @param  int $b
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
