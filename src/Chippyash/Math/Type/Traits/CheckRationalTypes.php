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
use Chippyash\Type\Number\Rational\RationalType;

/**
 * Check for rational type, converting if necessary
 */
trait CheckRationalTypes
{

    /**
     * Check for rational type, converting if necessary
     *
     * @param Chippyash\Type\Interfaces\NumericTypeInterface $a
     * @param Chippyash\Type\Interfaces\NumericTypeInterface $b
     * @return array [RationalType, RationalType]
     */
    protected function checkRationalTypes(NumericTypeInterface $a, NumericTypeInterface $b)
    {
        $a1 = ($a instanceof RationalType ? $a : $a->asRational());
        $b1 = ($b instanceof RationalType ? $b : $b->asRational());

        return [$a1, $b1];
    }

}
