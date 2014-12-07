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
use chippyash\Type\Interfaces\GMPInterface;
use chippyash\Type\Number\Rational\GMPComplexType;
use chippyash\Type\Number\Complex\ComplexTypeFactory;

/**
 * Check for GMP complex type, converting if necessary
 */
trait CheckGmpComplexTypes
{

    /**
     * Check for complex type, converting if necessary
     *
     * @param chippyash\Type\Interfaces\NumericTypeInterface $a
     * @param chippyash\Type\Interfaces\NumericTypeInterface $b
     * @return array [GMPComplexType, GMPComplexType]
     */
    protected function checkGmpComplexTypes(NumericTypeInterface $a, NumericTypeInterface $b)
    {
        return [$this->checkGmpComplexType($a), $this->checkGmpComplexType($b)];
    }

    /**
     * Check and convert to GmpComplexType if required
     * @param NumericTypeInterface $a
     * @return GMPComplexType
     */
    protected function checkGmpComplexType(NumericTypeInterface $a)
    {
        if (!$a instanceof GMPComplexType) {
            if (!$a instanceof GMPInterface) {
                return $a->asGMPComplex();
            }
            //convert non GMP number
            $cplx = $a->asComplex();
            return ComplexTypeFactory::create($cplx->r(), $cplx->i());
        } 
        
        return $a;
    }    
}
