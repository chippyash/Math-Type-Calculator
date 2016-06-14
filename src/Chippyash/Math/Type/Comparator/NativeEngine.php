<?php
/**
 * Arithmetic calculation support for Chippyash Strong Types
 *
 * @author    Ashley Kitson <akitson@zf4.biz>
 * @copyright Ashley Kitson, UK, 2014
 * @licence   GPL V3 or later : http://www.gnu.org/licenses/gpl.html
 */
namespace Chippyash\Math\Type\Comparator;

use Chippyash\Math\Type\Calculator\NativeEngine as Calc;
use Chippyash\Math\Type\Traits\CheckRationalTypes;
use Chippyash\Type\Interfaces\NumericTypeInterface as NI;
use Chippyash\Type\Number\Complex\ComplexType;
use Chippyash\Type\Number\Rational\RationalType;
use Chippyash\Type\Number\Rational\RationalTypeFactory;

/**
 * PHP Native maths comparator
 */
class NativeEngine extends AbstractComparatorEngine
{
    use CheckRationalTypes;

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
                return $this->intFloatCompare($a, $b, $tolerance);
            case 'rational':
                list($a, $b) = $this->checkRationalTypes($a, $b);
                return $this->rationalCompare($a, $b, $tolerance);
            case 'complex':
                return $this->complexCompare($a->asComplex(), $b->asComplex(), $tolerance);
        }
    }

    /**
     * Compare int and float types
     *
     * @param  NI $a
     * @param  NI $b
     * @param  NI $tolerance
     * @return int
     */
    protected function intFloatCompare(NI $a, NI $b, NI $tolerance = null)
    {
        return $this->rationalCompare(
            RationalTypeFactory::fromFloat($a->asFloatType()),
            RationalTypeFactory::fromFloat($b->asFloatType()),
            $tolerance
        );
    }

    /**
     * Compare two rationals
     *
     * @param  RationalType $a
     * @param  RationalType $b
     * @param  NI $tolerance
     * @return int
     */
    protected function rationalCompare(RationalType $a, RationalType $b, NI $tolerance = null)
    {
        $res = $this->calculator->rationalSub($a, $b);

        if (is_null($tolerance)) {
            //no tolerance so return sign()
            return $res->sign();
        }
        //working to an equality tolerance
        $aRes = abs($res->get());
        if ($aRes >= 0 && $aRes <= $tolerance->get()) {
            return 0;
        }
        return $res->sign();
    }

    /**
     * Compare complex numbers.
     * If both operands are real then compare the real parts
     * else compare the modulii of the two numbers
     *
     * @param ComplexType $a
     * @param ComplexType $b
     * @param NI $tolerance
     *
     * @return boolean
     */
    protected function complexCompare(ComplexType $a, ComplexType $b, NI $tolerance = null)
    {
        if ($a->isReal() && $b->isReal()) {
            return $this->rationalCompare($a->r(), $b->r(), $tolerance);
        }

        //hack to get around native php integer limitations
        //what we should be doing here is to return $this->rationalCompare($a->modulus(), $b->modulus())
        //but this blows up because of the big rationals it produces
        $am = $a->modulus()->asFloatType()->get();
        $bm = $b->modulus()->asFloatType()->get();
        $isWithinTolerance = (is_null($tolerance) ? false : true);


        if (!$isWithinTolerance && $am == $bm) {
            return 0;
        }
        if ($isWithinTolerance) {
            $aRes = abs($am - $bm);
            if ($aRes >= 0 && $aRes <= $tolerance->get()) {
                return 0;
            }
        }
        if ($am < $bm) {
            return -1;
        }
        return 1;
    }
}
