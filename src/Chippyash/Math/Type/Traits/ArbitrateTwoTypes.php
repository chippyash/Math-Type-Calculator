<?php
/**
 * Arithmetic calculation support for Chippyash Strong Types
 *
 * @author Ashley Kitson <akitson@zf4.biz>
 * @copyright Ashley Kitson, UK, 2014
 * @licence GPL V3 or later : http://www.gnu.org/licenses/gpl.html
 */
namespace Chippyash\Math\Type\Traits;

use Chippyash\Type\Interfaces\NumericTypeInterface;

/**
 * Arbitrate the types of two operand types and return a string
 * indication of the return type
 */
trait ArbitrateTwoTypes
{
    /**
     * Arbitrate the return type from the operation
     *
     * @param NumericTypeInterface $a first type
     * @param NumericTypeInterface $b second type
     * 
     * @return string
     * 
     * @noinspection PhpInconsistentReturnPointsInspection
     */
    protected function arbitrate(NumericTypeInterface $a, NumericTypeInterface $b)
    {
        $pairing = $this->getTypePairing($a, $b);
        if ($pairing == 'complex:complex') {
            return 'complex';
        }
        if (strpos($pairing, 'complex') === 0) {
            return 'complex:numeric';
        }
        if (strpos($pairing, 'complex') !== false) {
            return 'numeric:complex';
        }
        if (strstr($pairing, 'rational') !== false) {
            return 'rational';
        }
        if (strstr($pairing, 'float') !== false) {
            return 'float';
        }
        if (strstr($pairing, 'wholeint') !== false) {
            return 'whole';
        }
        if (strstr($pairing, 'naturalint') !== false) {
            return 'natural';
        }
        if ($pairing == 'int:int') {
            return 'int';
        }
    }

    private function getTypePairing(NumericTypeInterface $a, NumericTypeInterface $b)
    {
        $search = ['Chippyash\Type\Number\Rational\\','Chippyash\Type\Number\Complex\\','Chippyash\Type\Number\\', 'Type'];
        $replace = ['','','',''];
        $tA = strtolower(str_replace($search, $replace, get_class($a)));
        $tB =  strtolower(str_replace($search, $replace, get_class($b)));

        return "{$tA}:{$tB}";
    }
}
