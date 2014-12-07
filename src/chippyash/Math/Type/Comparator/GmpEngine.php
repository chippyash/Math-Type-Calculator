<?php
/*
 * Arithmetic calculation support for chippyash Strong Types
 *
 * @author Ashley Kitson <akitson@zf4.biz>
 * @copyright Ashley Kitson, UK, 2014
 * @licence GPL V3 or later : http://www.gnu.org/licenses/gpl.html
 */
namespace chippyash\Math\Type\Comparator;

use chippyash\Math\Type\Comparator\AbstractComparatorEngine;
use chippyash\Type\Interfaces\NumericTypeInterface as NI;
use chippyash\Type\Number\Rational\GMPRationalType;
use chippyash\Type\Number\Rational\RationalTypeFactory;
use chippyash\Type\Number\Complex\GMPComplexType;
use chippyash\Math\Type\Calculator;
use chippyash\Math\Type\Traits\CheckGmpRationalTypes;

/**
 * GMP maths comparator
 *
 */
class GmpEngine extends AbstractComparatorEngine
{
    use CheckGmpRationalTypes;

    /**
     * @var chippyash\Math\Type\Calculator\GmpEngine
     */
    protected $calculator;

    public function __construct()
    {
        $c = new Calculator();
        $this->calculator = $c->getEngine();
    }

    /**
     * a == b = 0
     * a < b = -1
     * a > b = 1
     *
     * @param chippyash\Type\Interfaces\NumericTypeInterface $a
     * @param chippyash\Type\Interfaces\NumericTypeInterface $b
     *
     * @return int
     */
    public function compare(NI $a, NI $b)
    {
        switch ($this->arbitrate($a, $b)) {
            case 'int':
            case 'whole':
            case 'natural':
                return $this->intCompare($a, $b);
            case 'rational':
                list($a, $b) = $this->checkRationalTypes($a, $b);
                return $this->rationalCompare($a, $b);
            case 'complex':
                return $this->complexCompare($a, $b);
            case 'complex:numeric':
                return $this->complexCompare($a, $b->asComplex());
            case 'numeric:complex':
                return $this->complexCompare($a->asComplex(), $b);
            default:
                throw new \Exception('Unsupported type: ' . $this->arbitrate($a, $b));
        }
    }

    /**
     * Compare int types
     *
     * @param chippyash\Type\Interfaces\NumericTypeInterface $a
     * @param chippyash\Type\Interfaces\NumericTypeInterface $b
     * @return int
     */
    protected function intCompare(NI $a, NI $b)
    {
        $test = gmp_cmp($a->gmp(), $b->gmp());
        
        return ($test == 0 ? $test : ($test < 0 ? -1 : 1));
    }

    /**
     * Compare two rationals
     *
     * @param \chippyash\Type\Number\Rational\GMPRationalType $a
     * @param \chippyash\Type\Number\Rational\GMPRationalType $b
     * @return int
     */
    protected function rationalCompare(GMPRationalType $a, GMPRationalType $b)
    {
        $res = $this->calculator->rationalSub($a, $b);

        if ($res->numerator()->get() == 0) {
            return 0;
        }
        if ($res->numerator()->get() < 0) {
            return -1;
        }
        return 1;
    }

    /**
     * Compare complex numbers.
     * If both operands are real then compare the real parts
     * else compare the modulii of the two numbers
     *
     * @param \chippyash\Type\Number\Complex\GMPComplexType $a
     * @param \chippyash\Type\Number\Complex\GMPComplexType $b
     *
     * @return boolean
     */
    protected function complexCompare(GMPComplexType $a, GMPComplexType $b)
    {
        if ($a->isReal()  && $b->isReal()) {
            return $this->rationalCompare($a->r(), $b->r());
        }

        //hack to get around native php integer limitations
        //what we should be doing here is to return $this->rationalCompare($a->modulus(), $b->modulus())
        //but this blows up because of the big rationals it produces
//        $am = $a->modulus()->asFloatType()->get();
//        $bm = $b->modulus()->asFloatType()->get();

        $modA = $a->modulus();
        $modB = $b->modulus();
        
        return $this->rationalCompare($modA, $modB);
//        if ($am == $bm) {
//            return 0;
//        }
//        if ($am < $bm) {
//            return -1;
//        }
//        return 1;
    }
}
