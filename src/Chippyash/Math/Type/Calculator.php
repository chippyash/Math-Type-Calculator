<?php
/**
 * Arithmetic calculation support for Chippyash Strong Types
 *
 * @author    Ashley Kitson <akitson@zf4.biz>
 * @copyright Copyright (c) 2014, Ashley Kitson, UK
 * @licence   GPL V3 or later : http://www.gnu.org/licenses/gpl.html
 */
namespace Chippyash\Math\Type;

use Chippyash\Type\Interfaces\NumericTypeInterface;
use Chippyash\Math\Type\Calculator\Native;
use Chippyash\Math\Type\Calculator\CalculatorEngineInterface;
use Chippyash\Math\Type\Traits\ArbitrateTwoTypes;

/**
 * Generic calculator for strong type support
 *
 * The result of any calculation is determined by the precedence of the operands
 *
 * Type precedence:
 * - ComplexType: only available between two complex operands
 * - RationalType: will be returned if a lower type is not possible
 * - FloatType (float): will be returned if a lower type is not possible
 * - WholeType, NaturalType (int): where one operand is of the type. NB beware of exceptions
 * - IntType (int): where both operands are IntType (int) and calculation is not division
 *
 * The calculator depends on a Calculation Engine for the actual calculation.  The
 * calculator's job is to arbitrate the operands and return a sane response
 */
class Calculator
{
    use ArbitrateTwoTypes;

    const ENGINE_NATIVE = 0;

    const NS = 'Chippyash\Math\Type\Calculator\\';

    protected $supportedEngines = [
        self::ENGINE_NATIVE => 'Native'
    ];

    /**
     * Calculation engine
     * @var CalculatorEngineInterface
     */
    protected $calcEngine;


    /**
     * Constructor
     * Set up the calculation engine. In due course this will support gmp, bcmath etc
     *
     * @param  int|CalculatorEngineInterface $calcEngine Calculation engine to use - default == Native
     * @throws \InvalidArgumentException
     */
    public function __construct($calcEngine = null)
    {
        if (is_null($calcEngine)) {
            $this->calcEngine = new Native();
        } elseif (is_int($calcEngine) && array_key_exists($calcEngine, $this->supportedEngines)) {
            $className = self::NS . $this->supportedEngines[$calcEngine];
            $this->calcEngine = new $className();
        } elseif ($calcEngine instanceof CalculatorEngineInterface) {
            $this->calcEngine = $calcEngine;
        }

        if (is_null($this->calcEngine)) {
            throw new \InvalidArgumentException('No known calculator engine');
        }
    }

    /**
     * Return addition of two types: a + b
     *
     * @param int|float|NumericTypeInterface $a first operand
     * @param int|float|NumericTypeInterface $b second operand
     *
     * @return NumericTypeInterface
     * 
     * @noinspection PhpInconsistentReturnPointsInspection
     */
    public function add($a, $b)
    {
        $a = $this->convert($a);
        $b = $this->convert($b);

        switch ($this->arbitrate($a, $b)) {
        case 'int':
            return $this->calcEngine->intAdd($a, $b);
        case 'float':
            return $this->calcEngine->floatAdd($a, $b);
        case 'whole':
            return $this->calcEngine->wholeAdd($a, $b);
        case 'natural':
            return $this->calcEngine->naturalAdd($a, $b);
        case 'rational':
            return $this->calcEngine->rationalAdd($a, $b);
        case 'complex':
            return $this->calcEngine->complexAdd($a, $b);
        case 'complex:numeric':
            return $this->calcEngine->complexAdd($a, $b->asComplex());
        case 'numeric:complex':
            return $this->calcEngine->complexAdd($a->asComplex(), $b);
        }
    }

    /**
     * Return subtraction of two types: a - b
     *
     * @param int|float|NumericTypeInterface $a first operand
     * @param int|float|NumericTypeInterface $b second operand
     * 
     * @return NumericTypeInterface
     * 
     * @noinspection PhpInconsistentReturnPointsInspection
     */
    public function sub($a, $b)
    {
        $a = $this->convert($a);
        $b = $this->convert($b);
        switch ($this->arbitrate($a, $b)) {
        case 'int':
            return $this->calcEngine->intSub($a, $b);
        case 'float':
            return $this->calcEngine->floatSub($a, $b);
        case 'whole':
            return $this->calcEngine->wholeSub($a, $b);
        case 'natural':
            return $this->calcEngine->naturalSub($a, $b);
        case 'rational':
            return $this->calcEngine->rationalSub($a, $b);
        case 'complex':
            return $this->calcEngine->complexSub($a, $b);
        case 'complex:numeric':
            return $this->calcEngine->complexSub($a, $b->asComplex());
        case 'numeric:complex':
            return $this->calcEngine->complexSub($a->asComplex(), $b);
        }
    }

