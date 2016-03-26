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

/**
 * Defines an interface that type comparator engines must conform to
 *
 */
interface ComparatorEngineInterface
{
    /**
     * a == b = 0
     * a < b = -1
     * a > b = 1
     *
     * @param \Chippyash\Type\Interfaces\NumericTypeInterface $a
     * @param \Chippyash\Type\Interfaces\NumericTypeInterface $b
     *
     * @return int
     */
    public function compare(NI $a, NI $b);
}
