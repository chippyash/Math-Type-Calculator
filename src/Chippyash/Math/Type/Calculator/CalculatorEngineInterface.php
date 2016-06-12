<?php
/**
 * Arithmetic calculation support for Chippyash Strong Types
 *
 * @author    Ashley Kitson <akitson@zf4.biz>
 * @copyright Copyright (c) 2014, Ashley Kitson, UK
 * @licence   GPL V3 or later : http://www.gnu.org/licenses/gpl.html
 */
namespace Chippyash\Math\Type\Calculator;

use Chippyash\Type\Interfaces\NumericTypeInterface as NI;
use Chippyash\Type\Number\Complex\ComplexType;
use Chippyash\Type\Number\Rational\RationalType;
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
     * @param NI $a first operand
     * @param NI $b second operand
     * 
     * @return IntType
     */
    public function intAdd(NI $a, NI $b);

    /**
     * Integer subtraction
     *
     * @param NI $a first operand
     * @param NI $b second operand
     *
     * @return IntType
     */
    public function intSub(NI $a, NI $b);

    /**
     * Integer multiplication
     *
     * @param NI $a first operand
     * @param NI $b second operand
     *
     * @return IntType
     */
    public function intMul(NI $a, NI $b);

    /**
     * Integer division
     *
     * @param NI $a first operand
     * @param NI $b second operand
     *
     * @return RationalType
     */
    public function intDiv(NI $a, NI $b);
    
    /**
     * Integer Pow - raise number to the exponent
     * 
     * @param IntType $a operand
     * @param NI $exp exponent
     * 
     * @return NI
     */
    public function intPow(IntType $a, NI $exp);
    
    /**
     * Integer sqrt
     * Return IntType for perfect squares, else RationalType
     * 
     * @param IntType $a operand
     * 
     * @return IntType|RationalType result
     */
    public function intSqrt(IntType $a);
    
    /**
     * Float addition
     *
     * @param NI $a first operand
     * @param NI $b second operand
     * 
     * @return FloatType
     */
    public function floatAdd(NI $a, NI $b);

    /**
     * Float subtraction
     *
     * @param NI $a first operand
     * @param NI $b second operand
     *
     * @return FloatType
     */
    public function floatSub(NI $a, NI $b);

    /**
     * Float multiplication
     *
     * @param NI $a first operand
     * @param NI $b second operand
     *
     * @return FloatType
     */
    public function floatMul(NI $a, NI $b);

    /**
     * Float division
     *
     * @param NI $a first operand
     * @param NI $b second operand
     *
     * @return FloatType
     */
    public function floatDiv(NI $a, NI $b);

    /**
     * Float reciprocal i.e. 1/a
     * 
     * @param NI $a operand
     * 
     * @return FloatType
     */
    public function floatReciprocal(NI $a);

    /**
     * Float Pow - raise number to the exponent
     * 
     * @param FloatType $a operand
     * @param NI        $exp exponent
     * 
     * @return NI
     */
    public function floatPow(FloatType $a, NI $exp);
    
    /**
     * Float sqrt
     * 
     * @param FloatType $a operand
     * 
     * @return FloatType result
     */
    public function floatSqrt(FloatType $a);
    
    /**
     * Whole number addition
     *
     * @param NI $a first operand
     * @param NI $b second operand
     * 
     * @return WholeIntType
     */
    public function wholeAdd(NI $a, NI $b);

    /**
     * Whole number subtraction
     *
     * @param NI $a first operand
     * @param NI $b second operand
     *
     * @return WholeIntType
     */
    public function wholeSub(NI $a, NI $b);

    /**
     * Whole number multiplication
     *
     * @param NI $a first operand
     * @param NI $b second operand
     *
     * @return WholeIntType
     */
    public function wholeMul(NI $a, NI $b);

    /**
     * Natural number addition
     *
     * @param NI $a first operand
     * @param NI $b second operand
     *
     * @return NaturalIntType
     */
    public function naturalAdd(NI $a, NI $b);

    /**
     * Natural number subtraction
     *
     * @param NI $a first operand
     * @param NI $b second operand
     *
     * @return NaturalIntType
     */
    public function naturalSub(NI $a, NI $b);

    /**
     * Natural number multiplication
     *
     * @param NI $a first operand
     * @param NI $b second operand
     *
     * @return NaturalIntType
     */
    public function naturalMul(NI $a, NI $b);

    /**
     * Rational number addition
     *
     * @param NI $a first operand
     * @param NI $b second operand
     * 
     * @return RationalType
     */
    public function rationalAdd(NI $a, NI $b);

    /**
     * Rational number subtraction
     *
     * @param NI $a first operand
     * @param NI $b second operand
     * 
     * @return RationalType
     */
    public function rationalSub(NI $a, NI $b);

    /**
     * Rational number multiplication
     *
     * @param NI $a first operand
     * @param NI $b second operand
     * 
     * @return RationalType
     */
    public function rationalMul(NI $a, NI $b);

    /**
     * Rational number division
     *
     * @param NI $a first operand
     * @param NI $b second operand
     * 
     * @return RationalType
     */
    public function rationalDiv(NI $a, NI $b);

    /**
     * Rational number reciprocal: 1/r
     *
     * @param RationalType $a operand
     * 
     * @return RationalType
     */
    public function rationalReciprocal(RationalType $a);

    /**
     * Rational Pow - raise number to the exponent
     * 
     * @param RationalType $a operand
     * @param NI           $exp Exponent
     * 
     * @return NI
     */
    public function rationalPow(RationalType $a, NI $exp);
    
    /**
     * Rational sqrt
     * 
     * @param RationalType $a operand
     * 
     * @return RationalType result
     */
    public function rationalSqrt(RationalType $a);
    

    /**
     * Complex number addition
     *
     * @param ComplexType $a first operand
     * @param ComplexType $b second operand
     * 
     * @return ComplexType
     */
    public function complexAdd(ComplexType $a, ComplexType $b);

    /**
     * Complex number subtraction
     *
     * @param ComplexType $a first operand
     * @param ComplexType $b second operand
     * 
     * @return ComplexType
     */
    public function complexSub(ComplexType $a, ComplexType $b);

    /**
     * Complex number multiplication
     *
     * @param ComplexType $a first operand
     * @param ComplexType $b second operand
     * 
     * @return ComplexType
     */
    public function complexMul(ComplexType $a, ComplexType $b);

    /**
     * Complex number division
     *
     * @param ComplexType $a first operand
     * @param ComplexType $b second operand
     * 
     * @return ComplexType
     * 
     * @throws \BadMethodCallException
     */
    public function complexDiv(ComplexType $a, ComplexType $b);

    /**
     * Complex number reciprocal: 1/a+bi
     *
     * @param  ComplexType $a operand
     * 
     * @return ComplexType
     * 
     * @throws \BadMethodCallException
     */
    public function complexReciprocal(ComplexType $a);

    /**
     * Complex Pow - raise number to the exponent
     * 
     * @param ComplexType $a operand
     * @param NI          $exp exponent
     * 
     * @return ComplexType
     */
    public function complexPow(ComplexType $a, NI $exp);

    /**
     * Complex sqrt
     * 
     * @param ComplexType $a operand
     * 
     * @return ComplexType result
     */
    public function complexSqrt(ComplexType $a);
    
    /**
     * Convert float or int into relevant strong type
     *
     * @param float|int $num operand
     * 
     * @return IntType
     */
    public function convertNumeric($num);
}
