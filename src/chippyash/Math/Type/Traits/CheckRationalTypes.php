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
        return [$this->checkRationalType($a), $this->checkRationalType($b)];
    }

    /**
     * Check and convert to RationalType if required
     * @param NumericTypeInterface $a
     * @return RationalType
     */
    protected function checkRationalType(NumericTypeInterface $a)
    {
        if (!$a instanceof RationalType) {
            return $a->asRational();
        } 
        return $a;
    }
}
