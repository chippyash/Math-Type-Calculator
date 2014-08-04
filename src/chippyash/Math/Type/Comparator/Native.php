<?php
/*
 * Arithmetic calculation support for chippyash Strong Types
 *
 * @author Ashley Kitson <akitson@zf4.biz>
 * @copyright Ashley Kitson, UK, 2014
 * @licence GPL V3 or later : http://www.gnu.org/licenses/gpl.html
 */
namespace chippyash\Math\Type\Comparator;

use chippyash\Math\Type\Comparator\AbstractComparatorEngine;
use chippyash\Math\Type\Traits\NativeConvertNumeric;

/**
 * PHP Native maths comparator
 *
 */
class Native extends AbstractComparatorEngine
{
    use NativeConvertNumeric;

    /**
     * a == b = 0
     * a < b = -1
     * a > b = 1
     *
     * @param \chippyash\Type\Number\NumericTypeInterface $a
     * @param \chippyash\Type\Number\NumericTypeInterface $b
     *
     * @return int
     */
    public function compare(NI $a, NI $b)
    {
        
    }

}
