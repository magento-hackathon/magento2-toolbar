<?php

namespace MagentoHackathon\Toolbar\DataCollector;

use DebugBar\DataCollector\TimeDataCollector;
use Magento\Framework\Profiler\DriverInterface;


/**
 * DataCollector that collects event names
 *
 */
class ProfilerCollector extends TimeDataCollector implements DriverInterface
{
    /**
     * Start timer
     *
     * @param string $timerId
     * @param array|null $tags
     * @return void
     */
    public function start($timerId, array $tags = null)
    {
        $this->startMeasure($timerId);
        $this->startedMeasures[$timerId]['params'] = $tags;
    }

    /**
     * Stop timer
     *
     * @param string $timerId
     * @return void
     */
    public function stop($timerId)
    {
        if ($this->hasStartedMeasure($timerId)) {
            $this->stopMeasure($timerId, $this->startedMeasures[$timerId]['params']);
        }
    }

    /**
     * Clear collected statistics for specified timer or for whole profiler if timer name is omitted.
     *
     * @param string|null $timerId
     * @return void
     */
    public function clear($timerId = null)
    {
        if (is_null($timerId)) {
            $this->measures = [];
        }
    }

    public function resetTime()
    {
        $this->requestStartTime = microtime(true);
    }

    public function getName()
    {
        return 'profiler';
    }

    public function getWidgets()
    {
        return array(
            "profiler" => array(
                "icon" => "tasks",
                "widget" => "PhpDebugBar.Widgets.TimelineWidget",
                "map" => "profiler",
                "default" => "{}",
            ),
        );
    }
}
