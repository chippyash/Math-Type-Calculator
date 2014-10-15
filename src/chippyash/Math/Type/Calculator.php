<?php
/*
 * Arithmetic calculation support for chippyash Strong Types
 *
 * @author Ashley Kitson <akitson@zf4.biz>
 * @copyright Ashley Kitson, UK, 2014
 * @licence GPL V3 or later : http://www.gnu.org/licenses/gpl.html
 */
namespace chippyash\Math\Type;

use chippyash\Type\Interfaces\NumericTypeInterface;
use chippyash\Math\Type\Calculator\NativeEngine;
use chippyash\Math\Type\Calculator\GmpEngine;
use chippyash\Math\Type\Calculator\CalculatorEngineInterface;
use chippyash\Math\Type\Traits\ArbitrateTwoTypes;
use chippyash\Type\TypeFactory;

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
    
    /**
     * numeric base types
     * same as TypeFactory
     */
    const TYPE_DEFAULT = 'auto';
    const TYPE_NATIVE = 'native';
    const TYPE_GMP = 'gmp';
    
    /**
     * Client requested numeric base type support
     * @var string
     */
    protected static $supportType = self::TYPE_DEFAULT;
    /**
     * Numeric base types we can support
     * @var array
     */
    protected static $validTypes = [self::TYPE_DEFAULT, self::TYPE_GMP, self::TYPE_NATIVE];
    
    /**
     * The actual base type we are going to return
     * @var string
     */
    protected static $requiredType = null;
    
    /**
     * Calculation engine
     * @var chippyash\Math\Type\Calculator\CalculatorEngineInterface
     */
    protected $calcEngine;


    /**
     * Constructor
     * Set up the calculation engine. In due course this will support gmp, bcmath etc
     *
     * @param chippyash\Math\Type\Calculator\CalculatorEngineInterface $calcEngine Calculation engine to use - default == Native
     */
    public function __construct(CalculatorEngineInterface $calcEngine = null)
    {
        if ($calcEngine instanceof CalculatorEngineInterface) {
            $this->calcEngine = $calcEngine;
            return;
        }
        
        if (self::getRequiredType() == self::TYPE_GMP) {
            $this->calcEngine = new GmpEngine();
            return;
        }
        
        $this->calcEngine = new NativeEngine();
        
    }

    /**
     * Return addition of two types: a + b
     *
     * @param numeric|chippyash\Type\Interfaces\NumericTypeInterface $a
     * @param numeric|chippyash\Type\Interfaces\NumericTypeInterface $b
     *
     *
     *
     * @return chippyash\Type\Interfaces\NumericTypeInterface
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
     * @param numeric|chippyash\Type\Interfaces\NumericTypeInterface $a
     * @param numeric|chippyash\Type\Interfaces\NumericTypeInterface $b
     * @return chippyash\Type\Interfaces\NumericTypeInterface
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
     * @param numeric|chippyash\Type\Interfaces\NumericTypeInterface $a
     * @param numeric|chippyash\Type\Interfaces\NumericTypeInterface $b
     * @return chippyash\Type\Interfaces\NumericTypeInterface
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
     * @param numeric|chippyash\Type\Interfaces\NumericTypeInterface $a
     * @param numeric|chippyash\Type\Interfaces\NumericTypeInterface $b
     * @return chippyash\Type\Interfaces\NumericTypeInterface
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
     * @param numeric|chippyash\Type\Interfaces\NumericTypeInterface $a
     * @return chippyash\Type\Interfaces\NumericTypeInterface
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
     * @param numeric|chippyash\Type\Interfaces\NumericTypeInterface $a
     * @param \chippyash\Math\Type\NumericTypeInterface $exp
     * @return chippyash\Type\Interfaces\NumericTypeInterface
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
     * @param numeric|chippyash\Type\Interfaces\NumericTypeInterface $a
     * @return chippyash\Type\Interfaces\NumericTypeInterface
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
     * Set the required number type to return
     * By default this is self::TYPE_DEFAULT  which is 'auto', meaning that
     * the factory will determine if GMP is installed and use that else use 
     * PHP native types
     * 
     * @param string $requiredType
     * @throws \InvalidArgumentException
     */
    public static function setNumberType($requiredType)
    {
        if (!in_array($requiredType, self::$validTypes)) {
            throw new \InvalidArgumentException("{$requiredType} is not a supported number type");
        }
        if ($requiredType == self::TYPE_GMP && !extension_loaded('gmp')) {
            throw new \InvalidArgumentException('GMP not supported');
        }
        self::$supportType = $requiredType;
        TypeFactory::setNumberType($requiredType);
    }
    
    /**
     * Get the required type base to return
     * This is also used by the comparator to determine type
     * 
     * @return string
     */
    public static function getRequiredType()
    {
        if (self::$requiredType != null) {
            return self::$requiredType;
        }
        
        if (self::$supportType == self::TYPE_DEFAULT) {
            if (extension_loaded('gmp')) {
                self::$requiredType = self::TYPE_GMP;
            } else {
                self::$requiredType = self::TYPE_NATIVE;
            }
        } else {
            self::$requiredType = self::$supportType;
        }
        
        return self::$requiredType;
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
}
