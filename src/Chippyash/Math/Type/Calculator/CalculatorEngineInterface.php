<?php
/*
 * Arithmetic calculation support for Chippyash Strong Types
 *
 * @author Ashley Kitson <akitson@zf4.biz>
 * @copyright Ashley Kitson, UK, 2014
 * @licence GPL V3 or later : http://www.gnu.org/licenses/gpl.html
 */
namespace Chippyash\Math\Type\Calculator;

use Chippyash\Type\Interfaces\NumericTypeInterface as NTI;
use Chippyash\Type\Interfaces\RationalTypeInterface as RTI;
use Chippyash\Type\Interfaces\ComplexTypeInterface as CTI;
use Chippyash\Type\Number\IntType;
use Chippyash\Type\Number\FloatType;
use Chippyash\Type\Number\WholeIntType;
use Chippyash\Type\Number\NaturalIntType;

/**
 * Defines an interface that type calculator engines must conform to
 */
interface CalculatorEngineInterface
{
    /**
     * Integer addition
     *
     * @param NTI $a
     * @param NTI $b
     * @return IntType
     */
    public function intAdd(NTI $a, NTI $b);

    /**
     * Integer subtraction
     *
     * @param NTI $a
     * @param NTI $b
     * @return IntType
     */
    public function intSub(NTI $a, NTI $b);

    /**
     * Integer multiplication
     *
     * @param NTI $a
     * @param NTI $b
     * @return IntType
     */
    public function intMul(NTI $a, NTI $b);

    /**
     * Integer division
     * 
     * @param NTI $a
     * @param NTI $b
     * @return RTI
     */
    public function intDiv(NTI $a, NTI $b);
    
    /**
     * Integer Pow - raise number to the exponent
     * 
     * @param IntType $a
     * @param NTI $exp Exponent
     * @return NTI
     */
    public function intPow(IntType $a, NTI $exp);
    
    /**
     * Integer sqrt
     * Return IntType for perfect squares, else RationalType
     * 
     * @param IntType $a
     * @return NTI result
     */
    public function intSqrt(IntType $a);
    
    /**
     * Float addition
     *
     * @param NTI $a
     * @param NTI $b
     * @return FloatType
     */
    public function floatAdd(NTI $a, NTI $b);

    /**
     * Float subtraction
     *
     * @param NTI $a
     * @param NTI $b
     * @return FloatType
     */
    public function floatSub(NTI $a, NTI $b);

    /**
     * Float multiplication
     *
     * @param NTI $a
     * @param NTI $b
     * @return FloatType
     */
    public function floatMul(NTI $a, NTI $b);

    /**
     * Float division
     *
     * @param NTI $a
     * @param NTI $b
     * @return FloatType
     */
    public function floatDiv(NTI $a, NTI $b);

    /**
     * Float reciprocal i.e. 1/a
     * @param NTI $a
     * @return FloatType
     */
    public function floatReciprocal(NTI $a);

    /**
     * Float Pow - raise number to the exponent
     * 
     * @param FloatType $a
     * @param NTI $exp Exponent
     * @return FloatType
     */
    public function floatPow(FloatType $a, NTI $exp);
    
    /**
     * Float sqrt
     * 
     * @param FloatType $a
     * @return FloatType result
     */
    public function floatSqrt(FloatType $a);
    
    /**
     * Whole number addition
     *
     * @param NTI $a
     * @param NTI $b
     * @return WholeIntType
     */
    public function wholeAdd(NTI $a, NTI $b);

    /**
     * Whole number subtraction
     *
     * @param NTI $a
     * @param NTI $b
     * @return WholeIntType
     */
    public function wholeSub(NTI $a, NTI $b);

    /**
     * Whole number multiplication
     *
     * @param NTI $a
     * @param NTI $b
     * @return WholeIntType
     */
    public function wholeMul(NTI $a, NTI $b);

    /**
     * Natural number addition
     *
     * @param NTI $a
     * @param NTI $b
     * @return NaturalIntType
     */
    public function naturalAdd(NTI $a, NTI $b);

    /**
     * Natural number subtraction
     *
     * @param NTI $a
     * @param NTI $b
     * @return NaturalIntType
     */
    public function naturalSub(NTI $a, NTI $b);

    /**
     * Natural number multiplication
     *
     * @param NTI $a
     * @param NTI $b
     * @return NaturalIntType
     */
    public function naturalMul(NTI $a, NTI $b);

    /**
     * Rational number addition
     *
     * @param RTI $a
     * @param RTI $b
     * @return RTI
     */
    public function rationalAdd(RTI $a, RTI $b);

    /**
     * Rational number subtraction
     *
     * @param RTI $a
     * @param RTI $b
     * @return RTI
     */
    public function rationalSub(RTI $a, RTI $b);

    /**
     * Rational number multiplication
     *
     * @param RTI $a
     * @param RTI $b
     * @return RTI
     */
    public function rationalMul(RTI $a, RTI $b);

    /**
     * Rational number division
     *
     * @param RTI $a
     * @param RTI $b
     * @return RTI
     */
    public function rationalDiv(RTI $a, RTI $b);

    /**
     * Rational number reciprocal: 1/r
     *
     * @param RTI $a
     * @return RTI
     */
    public function rationalReciprocal(RTI $a);

    /**
     * Rational Pow - raise number to the exponent
     * 
     * @param RTI $a
     * @param NTI $exp Exponent
     * @return RTI
     */
    public function rationalPow(RTI $a, NTI $exp);
    
    /**
     * Rational sqrt
     * 
     * @param RTI $a
     * @return RTI result
     */
    public function rationalSqrt(RTI $a);
    

    /**
     * Complex number addition
     *
     * @param CTI $a
     * @param CTI $b
     * @return CTI
     */
    public function complexAdd(CTI $a, CTI $b);

    /**
     * Complex number subtraction
     *
     * @param CTI $a
     * @param CTI $b
     * @return CTI
     */
    public function complexSub(CTI $a, CTI $b);

    /**
     * Complex number multiplication
     *
     * @param CTI $a
     * @param CTI $b
     * @return CTI
     */
    public function complexMul(CTI $a, CTI $b);

    /**
     * Complex number division
     *
     * @param CTI $a
     * @param CTI $b
     * @return CTI
     * @throws \BadMethodCallException
     */
    public function complexDiv(CTI $a, CTI $b);

    /**
     * Complex number reciprocal: 1/a+bi
     *
     * @param CTI $a
     * @return CTI
     * @throws \BadMethodCallException
     */
    public function complexReciprocal(CTI $a);

    /**
     * Complex Pow - raise number to the exponent
     * 
     * @param CTI $a
     * @param NTI $exp Exponent
     * @return CTI
     */
    public function complexPow(CTI $a, NTI $exp);

    /**
     * Complex sqrt
     * 
     * @param CTI $a
     * @return CTI result
     */
    public function complexSqrt(CTI $a);
    
    /**
     * Convert float or int into relevant strong type
     *
     * @param numeric $num
     * @return FloatType|IntType
     */
    public function convertNumeric($num);
}
