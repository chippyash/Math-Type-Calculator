<?php

/**
 * Arithmetic calculation support for chippyash Strong Types
 *
 * @author    Ashley Kitson <akitson@zf4.biz>
 * @copyright Ashley Kitson, UK, 2014
 * @licence   GPL V3 or later : http://www.gnu.org/licenses/gpl.html
 */

namespace chippyash\Math\Type\Traits;

use chippyash\Type\Interfaces\NumericTypeInterface;
use chippyash\Type\Number\GMPIntType;

/**
 * Check for GMP Int type, converting if necessary
 */
trait CheckGmpIntTypes
{

    /**
     * Check for gmp integer type, converting if necessary
     *
     * @param  NumericTypeInterface $a
     * @param  NumericTypeInterface $b
     * @return array [IntType, IntType]
     */
    protected function checkIntTypes(NumericTypeInterface $a, NumericTypeInterface $b)
    {
        return [$this->checkIntType($a), $this->checkIntType($b)];
    }

    /**
     * Check for gmp integer type, converting if necessary
     *
     * @param  NumericTypeInterface $a
     * @return GMPIntType
     */
    protected function checkIntType(NumericTypeInterface $a)
    {
        if (!$a instanceof GMPIntType) {
            return new GMPIntType($a());
        }

        return $a;
    }
}
