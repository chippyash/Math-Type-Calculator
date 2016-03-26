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
use Chippyash\Math\Type\Comparator\Native;
use Chippyash\Math\Type\Comparator\ComparatorEngineInterface;
use Chippyash\Math\Type\Comparator\AbstractComparatorEngine;

/**
 * Generic comparator for strong type support
 * 
 * NB - this uses the Calculator to determine correct base types
 */
class Comparator implements ComparatorEngineInterface
{
    const ENGINE_NATIVE = 0;

    const NS = 'Chippyash\Math\Type\Comparator\\';

    protected $supportedEngines = [
        self::ENGINE_NATIVE => 'Native'
    ];

    /**
     * Comparator engine
     * @var Chippyash\Math\Type\Comparator\ComparatorEngineInterface
     */
    protected $compEngine;

    /**
     * Constructor
     * Set up the comparator engine. In due course this will support gmp, bcmath etc
     *
     * @param int|Chippyash\Math\Type\Comparator\ComparatorEngineInterface $compEngine Comparator engine to use - default == Native
     * @throws \InvalidArgumentException
     */
    public function __construct(ComparatorEngineInterface $compEngine = null)
    {
        if ($compEngine instanceof ComparatorEngineInterface) {
            $this->compEngine = $compEngine;
            return;
        }
        
        if (self::getRequiredType() == Calculator::TYPE_GMP) {
            $this->compEngine = new GmpEngine();
            return;
        }
        
        $this->compEngine = new NativeEngine();
    }

    /**
     * a == b = 0
     * a < b = -1
     * a > b = 1
     *
     * @param Chippyash\Type\Interfaces\NumericTypeInterface $a
     * @param Chippyash\Type\Interfaces\NumericTypeInterface $b
     *
     * @return int
     */
    public function compare(NumericTypeInterface $a, NumericTypeInterface $b)
    {
        return $this->compEngine->compare($a, $b);
    }

    /**
     * Proxy to comparatorEngine if it is an instance of AbstractComparatorEngine
     * Allows you to call ->eq(), ->lt() etc.
     *
     * @param string $name
     * @param array $arguments
     *
     * @return boolean
     *
     * @throws \BadMethodCallException
     */
    public function __call($name, $arguments)
    {
        if (method_exists($this->compEngine, $name)) {
            return call_user_func_array(array($this->compEngine, $name), $arguments);
        }

        throw new \BadMethodCallException('Unsupported comparator method: ' . $name);
    }
  
    /**
     * Get the required type base to return
     * 
     * @return string
     */
    protected static function getRequiredType()
    {
        return Calculator::getRequiredType();
    }
    
}
