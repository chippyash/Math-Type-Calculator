<?php
/*
 * Arithmetic calculation support for chippyash Strong Types
 *
 * @author Ashley Kitson <akitson@zf4.biz>
 * @copyright Ashley Kitson, UK, 2014
 * @licence GPL V3 or later : http://www.gnu.org/licenses/gpl.html
 */
namespace chippyash\Math\Type\Calculator;

use chippyash\Type\Interfaces\NumericTypeInterface as NI;

/**
 * Defines an interface that type calculator engines must conform to
 */
interface CalculatorEngineInterface
{
    /**
     * Integer addition
     *
     * @param chippyash\Type\Interfaces\NumericTypeInterface $a
     * @param chippyash\Type\Interfaces\NumericTypeInterface $b
     * @return \chippyash\Type\Number\IntType
     */
    public function intAdd(NI $a, NI $b);

    /**
     * Integer subtraction
     *
     * @param chippyash\Type\Interfaces\NumericTypeInterface $a
     * @param chippyash\Type\Interfaces\NumericTypeInterface $b
     * @return \chippyash\Type\Number\IntType
     */
    public function intSub(NI $a, NI $b);

    /**
     * Integer multiplication
     *
     * @param chippyash\Type\Interfaces\NumericTypeInterface $a
     * @param chippyash\Type\Interfaces\NumericTypeInterface $b
     * @return \chippyash\Type\Number\IntType
     */
    public function intMul(NI $a, NI $b);

    /**
     * Integer division
     * 
     * @param chippyash\Type\Interfaces\NumericTypeInterface $a
     * @param chippyash\Type\Interfaces\NumericTypeInterface $b
     * @return \chippyash\Type\Number\Rational\RationalType
     */
    public function intDiv(NI $a, NI $b);
    
    /**
     * Integer Pow - raise number to the exponent
     * 
     * @param chippyash\Type\Interfaces\NumericTypeInterface $a
     * @param chippyash\Type\Interfaces\NumericTypeInterface $exp Exponent
     * @return chippyash\Type\Interfaces\NumericTypeInterface
     */
    public function intPow(NI $a, NI $exp);
    
    /**
     * Integer sqrt
     * Return IntType for perfect squares, else RationalType
     * 
     * @param \chippyash\Type\Interfaces\NumericTypeInterface $a
     * @return \chippyash\Type\Number\IntType|\chippyash\Type\Number\Rational\RationalType result
     */
    public function intSqrt(NI $a);
    
    /**
     * Float addition
     *
     * @param chippyash\Type\Interfaces\NumericTypeInterface $a
     * @param chippyash\Type\Interfaces\NumericTypeInterface $b
     * @return \chippyash\Type\Number\FloatType
     */
    public function floatAdd(NI $a, NI $b);

    /**
     * Float subtraction
     *
     * @param chippyash\Type\Interfaces\NumericTypeInterface $a
     * @param chippyash\Type\Interfaces\NumericTypeInterface $b
     * @return \chippyash\Type\Number\FloatType
     */
    public function floatSub(NI $a, NI $b);

    /**
     * Float multiplication
     *
     * @param chippyash\Type\Interfaces\NumericTypeInterface $a
     * @param chippyash\Type\Interfaces\NumericTypeInterface $b
     * @return \chippyash\Type\Number\FloatType
     */
    public function floatMul(NI $a, NI $b);

    /**
     * Float division
     *
     * @param chippyash\Type\Interfaces\NumericTypeInterface $a
     * @param chippyash\Type\Interfaces\NumericTypeInterface $b
     * @return \chippyash\Type\Number\FloatType
     */
    public function floatDiv(NI $a, NI $b);

    /**
     * Float reciprocal i.e. 1/a
     * @param chippyash\Type\Interfaces\NumericTypeInterface $a
     * @return \chippyash\Type\Number\FloatType
     */
    public function floatReciprocal(NI $a);

