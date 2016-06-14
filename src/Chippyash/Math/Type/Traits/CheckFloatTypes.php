<?php

/**
 * Arithmetic calculation support for Chippyash Strong Types
 *
 * @author    Ashley Kitson <akitson@zf4.biz>
 * @copyright Ashley Kitson, UK, 2014
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
     * @param NumericTypeInterface $a first candidate
     * @param NumericTypeInterface $b second candidate
     *
     * @return array [FloatType, FloatType]
     */
    protected function checkFloatTypes(NumericTypeInterface $a, NumericTypeInterface $b)
    {
        return [$this->checkFloatType($a), $this->checkFloatType($b)];
    }

    /**
     * @param NumericTypeInterface $a operand
     *
     * @return NumericTypeInterface|FloatType
     */
    protected function checkFloatType(NumericTypeInterface $a)
    {
        if (!$a instanceof FloatType) {
            return $a->asFloatType();
        }

        return $a;
    }
}
