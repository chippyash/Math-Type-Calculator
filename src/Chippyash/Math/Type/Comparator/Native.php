<?php
/**
 * Arithmetic calculation support for Chippyash Strong Types
 *
 * @author    Ashley Kitson <akitson@zf4.biz>
 * @copyright Copyright (c) 2014, Ashley Kitson, UK
 * @licence   GPL V3 or later : http://www.gnu.org/licenses/gpl.html
 */
namespace Chippyash\Math\Type\Comparator;

use Chippyash\Math\Type\Calculator\Native as Calc;
use Chippyash\Math\Type\Traits\CheckRationalTypes;
use Chippyash\Type\Interfaces\NumericTypeInterface as NI;
use Chippyash\Type\Number\Complex\ComplexType;
use Chippyash\Type\Number\Rational\RationalType;
use Chippyash\Type\Number\Rational\RationalTypeFactory;

/**
 * PHP Native maths comparator
 */
class Native extends AbstractComparatorEngine
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
     * a == b = 0
     * a < b = -1
     * a > b = 1
     *
     * @param NI $a first term
     * @param NI $b second term
     *
     * @return int
     *
     * @noinspection PhpInconsistentReturnPointsInspection
     */
    public function compare(NI $a, NI $b)
    {
        switch ($this->arbitrate($a, $b)) {
            case 'int':
            case 'whole':
            case 'natural':
            case 'float':
                return $this->intFloatCompare($a, $b);
            case 'rational':
                list($a, $b) = $this->checkRationalTypes($a, $b);
                return $this->rationalCompare($a, $b);
            case 'complex':
                return $this->complexCompare($a, $b);
            case 'complex:numeric':
                return $this->complexCompare($a, $b->asComplex());
            case 'numeric:complex':
                return $this->complexCompare($a->asComplex(), $b);
        }
    }

    /**
     * Compare int and float types
     *
     * @param  NI $a
     * @param  NI $b
     * @return int
     */
    protected function intFloatCompare(NI $a, NI $b)
    {
        return $this->rationalCompare(
            RationalTypeFactory::fromFloat($a->asFloatType()),
            RationalTypeFactory::fromFloat($b->asFloatType())
        );
    }

    /**
     * Compare two rationals
     *
     * @param  RationalType $a
     * @param  RationalType $b
     * @return int
     */
    protected function rationalCompare(RationalType $a, RationalType $b)
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
     * @param ComplexType $a
     * @param ComplexType $b
     *
     * @return boolean
     */
    protected function complexCompare(ComplexType $a, ComplexType $b)
    {
        if ($a->isReal() && $b->isReal()) {
            return $this->rationalCompare($a->r(), $b->r());
        }

        //hack to get around native php integer limitations
        //what we should be doing here is to return $this->rationalCompare($a->modulus(), $b->modulus())
        //but this blows up because of the big rationals it produces
        $am = $a->modulus()->asFloatType()->get();
        $bm = $b->modulus()->asFloatType()->get();

        if ($am == $bm) {
            return 0;
        }
        if ($am < $bm) {
            return -1;
        }
        return 1;
    }
}