    /**
     * Return multiplication of two types: a * b
     *
     * @param int|float|NumericTypeInterface $a first operand
     * @param int|float|NumericTypeInterface $b second operand
     * 
     * @return NumericTypeInterface
     * 
     * @noinspection PhpInconsistentReturnPointsInspection
     */
    public function mul($a, $b)
    {
        $a = $this->convert($a);
        $b = $this->convert($b);
        switch ($this->arbitrate($a, $b)) {
        case 'int':
            return $this->calcEngine->intMul($a, $b);
        case 'float':
            return $this->calcEngine->floatMul($a, $b);
        case 'whole':
            return $this->calcEngine->wholeMul($a, $b);
        case 'natural':
            return $this->calcEngine->naturalMul($a, $b);
        case 'rational':
            return $this->calcEngine->rationalMul($a, $b);
        case 'complex':
            return $this->calcEngine->complexMul($a, $b);
        case 'complex:numeric':
            return $this->calcEngine->complexMul($a, $b->asComplex());
        case 'numeric:complex':
            return $this->calcEngine->complexMul($a->asComplex(), $b);
        }
    }

    /**
     * Return division of two types: a / b
     *
     * @param int|float|NumericTypeInterface $a first operand
     * @param int|float|NumericTypeInterface $b second operand
     * 
     * @return NumericTypeInterface
     */
    public function div($a, $b)
    {
        $a = $this->convert($a);
        $b = $this->convert($b);
        switch ($this->arbitrate($a, $b)) {
        case 'int':
        case 'whole':
        case 'natural':
            return $this->calcEngine->intDiv($a, $b);
        case 'rational':
            return $this->calcEngine->rationalDiv($a, $b);
        case 'complex':
            return $this->calcEngine->complexDiv($a, $b);
        case 'complex:numeric':
            return $this->calcEngine->complexDiv($a, $b->asComplex());
        case 'numeric:complex':
            return $this->calcEngine->complexDiv($a->asComplex(), $b);
        default:
            return $this->calcEngine->floatDiv($a, $b);
        }
    }

    /**
     * Return reciprocal of the type: 1/a
     *
     * @param  int|float|NumericTypeInterface $a
     * @return NumericTypeInterface
     */
    public function reciprocal($a)
    {
        $a = $this->convert($a);
        switch ($this->arbitrate($a, $a)) {
        case 'rational':
            return $this->calcEngine->rationalReciprocal($a);
        case 'complex':
            return $this->calcEngine->complexReciprocal($a);
        default :
            return $this->calcEngine->floatReciprocal($a);
        }
    }

    /**
     * 
     * @param int|float|NumericTypeInterface              $a
     * @param NumericTypeInterface $exp
     * @return NumericTypeInterface
     */
    public function pow($a, $exp)
    {
        $a = $this->convert($a);
        switch ($this->arbitrate($a, $a)) {
        case 'rational':
            return $this->calcEngine->rationalPow($a, $exp);
        case 'complex':
            return $this->calcEngine->complexPow($a, $exp);
        case 'int':
        case 'whole':
        case 'natural':
            return $this->calcEngine->intPow($a, $exp);
        default :
            return $this->calcEngine->floatPow($a, $exp);
        }
    }
    
    /**
     * 
     * @param int|float|NumericTypeInterface $a
     * @return NumericTypeInterface
     */
    public function sqrt($a)
    {
        $a = $this->convert($a);
        switch ($this->arbitrate($a, $a)) {
        case 'rational':
            return $this->calcEngine->rationalSqrt($a);
        case 'complex':
            return $this->calcEngine->complexSqrt($a);
        case 'int':
        case 'whole':
        case 'natural':
            return $this->calcEngine->intSqrt($a);
        default :
            return $this->calcEngine->floatSqrt($a);
        }
    }

    /**
     * Convert into Strong Numeric Type
     * 
     * @param int|float|NumericTypeInterface $num operand
     * 
     * @return \Chippyash\Type\Number\IntType
     */
    protected function convert($num)
    {
        if ($num instanceof NumericTypeInterface) {
            return $num;
        }
        if (is_numeric($num)) {
            return $this->calcEngine->convertNumeric($num);
        }

        $type = (is_object($num) ? get_class($num) : gettype($num));
        throw new \BadMethodCallException('No solution for unknown type: ' . $type);
    }
}
