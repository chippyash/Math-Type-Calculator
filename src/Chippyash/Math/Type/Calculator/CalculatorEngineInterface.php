<?php
/*
 * Arithmetic calculation support for Chippyash Strong Types
 *
 * @author Ashley Kitson <akitson@zf4.biz>
 * @copyright Ashley Kitson, UK, 2014
 * @licence GPL V3 or later : http://www.gnu.org/licenses/gpl.html
 */
namespace Chippyash\Math\Type\Calculator;

use Chippyash\Type\Interfaces\NumericTypeInterface as NI;
use Chippyash\Type\Number\Complex\ComplexType;
use Chippyash\Type\Number\Rational\RationalType;
use Chippyash\Type\Number\IntType;
use Chippyash\Type\Number\FloatType;

/**
 * Defines an interface that type calculator engines must conform to
 */
interface CalculatorEngineInterface
{
    /**
     * Integer addition
     *
     * @param Chippyash\Type\Interfaces\NumericTypeInterface $a
     * @param Chippyash\Type\Interfaces\NumericTypeInterface $b
     * @return \Chippyash\Type\Number\IntType
     */
    public function intAdd(NI $a, NI $b);

    /**
     * Integer subtraction
     *
     * @param Chippyash\Type\Interfaces\NumericTypeInterface $a
     * @param Chippyash\Type\Interfaces\NumericTypeInterface $b
     * @return \Chippyash\Type\Number\IntType
     */
    public function intSub(NI $a, NI $b);

    /**
     * Integer multiplication
     *
     * @param Chippyash\Type\Interfaces\NumericTypeInterface $a
     * @param Chippyash\Type\Interfaces\NumericTypeInterface $b
     * @return \Chippyash\Type\Number\IntType
     */
    public function intMul(NI $a, NI $b);

    /**
     * Integer division
     * 
     * @param Chippyash\Type\Interfaces\NumericTypeInterface $a
     * @param Chippyash\Type\Interfaces\NumericTypeInterface $b
     * @return \Chippyash\Type\Number\Rational\RationalType
     */
    public function intDiv(NI $a, NI $b);
    
    /**
     * Integer Pow - raise number to the exponent
     * 
     * @param \Chippyash\Type\Number\IntType $a
     * @param Chippyash\Type\Interfaces\NumericTypeInterface $exp Exponent
     * @return Chippyash\Type\Interfaces\NumericTypeInterface
     */
    public function intPow(IntType $a, NI $exp);
    
    /**
     * Integer sqrt
     * Return IntType for perfect squares, else RationalType
     * 
     * @param \Chippyash\Type\Number\IntType $a
     * @return \Chippyash\Type\Number\IntType|\Chippyash\Type\Number\Rational\RationalType result
     */
    public function intSqrt(IntType $a);
    
    /**
     * Float addition
     *
     * @param Chippyash\Type\Interfaces\NumericTypeInterface $a
     * @param Chippyash\Type\Interfaces\NumericTypeInterface $b
     * @return \Chippyash\Type\Number\FloatType
     */
    public function floatAdd(NI $a, NI $b);

    /**
     * Float subtraction
     *
     * @param Chippyash\Type\Interfaces\NumericTypeInterface $a
     * @param Chippyash\Type\Interfaces\NumericTypeInterface $b
     * @return \Chippyash\Type\Number\FloatType
     */
    public function floatSub(NI $a, NI $b);

    /**
     * Float multiplication
     *
     * @param Chippyash\Type\Interfaces\NumericTypeInterface $a
     * @param Chippyash\Type\Interfaces\NumericTypeInterface $b
     * @return \Chippyash\Type\Number\FloatType
     */
    public function floatMul(NI $a, NI $b);

    /**
     * Float division
     *
     * @param Chippyash\Type\Interfaces\NumericTypeInterface $a
     * @param Chippyash\Type\Interfaces\NumericTypeInterface $b
     * @return \Chippyash\Type\Number\FloatType
     */
    public function floatDiv(NI $a, NI $b);

    /**
     * Float reciprocal i.e. 1/a
     * @param Chippyash\Type\Interfaces\NumericTypeInterface $a
     * @return \Chippyash\Type\Number\FloatType
     */
    public function floatReciprocal(NI $a);

    /**
     * Float Pow - raise number to the exponent
     * 
     * @param \Chippyash\Type\Number\FloatType $a
     * @param Chippyash\Type\Interfaces\NumericTypeInterface $exp Exponent
     * @return Chippyash\Type\Interfaces\NumericTypeInterface
     */
    public function floatPow(FloatType $a, NI $exp);
    
    /**
     * Float sqrt
     * 
     * @param \Chippyash\Type\Number\FloatType $a
     * @return \Chippyash\Type\Number\FloatType result
     */
    public function floatSqrt(FloatType $a);
    
    /**
     * Whole number addition
     *
     * @param Chippyash\Type\Interfaces\NumericTypeInterface $a
     * @param Chippyash\Type\Interfaces\NumericTypeInterface $b
     * @return \Chippyash\Type\Number\WholeIntType
     */
    public function wholeAdd(NI $a, NI $b);

    /**
     * Whole number subtraction
     *
     * @param Chippyash\Type\Interfaces\NumericTypeInterface $a
     * @param Chippyash\Type\Interfaces\NumericTypeInterface $b
     * @return \Chippyash\Type\Number\WholeIntType
     */
    public function wholeSub(NI $a, NI $b);

    /**
     * Whole number multiplication
     *
     * @param Chippyash\Type\Interfaces\NumericTypeInterface $a
     * @param Chippyash\Type\Interfaces\NumericTypeInterface $b
     * @return \Chippyash\Type\Number\WholeIntType
     */
    public function wholeMul(NI $a, NI $b);