    /**
     * Float Pow - raise number to the exponent
     * 
     * @param chippyash\Type\Interfaces\NumericTypeInterface $a
     * @param chippyash\Type\Interfaces\NumericTypeInterface $exp Exponent
     * @return chippyash\Type\Interfaces\NumericTypeInterface
     */
    public function floatPow(NI $a, NI $exp);
    
    /**
     * Float sqrt
     * 
     * @param chippyash\Type\Interfaces\NumericTypeInterface $a
     * @return \chippyash\Type\Number\FloatType result
     */
    public function floatSqrt(NI $a);
    
    /**
     * Whole number addition
     *
     * @param chippyash\Type\Interfaces\NumericTypeInterface $a
     * @param chippyash\Type\Interfaces\NumericTypeInterface $b
     * @return \chippyash\Type\Number\WholeIntType
     */
    public function wholeAdd(NI $a, NI $b);

    /**
     * Whole number subtraction
     *
     * @param chippyash\Type\Interfaces\NumericTypeInterface $a
     * @param chippyash\Type\Interfaces\NumericTypeInterface $b
     * @return \chippyash\Type\Number\WholeIntType
     */
    public function wholeSub(NI $a, NI $b);

    /**
     * Whole number multiplication
     *
     * @param chippyash\Type\Interfaces\NumericTypeInterface $a
     * @param chippyash\Type\Interfaces\NumericTypeInterface $b
     * @return \chippyash\Type\Number\WholeIntType
     */
    public function wholeMul(NI $a, NI $b);

    /**
     * Natural number addition
     *
     * @param chippyash\Type\Interfaces\NumericTypeInterface $a
     * @param chippyash\Type\Interfaces\NumericTypeInterface $b
     * @return \chippyash\Type\Number\NaturalIntType
     */
    public function naturalAdd(NI $a, NI $b);

    /**
     * Natural number subtraction
     *
     * @param chippyash\Type\Interfaces\NumericTypeInterface $a
     * @param chippyash\Type\Interfaces\NumericTypeInterface $b
     * @return \chippyash\Type\Number\NaturalIntType
     */
    public function naturalSub(NI $a, NI $b);

    /**
     * Natural number multiplication
     *
     * @param chippyash\Type\Interfaces\NumericTypeInterface $a
     * @param chippyash\Type\Interfaces\NumericTypeInterface $b
     * @return \chippyash\Type\Number\NaturalIntType
     */
    public function naturalMul(NI $a, NI $b);

    /**
     * Rational number addition
     *
     * @param chippyash\Type\Interfaces\NumericTypeInterface $a
     * @param chippyash\Type\Interfaces\NumericTypeInterface $b
     * @return \chippyash\Type\Number\Rational\RationalType
     */
    public function rationalAdd(NI $a, NI $b);

    /**
     * Rational number subtraction
     *
     * @param chippyash\Type\Interfaces\NumericTypeInterface $a
     * @param chippyash\Type\Interfaces\NumericTypeInterface $b
     * @return \chippyash\Type\Number\Rational\RationalType
     */
    public function rationalSub(NI $a, NI $b);

    /**
     * Rational number multiplication
     *
     * @param chippyash\Type\Interfaces\NumericTypeInterface $a
     * @param chippyash\Type\Interfaces\NumericTypeInterface $b
     * @return \chippyash\Type\Number\Rational\RationalType
     */
    public function rationalMul(NI $a, NI $b);

    /**
     * Rational number division
     *
     * @param chippyash\Type\Interfaces\NumericTypeInterface $a
     * @param chippyash\Type\Interfaces\NumericTypeInterface $b
     * @return \chippyash\Type\Number\Rational\RationalType
     */
    public function rationalDiv(NI $a, NI $b);

    /**
     * Rational number reciprocal: 1/r
     *
     * @param \chippyash\Type\Interfaces\NumericTypeInterface $a
     * @return \chippyash\Type\Number\Rational\RationalType
     */
    public function rationalReciprocal(NI $a);

