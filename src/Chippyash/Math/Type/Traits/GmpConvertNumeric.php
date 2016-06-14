<?php
/**
 * Arithmetic calculation support for chippyash Strong Types
 *
 * @author    Ashley Kitson <akitson@zf4.biz>
 * @copyright Ashley Kitson, UK, 2014
 * @licence   GPL V3 or later : http://www.gnu.org/licenses/gpl.html
 */
namespace Chippyash\Math\Type\Traits;

use Chippyash\Type\Number\GMPIntType;
use Chippyash\Type\Number\Rational\GMPRationalType;
use Chippyash\Type\Number\Rational\RationalTypeFactory;

/**
 * Native calculator/comparator int/float conversion
 */
trait GmpConvertNumeric
{
    /**
     * Convert float or int into relevant strong type
     *
     * @param  int|float $num
     * @return GMPRationalType|GMPIntType
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
