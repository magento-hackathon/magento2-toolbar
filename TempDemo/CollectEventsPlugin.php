<?php

namespace MagentoHackathon\Toolbar\TempDemo;

use Magento\Framework\Event\Manager;

/**
 * Plugin to collect event names and add it to the Event DataCollector
 *
 * TODO: Remove
 */
class CollectEventsPlugin
{
    /**
     * Event DataCollector
     *
     * @var EventDataCollector
     */
    protected $collector;

    /**
     * Constructor
     *
     * @param EventDataCollector $collector
     */
    public function __construct(EventDataCollector $collector)
    {
        $this->collector = $collector;
    }

    /**
     * Add event name to collector on dispatch
     *
     * @param Manager $interceptor
     * @param string  $eventName
     * @param array   $data
     */
    public function beforeDispatch($interceptor, $eventName, $data=[])
    {
        $this->collector->addEvent($eventName);
    }
}
