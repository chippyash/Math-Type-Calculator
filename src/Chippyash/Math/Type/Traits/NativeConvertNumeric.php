<?php
/**
 * Arithmetic calculation support for Chippyash Strong Types
 *
 * @author    Ashley Kitson <akitson@zf4.biz>
 * @copyright Copyright (c) 2014, Ashley Kitson, UK
 * @licence   GPL V3 or later : http://www.gnu.org/licenses/gpl.html
 */
namespace Chippyash\Math\Type\Traits;

use Chippyash\Type\Number\FloatType;
use Chippyash\Type\Number\IntType;

/**
 * Native calculator/comparator int/float conversion
 */
trait NativeConvertNumeric
{
    /**
     * Convert float or int into relevant strong type
     *
     * @param  int|float $num
     * @return \Chippyash\Type\Number\FloatType|\Chippyash\Type\Number\IntType
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
