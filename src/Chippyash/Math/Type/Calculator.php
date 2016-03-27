<?php
/*
 * Arithmetic calculation support for Chippyash Strong Types
 *
 * @author Ashley Kitson <akitson@zf4.biz>
 * @copyright Ashley Kitson, UK, 2014
 * @licence GPL V3 or later : http://www.gnu.org/licenses/gpl.html
 */
namespace Chippyash\Math\Type;

use Chippyash\Type\Interfaces\NumericTypeInterface;
use Chippyash\Math\Type\Calculator\CalculatorEngineInterface;
use Chippyash\Math\Type\Traits\ArbitrateTwoTypes;
use Chippyash\Type\RequiredType;

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

    /**@+
     * Numeric engine types
     */
    const TYPE_DEFAULT = 0;
    const TYPE_NATIVE = 1;
    const TYPE_GMP = 2;
    /**@-*/

    const NS = 'Chippyash\\Math\\Type\\Calculator\\';

    protected $supportedEngines = [
        self::TYPE_NATIVE => 'NativeEngine',
        self::TYPE_GMP => 'GmpEngine'
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
     * @param int|CalculatorEngineInterface $calcEngine Calculation engine to use - default == Auto
     * @throws \InvalidArgumentException
     */
    public function __construct($calcEngine = null)
    {
        if (is_null($calcEngine) || (is_int($calcEngine) && $calcEngine == self::TYPE_DEFAULT)) {
            $this->calcEngine = $this->getDefaultEngine();
            return;
        } elseif (is_int($calcEngine) && array_key_exists($calcEngine, $this->supportedEngines)) {
            $className = self::NS . $this->supportedEngines[$calcEngine];
            $this->calcEngine = new $className();
            return;
        } elseif ($calcEngine instanceof CalculatorEngineInterface) {
            $this->calcEngine = $calcEngine;
            return;
        }

        throw new \InvalidArgumentException('No known calculator engine');
    }

    /**
     * Return addition of two types: a + b
     *
     * @param numeric|NumericTypeInterface $a
     * @param numeric|NumericTypeInterface $b
     *
     *
     *
     * @return NumericTypeInterface
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
                return $this->calcEngine->rationalAdd($a->asRational(), $b->asRational());
            case 'complex':
                return $this->calcEngine->complexAdd($a->asComplex(), $b->asComplex());
        }
    }

    /**
     * Return subtraction of two types: a - b
     *
     * @param numeric|NumericTypeInterface $a
     * @param numeric|NumericTypeInterface $b
     * @return NumericTypeInterface
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
                return $this->calcEngine->rationalSub($a->asRational(), $b->asRational());
            case 'complex':
                return $this->calcEngine->complexSub($a->asComplex(), $b->asComplex());
        }
    }

    /**
     * Return multiplication of two types: a * b
     *
     * @param numeric|NumericTypeInterface $a
     * @param numeric|NumericTypeInterface $b
     * @return NumericTypeInterface
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
                return $this->calcEngine->rationalMul($a->asRational(), $b->asRational());
            case 'complex':
                return $this->calcEngine->complexMul($a->asComplex(), $b->asComplex());
        }
    }

    /**
     * Return division of two types: a / b
     *
     * @param numeric|NumericTypeInterface $a
     * @param numeric|NumericTypeInterface $b
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
                return $this->calcEngine->rationalDiv($a->asRational(), $b->asRational());
            case 'complex':
                return $this->calcEngine->complexDiv($a->asComplex(), $b->asComplex());
            default:
                return $this->calcEngine->floatDiv($a, $b);
        }
    }

    /**
     * Return reciprocal of the type: 1/a
     *
     * @param numeric|NumericTypeInterface $a
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
     * @param numeric|NumericTypeInterface $a
     * @param numeric|NumericTypeInterface $exp
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
     * @param numeric|NumericTypeInterface $a
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
     * Return the natural logarithm (base e) of the number
     * 
     * @param numeric|NumericTypeInterface $a
     * 
     * @return Chippyash\Type\Number\Complex\AbstractComplexType
     */
    public function natLog($a)
    {
        return $this->calcEngine->natLog($this->convert($a));
    }
    
    /**
     * In place incrementor
     * 
     * @param numeric|NumericTypeInterface $a
     * @param numeric|NumericTypeInterface $inc Default == 1
     * 
     * @return NumericTypeInterface
     */
    public function inc(NumericTypeInterface &$a, $inc = null)
    {
        if (!is_null($inc)) {
            $inc = $this->convert($inc);
        }
        
        return $this->calcEngine->inc($a, $inc);
    }
    
    /**
     * In place decrementor
     * 
     * @param numeric|NumericTypeInterface $a
     * @param numeric|NumericTypeInterface $inc Default == 1
     * 
     * @return NumericTypeInterface
     */
    public function dec(NumericTypeInterface &$a, $inc = null)
    {
        if (!is_null($inc)) {
            $inc = $this->convert($inc);
        }
        
        return $this->calcEngine->dec($a, $inc);
    }
    
    /**
     * Return the actual calc engine in use
     * 
     * @return CalculatorEngineInterface
     */
    public function getEngine()
    {
        return $this->calcEngine;
    }
    
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

    /**
     * Get the required type base to return
     *
     * @return string
     */
    protected function getRequiredType()
    {
        return RequiredType::getInstance()->get();
    }

    protected function getDefaultEngine()
    {
        if ($this->getRequiredType() == RequiredType::TYPE_NATIVE) {
            $class = $this->supportedEngines[self::TYPE_NATIVE];
        } else {
            $class = $this->supportedEngines[self::TYPE_GMP];
        }

        $className = self::NS . $class;

        return new $className();
    }
}
