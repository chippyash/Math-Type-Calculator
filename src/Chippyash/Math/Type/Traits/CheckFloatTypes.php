<?php

/*
 * Arithmetic calculation support for Chippyash Strong Types
 *
 * @author Ashley Kitson <akitson@zf4.biz>
 * @copyright Ashley Kitson, UK, 2014
 * @licence GPL V3 or later : http://www.gnu.org/licenses/gpl.html
 */

namespace Chippyash\Math\Type\Traits;

use Chippyash\Type\Interfaces\NumericTypeInterface;
use Chippyash\Type\Number\FloatType;

/**
 * Check for Float type, converting if necessary
 */
trait CheckFloatTypes
{
    /**
     * Check for float type, converting if necessary
     *
     * @param Chippyash\Type\Interfaces\NumericTypeInterface $a
     * @param Chippyash\Type\Interfaces\NumericTypeInterface $b
     * @return array [FloatType, FloatType]
     */
    protected function checkFloatTypes(NumericTypeInterface $a, NumericTypeInterface $b)
    {
        $a1 = ($a instanceof FloatType ? $a : $a->asFloatType());
        $b1 = ($b instanceof FloatType ? $b : $b->asFloatType());

        return [$a1, $b1];
    }
}
