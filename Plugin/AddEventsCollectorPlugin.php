<?php

namespace MagentoHackathon\Toolbar\Plugin;

use Magento\Framework\Event\Manager;
use MagentoHackathon\Toolbar\Toolbar;
use MagentoHackathon\Toolbar\DataCollector\EventsCollector;

/**
 * Plugin to collect event names and add it to the Event DataCollector
 *
 */
class AddEventsCollectorPlugin
{
    /** @var  Toolbar */
    protected $toolbar;

    /** @var EventsCollector  */
    protected $collector;

    /**
     * Constructor
     *
     * @param EventsCollector $collector
     */
    public function __construct(Toolbar $toolbar, EventsCollector $collector)
    {
        $this->toolbar = $toolbar;
        $this->collector = $collector;
    }

    /**
     * Add the EventCollector
     *
     */
    public function beforeLaunch()
    {
        $this->toolbar->addCollector($this->collector);
    }
}
