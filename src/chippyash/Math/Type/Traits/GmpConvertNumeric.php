<?php
/*
 * Arithmetic calculation support for chippyash Strong Types
 *
 * @author Ashley Kitson <akitson@zf4.biz>
 * @copyright Ashley Kitson, UK, 2014
 * @licence GPL V3 or later : http://www.gnu.org/licenses/gpl.html
 */
namespace chippyash\Math\Type\Traits;

use chippyash\Type\Number\FloatType;
use chippyash\Type\Number\IntType;
use chippyash\Type\Number\GmpIntType;
use chippyash\Type\Number\Rational\RationalTypeFactory;

/**
 * Native calculator/comparator int/float conversion
 */
trait GmpConvertNumeric
{
    /**
     * Convert float or int into relevant strong type
     *
     * @param numeric $num
     * @return \chippyash\Type\Number\RationalGMPRationalType|\chippyash\Type\Number\GMPIntType
     */
    public function convertNumeric($num)
    {
        if (is_float($num)) {
            return RationalTypeFactory::fromFloat($num);
        }
        //default
        return new GMPIntType($num);
    }
}
