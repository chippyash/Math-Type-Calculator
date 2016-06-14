<?php

/**
 * Arithmetic calculation support for chippyash Strong Types
 *
 * @author    Ashley Kitson <akitson@zf4.biz>
 * @copyright Ashley Kitson, UK, 2014
 * @licence   GPL V3 or later : http://www.gnu.org/licenses/gpl.html
 */

namespace chippyash\Math\Type\Traits;

use Chippyash\Type\Interfaces\NumericTypeInterface;
use Chippyash\Type\Number\Rational\GMPRationalType;

/**
 * Check for rational type, converting if necessary
 */
trait CheckGmpRationalTypes
{

    /**
     * Check for rational type, converting if necessary
     *
     * @param  NumericTypeInterface $a
     * @param  NumericTypeInterface $b
     * @return array [RationalType, RationalType]
     */
    protected function checkRationalTypes(NumericTypeInterface $a, NumericTypeInterface $b)
    {
        return [$this->checkRationalType($a), $this->checkRationalType($b)];
    }

    /**
     * Check and convert to RationalType if required
     * @param NumericTypeInterface $a
     * @return GmpRationalType
     */
    protected function checkRationalType(NumericTypeInterface $a)
    {
        if (!$a instanceof GMPRationalType) {
            return $a->asRational();
        }
        return $a;
    }
}
