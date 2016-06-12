<?php
/**
 * Arithmetic calculation support for Chippyash Strong Types
 *
 * @author    Ashley Kitson <akitson@zf4.biz>
 * @copyright Copyright (c) 2014, Ashley Kitson, UK
 * @licence   GPL V3 or later : http://www.gnu.org/licenses/gpl.html
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
     * @param  NumericTypeInterface $a
     * @param  NumericTypeInterface $b
     * @return array [FloatType, FloatType]
     */
    protected function checkFloatTypes(NumericTypeInterface $a, NumericTypeInterface $b)
    {
        $a1 = ($a instanceof FloatType ? $a : $a->asFloatType());
        $b1 = ($b instanceof FloatType ? $b : $b->asFloatType());

        return [$a1, $b1];
    }
}
