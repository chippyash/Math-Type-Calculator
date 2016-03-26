<?php
/*
 * Arithmetic calculation support for Chippyash Strong Types
 *
 * @author Ashley Kitson <akitson@zf4.biz>
 * @copyright Ashley Kitson, UK, 2014
 * @licence GPL V3 or later : http://www.gnu.org/licenses/gpl.html
 */
namespace Chippyash\Math\Type\Comparator;

use Chippyash\Math\Type\Comparator\ComparatorEngineInterface;
use Chippyash\Math\Type\Traits\ArbitrateTwoTypes;
use Chippyash\Type\Interfaces\NumericTypeInterface as NI;

/**
 * Basic implementation of a comparator engine
 *
 * Complex types (c) can only be compared to non Complex types iff:
 *  - c->isReal() || c->isZero()
 *
 * Comparison of Rational to non Rational types will convert the non Rational
 * to a Rational for the comparison
 *
 * Comparison of Float with Int will convert both to Rational for comparison
 */
abstract class AbstractComparatorEngine implements ComparatorEngineInterface
{
    use ArbitrateTwoTypes;

    /**
     * a == b
     *
     * @param Chippyash\Type\Interfaces\NumericTypeInterface $a
     * @param Chippyash\Type\Interfaces\NumericTypeInterface $b
     *
     * @return boolean
     */
    public function eq(NI $a, NI $b)
    {
        return ($this->compare($a, $b) == 0);
    }

    /**
     * a != b
     *
     * @param Chippyash\Type\Interfaces\NumericTypeInterface $a
     * @param Chippyash\Type\Interfaces\NumericTypeInterface $b
     *
     * @return boolean
     */

    public function neq(NI $a, NI $b)
    {
        return ($this->compare($a, $b) != 0);
    }

    /**
     * a < b
     *
     * @param Chippyash\Type\Interfaces\NumericTypeInterface $a
     * @param Chippyash\Type\Interfaces\NumericTypeInterface $b
     *
     * @return boolean
     */
    public function lt(NI $a, NI $b)
    {
        return ($this->compare($a, $b) == -1);
    }

    /**
     * a <= b
     *
     * @param Chippyash\Type\Interfaces\NumericTypeInterface $a
     * @param Chippyash\Type\Interfaces\NumericTypeInterface $b
     *
     * @return boolean
     */
    public function lte(NI $a, NI $b)
    {
        return ($this->compare($a, $b) != 1);
    }

    /**
     * a > b
     *
     * @param Chippyash\Type\Interfaces\NumericTypeInterface $a
     * @param Chippyash\Type\Interfaces\NumericTypeInterface $b
     *
     * @return boolean
     */
    public function gt(NI $a, NI $b)
    {
        return ($this->compare($a, $b) == 1);
    }

    /**
     * a >= b
     *
     * @param Chippyash\Type\Interfaces\NumericTypeInterface $a
     * @param Chippyash\Type\Interfaces\NumericTypeInterface $b
     *
     * @return boolean
     */
    public function gte(NI $a, NI $b)
    {
        return ($this->compare($a, $b) != -1);
    }

    /**
     * a == b = 0
     * a < b = -1
     * a > b = 1
     *
     * @param Chippyash\Type\Interfaces\NumericTypeInterface $a
     * @param Chippyash\Type\Interfaces\NumericTypeInterface $b
     *
     * @return int
     */
    abstract public function compare(NI $a, NI $b);

}
