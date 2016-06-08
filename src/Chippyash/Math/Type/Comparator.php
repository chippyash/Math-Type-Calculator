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
use Chippyash\Type\RequiredType;


/**
 * Generic comparator for strong type support
 * 
 * NB - this uses the Calculator to determine correct base types
 */
class Comparator implements ComparatorEngineInterface
{
    /**@+
     * Numeric engine types
     */
    const TYPE_DEFAULT = 0;
    const TYPE_NATIVE = 1;
    const TYPE_GMP = 2;
    /**@-*/

    const NS = 'Chippyash\\Math\\Type\\Comparator\\';

    protected $supportedEngines = [
        self::TYPE_NATIVE => 'NativeEngine',
        self::TYPE_GMP => 'GmpEngine'
    ];
    /**
     * Comparator engine
     * @var ComparatorEngineInterface
     */
    protected $compEngine;

    /**
     * Constructor
     * Set up the comparator engine. In due course this will support gmp, bcmath etc
     *
     * @param int|ComparatorEngineInterface $compEngine Comparator engine to use - default == Native
     * @throws \InvalidArgumentException
     */
    public function __construct($compEngine = null)
    {
        if (is_null($compEngine) || (is_int($compEngine) && $compEngine == self::TYPE_DEFAULT)) {
            $this->compEngine = $this->getDefaultEngine();
            return;
        } elseif (is_int($compEngine) && array_key_exists($compEngine, $this->supportedEngines)) {
            $className = self::NS . $this->supportedEngines[$compEngine];
            $this->compEngine = new $className();
            return;
        } elseif ($compEngine instanceof ComparatorEngineInterface) {
            $this->calcEngine = $compEngine;
            return;
        }

        throw new \InvalidArgumentException('No known calculator engine');
    }

    /**
     * a == b = 0 (or a ≈ b = 0)
     * a < b = -1
     * a > b = 1
     *
     * @param NumericTypeInterface $a
     * @param NumericTypeInterface $b
     * @param NumericTypeInterface $tolerance
     *
     * @return int
     */
    public function compare(NumericTypeInterface $a, NumericTypeInterface $b, NumericTypeInterface $tolerance = null)
    {
        return $this->compEngine->compare($a, $b, $tolerance);
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
