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
use chippyash\Type\TypeFactory;
use chippyash\Type\Number\FloatType;

/**
 * Check for Float type, converting if necessary
 */
trait CheckFloatTypes
{
    /**
     * Check for float type, converting if necessary
     *
     * @param \chippyash\Type\Number\NumericTypeInterface $a
     * @param \chippyash\Type\Number\NumericTypeInterface $b
     * @return array [FloatType, FloatType]
     */
    protected function checkFloatTypes(NumericTypeInterface $a, NumericTypeInterface $b)
    {
        if (!$a instanceof FloatType) {
            $a1 = $a->asFloatType();
        } else {
            $a1 = $a;
        }
        if (!$b instanceof FloatType) {
            $b1 = $b->asFloatType();
        } else {
            $b1 = $b;
        }

        return [$a1, $b1];
    }
}
