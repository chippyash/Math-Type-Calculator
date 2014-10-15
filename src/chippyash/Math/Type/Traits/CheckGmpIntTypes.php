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
use chippyash\Type\Interfaces\GMPInterface;
use chippyash\Type\Number\GMPIntType;
use chippyash\Type\Number\IntType;

/**
 * Check for GMP Int type, converting if necessary
 */
trait CheckGmpIntTypes
{

    /**
     * Check for gmp integer type, converting if necessary
     *
     * @param chippyash\Type\Interfaces\NumericTypeInterface $a
     * @param chippyash\Type\Interfaces\NumericTypeInterface $b
     * @return array [IntType, IntType]
     */
    protected function checkIntTypes(NumericTypeInterface $a, NumericTypeInterface $b)
    {
        if (!$a instanceof GMPIntType) {
            $a1 = new GMPIntType($a());
        } else {
            $a1 = $a;
        }
        if (!$b instanceof GMPIntType) {
            $b1 = new GMPIntType($b());
        } else {
            $b1 = $b;
        }

        return [$a1, $b1];
    }
}
