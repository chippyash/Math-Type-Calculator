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
use chippyash\Type\Number\Complex\ComplexType;
use chippyash\Type\Number\Rational\RationalType;
use chippyash\Type\Number\IntType;
use chippyash\Type\Number\FloatType;

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
     * @param \chippyash\Type\Number\IntType $a
     * @param chippyash\Type\Interfaces\NumericTypeInterface $exp Exponent
     * @return chippyash\Type\Interfaces\NumericTypeInterface
     */
    public function intPow(IntType $a, NI $exp);
    
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
     * @param \chippyash\Type\Number\FloatType $a
     * @param chippyash\Type\Interfaces\NumericTypeInterface $exp Exponent
     * @return chippyash\Type\Interfaces\NumericTypeInterface
     */
    public function floatPow(FloatType $a, NI $exp);
    

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
     * @param \chippyash\Type\Number\Rational\RationalType $a
     * @return \chippyash\Type\Number\Rational\RationalType
     */
    public function rationalReciprocal(RationalType $a);

    /**
     * Rational Pow - raise number to the exponent
     * 
     * @param \chippyash\Type\Number\Rational\RationalType $a
     * @param chippyash\Type\Interfaces\NumericTypeInterface $exp Exponent
     * @return chippyash\Type\Interfaces\NumericTypeInterface
     */
    public function rationalPow(RationalType $a, NI $exp);
    
    /**
     * Complex number addition
     *
     * @param \chippyash\Type\Number\Complex\ComplexType $a
     * @param \chippyash\Type\Number\Complex\ComplexType $b
     * @return \chippyash\Type\Number\Complex\ComplexType
     */
    public function complexAdd(ComplexType $a, ComplexType $b);

    /**
     * Complex number subtraction
     *
     * @param \chippyash\Type\Number\Complex\ComplexType $a
     * @param \chippyash\Type\Number\Complex\ComplexType $b
     * @return \chippyash\Type\Number\Complex\ComplexType
     */
    public function complexSub(ComplexType $a, ComplexType $b);

    /**
     * Complex number multiplication
     *
     * @param \chippyash\Type\Number\Complex\ComplexType $a
     * @param \chippyash\Type\Number\Complex\ComplexType $b
     * @return \chippyash\Type\Number\Complex\ComplexType
     */
    public function complexMul(ComplexType $a, ComplexType $b);

    /**
     * Complex number division
     *
     * @param \chippyash\Type\Number\Complex\ComplexType $a
     * @param \chippyash\Type\Number\Complex\ComplexType $b
     * @return \chippyash\Type\Number\Complex\ComplexType
     * @throws \BadMethodCallException
     */
    public function complexDiv(ComplexType $a, ComplexType $b);

    /**
     * Complex number reciprocal: 1/a+bi
     *
     * @param \chippyash\Type\Number\Complex\ComplexType $a
     * @return \chippyash\Type\Number\Complex\ComplexType
     * @throws \BadMethodCallException
     */
    public function complexReciprocal(ComplexType $a);

    /**
     * Complex Pow - raise number to the exponent
     * 
     * @param \chippyash\Type\Number\Complex\ComplexType $a
     * @param chippyash\Type\Interfaces\NumericTypeInterface $exp Exponent
     * @return \chippyash\Type\Number\Complex\ComplexType
     */
    public function complexPow(ComplexType $a, NI $exp);

    /**
     * Convert float or int into relevant strong type
     *
     * @param numeric $num
     * @return \chippyash\Type\Number\FloatType|\chippyash\Type\Number\IntType
     */
    public function convertNumeric($num);
}
