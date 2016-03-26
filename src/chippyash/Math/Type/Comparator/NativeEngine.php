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
use chippyash\Type\Number\Rational\RationalType;
use chippyash\Type\Number\Rational\RationalTypeFactory;
use chippyash\Type\Number\Complex\ComplexType;
use chippyash\Math\Type\Calculator;
use chippyash\Math\Type\Traits\CheckRationalTypes;

/**
 * PHP Native maths comparator
 *
 */
class NativeEngine extends AbstractComparatorEngine
{
    use CheckRationalTypes;

    /**
     * @var chippyash\Math\Type\Calculator\NativeEngine
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
     * @param chippyash\Type\Interfaces\NumericTypeInterface $a
     * @param chippyash\Type\Interfaces\NumericTypeInterface $b
     * @return int
     */
    protected function intFloatCompare(NI $a, NI $b)
    {
        return $this->rationalCompare(
                RationalTypeFactory::fromFloat($a()),
                RationalTypeFactory::fromFloat($b()));
    }

    /**
     * Compare two rationals
     *
     * @param \chippyash\Type\Number\Rational\RationalType $a
     * @param \chippyash\Type\Number\Rational\RationalType $b
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
     * @param \chippyash\Type\Number\Complex\ComplexType $a
     * @param \chippyash\Type\Number\Complex\ComplexType $b
     *
     * @return boolean
     */
    protected function complexCompare(ComplexType $a, ComplexType $b)
    {
        if ($a->isReal()  && $b->isReal()) {
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