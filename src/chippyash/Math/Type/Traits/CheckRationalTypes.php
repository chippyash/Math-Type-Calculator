<?php

/*
 * Arithmetic calculation support for chippyash Strong Types
 *
 * @author Ashley Kitson <akitson@zf4.biz>
 * @copyright Ashley Kitson, UK, 2014
 * @licence GPL V3 or later : http://www.gnu.org/licenses/gpl.html
 */

namespace chippyash\Math\Type\Traits;

use chippyash\Type\Interfaces\NumericTypeInterface;
use chippyash\Type\Number\Rational\RationalType;

/**
 * Check for rational type, converting if necessary
 */
trait CheckRationalTypes
{

    /**
     * Check for rational type, converting if necessary
     *
     * @param chippyash\Type\Interfaces\NumericTypeInterface $a
     * @param chippyash\Type\Interfaces\NumericTypeInterface $b
     * @return array [RationalType, RationalType]
     */
    protected function checkRationalTypes(NumericTypeInterface $a, NumericTypeInterface $b)
    {
        if (!$a instanceof RationalType) {
            $a1 = $a->asRational();
        } else {
            $a1 = $a;
        }
        if (!$b instanceof RationalType) {
            $b1 = $b->asRational();
        } else {
            $b1 = $b;
        }

        return [$a1, $b1];
    }

}
