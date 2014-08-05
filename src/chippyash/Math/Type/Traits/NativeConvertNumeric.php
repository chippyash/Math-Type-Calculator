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

/**
 * Native calculator/comparator int/float conversion
 */
trait NativeConvertNumeric
{
    /**
     * Convert float or int into relevant strong type
     *
     * @param numeric $num
     * @return \chippyash\Type\Number\FloatType|\chippyash\Type\Number\IntType
     */
    public function convertNumeric($num)
    {
        if (is_float($num)) {
            return new FloatType($num);
        }
        //default
        return new IntType($num);
    }
}