    /**
     * Natural number addition
     *
     * @param Chippyash\Type\Interfaces\NumericTypeInterface $a
     * @param Chippyash\Type\Interfaces\NumericTypeInterface $b
     * @return \Chippyash\Type\Number\NaturalIntType
     */
    public function naturalAdd(NI $a, NI $b);

    /**
     * Natural number subtraction
     *
     * @param Chippyash\Type\Interfaces\NumericTypeInterface $a
     * @param Chippyash\Type\Interfaces\NumericTypeInterface $b
     * @return \Chippyash\Type\Number\NaturalIntType
     */
    public function naturalSub(NI $a, NI $b);

    /**
     * Natural number multiplication
     *
     * @param Chippyash\Type\Interfaces\NumericTypeInterface $a
     * @param Chippyash\Type\Interfaces\NumericTypeInterface $b
     * @return \Chippyash\Type\Number\NaturalIntType
     */
    public function naturalMul(NI $a, NI $b);

    /**
     * Rational number addition
     *
     * @param Chippyash\Type\Interfaces\NumericTypeInterface $a
     * @param Chippyash\Type\Interfaces\NumericTypeInterface $b
     * @return \Chippyash\Type\Number\Rational\RationalType
     */
    public function rationalAdd(NI $a, NI $b);

    /**
     * Rational number subtraction
     *
     * @param Chippyash\Type\Interfaces\NumericTypeInterface $a
     * @param Chippyash\Type\Interfaces\NumericTypeInterface $b
     * @return \Chippyash\Type\Number\Rational\RationalType
     */
    public function rationalSub(NI $a, NI $b);

    /**
     * Rational number multiplication
     *
     * @param Chippyash\Type\Interfaces\NumericTypeInterface $a
     * @param Chippyash\Type\Interfaces\NumericTypeInterface $b
     * @return \Chippyash\Type\Number\Rational\RationalType
     */
    public function rationalMul(NI $a, NI $b);

    /**
     * Rational number division
     *
     * @param Chippyash\Type\Interfaces\NumericTypeInterface $a
     * @param Chippyash\Type\Interfaces\NumericTypeInterface $b
     * @return \Chippyash\Type\Number\Rational\RationalType
     */
    public function rationalDiv(NI $a, NI $b);

    /**
     * Rational number reciprocal: 1/r
     *
     * @param \Chippyash\Type\Number\Rational\RationalType $a
     * @return \Chippyash\Type\Number\Rational\RationalType
     */
    public function rationalReciprocal(RationalType $a);

    /**
     * Rational Pow - raise number to the exponent
     * 
     * @param \Chippyash\Type\Number\Rational\RationalType $a
     * @param Chippyash\Type\Interfaces\NumericTypeInterface $exp Exponent
     * @return Chippyash\Type\Interfaces\NumericTypeInterface
     */
    public function rationalPow(RationalType $a, NI $exp);
    
    /**
     * Rational sqrt
     * 
     * @param \Chippyash\Type\Number\Rational\RationalType $a
     * @return \Chippyash\Type\Number\Rational\RationalType result
     */
    public function rationalSqrt(RationalType $a);
    

    /**
     * Complex number addition
     *
     * @param \Chippyash\Type\Number\Complex\ComplexType $a
     * @param \Chippyash\Type\Number\Complex\ComplexType $b
     * @return \Chippyash\Type\Number\Complex\ComplexType
     */
    public function complexAdd(ComplexType $a, ComplexType $b);

    /**
     * Complex number subtraction
     *
     * @param \Chippyash\Type\Number\Complex\ComplexType $a
     * @param \Chippyash\Type\Number\Complex\ComplexType $b
     * @return \Chippyash\Type\Number\Complex\ComplexType
     */
    public function complexSub(ComplexType $a, ComplexType $b);

    /**
     * Complex number multiplication
     *
     * @param \Chippyash\Type\Number\Complex\ComplexType $a
     * @param \Chippyash\Type\Number\Complex\ComplexType $b
     * @return \Chippyash\Type\Number\Complex\ComplexType
     */
    public function complexMul(ComplexType $a, ComplexType $b);

    /**
     * Complex number division
     *
     * @param \Chippyash\Type\Number\Complex\ComplexType $a
     * @param \Chippyash\Type\Number\Complex\ComplexType $b
     * @return \Chippyash\Type\Number\Complex\ComplexType
     * @throws \BadMethodCallException
     */
    public function complexDiv(ComplexType $a, ComplexType $b);

    /**
     * Complex number reciprocal: 1/a+bi
     *
     * @param \Chippyash\Type\Number\Complex\ComplexType $a
     * @return \Chippyash\Type\Number\Complex\ComplexType
     * @throws \BadMethodCallException
     */
    public function complexReciprocal(ComplexType $a);

    /**
     * Complex Pow - raise number to the exponent
     * 
     * @param \Chippyash\Type\Number\Complex\ComplexType $a
     * @param Chippyash\Type\Interfaces\NumericTypeInterface $exp Exponent
     * @return \Chippyash\Type\Number\Complex\ComplexType
     */
    public function complexPow(ComplexType $a, NI $exp);

    /**
     * Complex sqrt
     * 
     * @param \Chippyash\Type\Number\Complex\ComplexType $a
     * @return \Chippyash\Type\Number\Complex\ComplexType result
     */
    public function complexSqrt(ComplexType $a);
    
    /**
     * Convert float or int into relevant strong type
     *
     * @param numeric $num
     * @return \Chippyash\Type\Number\FloatType|\Chippyash\Type\Number\IntType
     */
    public function convertNumeric($num);
}
