<?php
/*
 * Arithmetic calculation support for chippyash Strong Types
 *
 * @author Ashley Kitson <akitson@zf4.biz>
 * @copyright Ashley Kitson, UK, 2014
 * @licence GPL V3 or later : http://www.gnu.org/licenses/gpl.html
 */
namespace chippyash\Math\Type;

use chippyash\Type\Number\NumericTypeInterface;
use chippyash\Math\Type\Comparator\Native;
use chippyash\Math\Type\Comparator\ComparatorEngineInterface;
use chippyash\Math\Type\Comparator\AbstractComparatorEngine;

/**
 * Generic comparator for strong type support
 */
class Comparator implements ComparatorEngineInterface
{
    const ENGINE_NATIVE = 0;

    const NS = 'chippyash\Math\Type\Comparator\\';

    protected $supportedEngines = [
        self::ENGINE_NATIVE => 'Native'
    ];

    /**
     * Comparator engine
     * @var chippyash\Math\Type\Comparator\ComparatorEngineInterface
     */
    protected $compEngine;

    /**
     * Is the engine based on AbstractComparatorEngine
     *
     * @var boolean
     */
    protected $isAbstractComparatorEngine = false;

    /**
     * Constructor
     * Set up the comparator engine. In due course this will support gmp, bcmath etc
     *
     * @param int|chippyash\Math\Type\Comparator\ComparatorEngineInterface $compEngine Comparator engine to use - default == Native
     * @throws \InvalidArgumentException
     */
    public function __construct($compEngine = null)
    {
        if (is_null($compEngine)) {
            $this->compEngine = new Native();
        } elseif (is_int($compEngine) && array_key_exists($compEngine, $this->supportedEngines)) {
            $className = self::NS . $this->supportedEngines[$compEngine];
            $this->compEngine = new $className();
        } elseif ($compEngine instanceof CalculatorEngineInterface) {
            $this->compEngine = $compEngine;
        }

        $this->isAbstractComparatorEngine = ($this->compEngine instanceof AbstractComparatorEngine);

        if (empty($compEngine)) {
            throw new \InvalidArgumentException('No known comparator engine');
        }
    }

    /**
     * a == b = 0
     * a < b = -1
     * a > b = 1
     *
     * @param \chippyash\Type\Number\NumericTypeInterface $a
     * @param \chippyash\Type\Number\NumericTypeInterface $b
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
        if ($this->isAbstractComparatorEngine && method_exists($this->compEngine, $name)) {
            return call_user_method_array($name, $this->compEngine, $arguments);
        }

        throw new \BadMethodCallException('Unsupported comparator method: ' . $name);
    }

}
