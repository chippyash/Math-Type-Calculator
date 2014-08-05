<?php

/*
 * Arithmetic calculation support for chippyash Strong Types
 *
 * @author Ashley Kitson <akitson@zf4.biz>
 * @copyright Ashley Kitson, UK, 2014
 * @licence GPL V3 or later : http://www.gnu.org/licenses/gpl.html
 */

namespace chippyash\Math\Type\Traits;

use chippyash\Type\Number\NumericTypeInterface;
use chippyash\Type\Number\IntType;

/**
 * Check for Int type, converting if necessary
 */
trait CheckIntTypes
{

    /**
     * Check for integer type, converting if necessary
     *
     * @param \chippyash\Type\Number\NumericTypeInterface $a
     * @param \chippyash\Type\Number\NumericTypeInterface $b
     * @return array [IntType, IntType]
     */
    protected function checkIntTypes(NumericTypeInterface $a, NumericTypeInterface $b)
    {
        if (!$a instanceof IntType) {
            $a1 = $a->asIntType();
        } else {
            $a1 = $a;
        }
        if (!$b instanceof IntType) {
            $b1 = $b->asIntType();
        } else {
            $b1 = $b;
        }

        return [$a1, $b1];
    }
}
