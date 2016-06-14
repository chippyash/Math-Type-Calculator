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
use chippyash\Type\Number\Rational\GMPRationalType;
use chippyash\Type\Number\Rational\RationalTypeFactory;

/**
 * Check for Float type, converting to GmpRationalType if necessary
 */
trait CheckGmpFloatTypes
{
    /**
     * Check for float type, converting if necessary
     *
     * @param  NumericTypeInterface $a
     * @param  NumericTypeInterface $b
     * @return array [GmpRationalType, GmpRationalType]
     */
    protected function checkFloatTypes(NumericTypeInterface $a, NumericTypeInterface $b)
    {
        return [$this->checkFloatType($a), $this->checkFloatType($b)];
    }

    /**
     * @param NumericTypeInterface $a operand
     *
     * @return NumericTypeInterface|GMPRationalType|\Chippyash\Type\Number\Rational\RationalType
     */
    protected function checkFloatType(NumericTypeInterface $a)
    {
        if (!$a instanceof GMPRationalType) {
            return RationalTypeFactory::fromFloat($a());
        }

        return $a;
    }
}
