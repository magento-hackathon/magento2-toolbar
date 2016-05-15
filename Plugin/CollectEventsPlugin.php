<?php

namespace MagentoHackathon\Toolbar\Plugin;

use MagentoHackathon\Toolbar\DataCollector\EventsCollector;
use Magento\Framework\Event\Manager;

/**
 * Plugin to collect event names and add it to the Event DataCollector
 */
class CollectEventsPlugin
{
    /**
     * Event DataCollector
     *
     * @var EventsCollector
     */
    protected $collector;

    /**
     * Constructor
     *
     * @param EventsCollector $collector
     */
    public function __construct(EventsCollector $collector)
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
    public function beforeDispatch($interceptor, $eventName, $data = [])
    {
        $this->collector->addEvent($eventName, $data);
    }
}