    /**
     * Rational Pow - raise number to the exponent
     * 
     * @param \chippyash\Type\Interfaces\NumericTypeInterface $a
     * @param \chippyash\Type\Interfaces\NumericTypeInterface $exp Exponent
     * @return \chippyash\Type\Interfaces\NumericTypeInterface
     */
    public function rationalPow(NI $a, NI $exp);
    
    /**
     * Rational sqrt
     * 
     * @param \chippyash\Type\Interfaces\NumericTypeInterface $a
     * @return \chippyash\Type\Number\Rational\RationalType result
     */
    public function rationalSqrt(NI $a);
    

    /**
     * Complex number addition
     *
     * @param \chippyash\Type\Interfaces\NumericTypeInterface $a
     * @param \chippyash\Type\Interfaces\NumericTypeInterface $b
     * @return \chippyash\Type\Number\Complex\ComplexType
     */
    public function complexAdd(NI $a, NI $b);

    /**
     * Complex number subtraction
     *
     * @param \chippyash\Type\Interfaces\NumericTypeInterface $a
     * @param \chippyash\Type\Interfaces\NumericTypeInterface $b
     * @return \chippyash\Type\Number\Complex\ComplexType
     */
    public function complexSub(NI $a, NI $b);

    /**
     * Complex number multiplication
     *
     * @param \chippyash\Type\Interfaces\NumericTypeInterface $a
     * @param \chippyash\Type\Interfaces\NumericTypeInterface $b
     * @return \chippyash\Type\Number\Complex\ComplexType
     */
    public function complexMul(NI $a, NI $b);

    /**
     * Complex number division
     *
     * @param \chippyash\Type\Interfaces\NumericTypeInterface $a
     * @param \chippyash\Type\Interfaces\NumericTypeInterface $b
     * @return \chippyash\Type\Number\Complex\ComplexType
     * @throws \BadMethodCallException
     */
    public function complexDiv(NI $a, NI $b);

    /**
     * Complex number reciprocal: 1/a+bi
     *
     * @param \chippyash\Type\Interfaces\NumericTypeInterface $a
     * @return \chippyash\Type\Number\Complex\ComplexType
     * @throws \BadMethodCallException
     */
    public function complexReciprocal(NI $a);

    /**
     * Complex Pow - raise number to the exponent
     * 
     * @param \chippyash\Type\Interfaces\NumericTypeInterface $a
     * @param chippyash\Type\Interfaces\NumericTypeInterface $exp Exponent
     * @return \chippyash\Type\Number\Complex\ComplexType
     */
    public function complexPow(NI $a, NI $exp);

    /**
     * Complex sqrt
     * 
     * @param chippyash\Type\Interfaces\NumericTypeInterface $a
     * @return \chippyash\Type\Number\Complex\ComplexType result
     */
    public function complexSqrt(NI $a);
    
    /**
     * Convert float or int into relevant strong type
     *
     * @param numeric $num
     * @return \chippyash\Type\Number\FloatType|\chippyash\Type\Number\IntType
     */
    public function convertNumeric($num);
    
    /**
     * Increment the number by the increment
     * By default the increment == 1
     * This operation will effect the $a parameter
     * 
     * @param \chippyash\Type\Interfaces\NumericTypeInterface $a
     * @param \chippyash\Type\Interfaces\NumericTypeInterface $inc
     * 
     * @return void
     */
    public function inc(NI &$a, NI $inc = null);

    /**
     * Decrement the number by the decrement
     * By default the decrement == 1
     * This operation will effect the $a parameter
     * 
     * @param \chippyash\Type\Interfaces\NumericTypeInterface $a
     * @param \chippyash\Type\Interfaces\NumericTypeInterface $dec
     * 
     * @return void
     */
    public function dec(NI &$a, NI $dec = null);
    
    /**
     * Return the natural (base e) logarithm for a number
     * 
     * @param \chippyash\Type\Interfaces\NumericTypeInterface $a
     * 
     * @return \chippyash\Type\Numeric\Rational\AbstractRationalType
     */
    public function natLog(NI $a);

}
