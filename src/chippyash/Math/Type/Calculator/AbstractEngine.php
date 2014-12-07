<?php
/*
 * Arithmetic calculation support for chippyash Strong Types
 *
 * @author Ashley Kitson <akitson@zf4.biz>
 * @copyright Ashley Kitson, UK, 2014
 * @licence GPL V3 or later : http://www.gnu.org/licenses/gpl.html
 */
namespace chippyash\Math\Type\Calculator;

use chippyash\Math\Type\Calculator;
use chippyash\Math\Type\Comparator;
use chippyash\Type\Interfaces\NumericTypeInterface as NI;
use chippyash\Type\TypeFactory;
use chippyash\Type\Number\Rational\RationalTypeFactory;

/**
 *Abstract calculator base clase
 */
Abstract class AbstractEngine
{
    /**
     * Convergence epsilon for natural logarithm method
     * @see natLog()
     */
    const NATLOG_EPSILON = 1e-20;
    
    /**
     * @var Calculator
     */
    protected $calculator;
    
    /**
     * Allow engine to see the calculator
     * @param Calculator $calc
     */
    public function __construct(Calculator $calc)
    {
        $this->calculator = $calc;
    }

    /**
     * Increment the number by the increment
     * By default the increment == 1
     * This operation will effect the $a parameter, and it's type can change
     * as a result. e.g. incrementing an IntType by a ComplexType will change
     * $a to a ComplexType
     * 
     * @param \chippyash\Type\Interfaces\NumericTypeInterface $a
     * @param \chippyash\Type\Interfaces\NumericTypeInterface $inc
     * 
     * @return void
     */
    public function inc(NI &$a, NI $inc = null)
    {
        if (is_null($inc)) {
            $inc = TypeFactory::createInt(1);
        }
        
        $a = $this->calculator->add($a, $inc);
    }
    
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
    public function dec(NI &$a, NI $dec = null)
    {
        if (is_null($dec)) {
            $dec = TypeFactory::createInt(1);
        }
        
        $a = $this->calculator->sub($a, $dec);     
    }
    
    
    /**
     * Return the natural (base e) logarithm for a number
     * 
     * This function will use a Taylor Series algorithm to compute the log
     * for GMP calculator else use PHP inbuilt log() method
     * 
     * @param \chippyash\Type\Interfaces\NumericTypeInterface $a
     * 
     * @return \chippyash\Type\Numeric\Rational\AbstractRationalType
     */
    public function natLog(NI $a)
    {
        //handle native types
        if (Calculator::getRequiredType() !== Calculator::TYPE_GMP) {
            if ($a instanceof \chippyash\Type\Number\Complex\AbstractComplexType
                && !$a->isReal()) {
                return RationalTypeFactory::fromFloat(\log($a->modulus()->get()));
            }
            
            return RationalTypeFactory::fromFloat(\log($a()));
        }
        
        //handle gmp types
        $epsilon = RationalTypeFactory::fromFloat(self::NATLOG_EPSILON);
        $calc = $this->calculator;
        $comp = new Comparator();
        if ($a instanceof \chippyash\Type\Number\Complex\AbstractComplexType) {
            if($a->isReal()) {
                $y = $a->r();
            } else {
                $y = $a->modulus();
            }
        } else {
            $y = $a;
        }
        
        //x = (y-1)/(y+1)
        $x = $calc->div($calc->sub($y, 1), $calc->add($y, 1));
        //x = x^2
        $z = $calc->mul($x, $x);
        //initial log value
        $L = RationalTypeFactory::create(0);
        $two = RationalTypeFactory::create(2);

        //run the Taylor Series until we meet the epsilon limiter
        for ($k=RationalTypeFactory::create(1); $comp->gt($x, $epsilon); $calc->inc($k, $two)) {
            //$L += 2 * $x / $k;
            $calc->inc($L, $calc->div($calc->mul($two, $x), $k));
            //$x *= $z;
            $x = $calc->mul($x, $z);
        }

        return $L;

    }
}
