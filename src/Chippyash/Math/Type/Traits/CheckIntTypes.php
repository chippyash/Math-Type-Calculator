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
use Chippyash\Type\Number\IntType;

/**
 * Check for Int type, converting if necessary
 */
trait CheckIntTypes
{

    /**
     * Check for integer type, converting if necessary
     *
     * @param Chippyash\Type\Interfaces\NumericTypeInterface $a
     * @param Chippyash\Type\Interfaces\NumericTypeInterface $b
     * @return array [IntType, IntType]
     */
    protected function checkIntTypes(NumericTypeInterface $a, NumericTypeInterface $b)
    {
        $a1 = ($a instanceof IntType ? $a : $a->asIntType());
        $b1 = ($a instanceof IntType ? $b : $b->asIntType());

        return [$a1, $b1];
    }
}
