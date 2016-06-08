<?php
/*
 * Arithmetic calculation support for Chippyash Strong Types
 *
 * @author Ashley Kitson <akitson@zf4.biz>
 * @copyright Ashley Kitson, UK, 2014
 * @licence GPL V3 or later : http://www.gnu.org/licenses/gpl.html
 */
namespace Chippyash\Math\Type\Comparator;

use Chippyash\Type\Interfaces\NumericTypeInterface as NI;
use Chippyash\Type\Interfaces\NumericTypeInterface;
use Chippyash\Type\Number\Rational\GMPRationalType;
use Chippyash\Type\Number\Rational\RationalTypeFactory;
use Chippyash\Type\Number\Complex\GMPComplexType;
use Chippyash\Math\Type\Calculator\GmpEngine as Calc;
use Chippyash\Math\Type\Traits\CheckGmpRationalTypes;

/**
 * PHP Native maths comparator
 *
 */
class GmpEngine extends AbstractComparatorEngine
{
    use CheckGmpRationalTypes;

    protected $calculator;

    /**
     * Native constructor.
     * side effect: Ensure that Type Factories use PHP Native types
     */
    public function __construct()
    {
        $this->calculator = new Calc();
    }

    /**
     * a == b = 0 (or a ≈ b)
     * a < b = -1
     * a > b = 1
     *
     * if tolerance is supplied, then equality is determined within a tolerance limit
     * 0 <= abs(a-b) <= tolerance
     *
     * @param NI $a
     * @param NI $b
     * @param NI $tolerance default = exact
     *
     * @return int
     */
    public function compare(NI $a, NI $b, NI $tolerance = null)
    {
        switch ($this->arbitrate($a, $b)) {
            case 'int':
            case 'whole':
            case 'natural':
            case 'float':
            case 'rational':
                list($a, $b) = $this->checkRationalTypes($a, $b);
                return $this->rationalCompare($a, $b, $tolerance);
            case 'complex':
                return $this->complexCompare($a->asGMPComplex(), $b->asGMPComplex(), $tolerance);
        }
    }

    /**
     * Compare two rationals
     *
     * @param GMPRationalType $a
     * @param GMPRationalType $b
     * @param NI $tolerance
     * 
     * @return int
     */
    protected function rationalCompare(GMPRationalType $a, GMPRationalType $b, NI $tolerance = null)
    {
        $aa = $a->asFloatType()->get();
        $bb = $b->asFloatType()->get();
        $cc = $aa - $bb;
        $res = $this->calculator->rationalSub($a, $b);
        $rr = $res->asFloatType()->get();
        $sr = (string) $res;
        if (is_null($tolerance)) {
            //no tolerance so return sign()
            $s = $res->sign();
            $v = $res->asFloatType()->get();
            return $res->sign();
        }
        //working to an equality tolerance
        $aRes = $res->abs();
        $va = $aRes->asFloatType()->get();
        $tt = $tolerance->asFloatType()->get();
        if ($this->rationalCompare($aRes, RationalTypeFactory::create(0)) >= 0
            && $this->rationalCompare($aRes, $this->checkRationalType($tolerance)) <= 0)
        {
            return 0;
        }
        
        return $res->sign();
    }

    /**
     * Compare complex numbers.
     * If both operands are real then compare the real parts
     * else compare the modulii of the two numbers
     *
     * @param GMPComplexType $a
     * @param GMPComplexType $b
     * @param NI $tolerance
     *
     * @return boolean
     */
    protected function complexCompare(GMPComplexType $a, GMPComplexType $b, NI $tolerance = null)
    {
        if ($a->isReal()  && $b->isReal()) {
            return $this->rationalCompare($a->r(), $b->r(), $tolerance);
        }

        return $this->rationalCompare($a->modulus(), $b->modulus(), $tolerance);
    }
}
