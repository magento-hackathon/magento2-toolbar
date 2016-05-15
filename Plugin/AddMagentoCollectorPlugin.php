<?php

namespace MagentoHackathon\Toolbar\Plugin;

use Fruitcake\MagentoToolbar\DataCollector\EventDataCollector;
use Magento\Framework\Event\Manager;
use MagentoHackathon\Toolbar\DataCollector\MagentoCollector;
use MagentoHackathon\Toolbar\Toolbar;

/**
 * Plugin to collect event names and add it to the Event DataCollector
 *
 */
class AddMagentoCollectorPlugin
{
    /** @var  Toolbar */
    protected $toolbar;

    /**
     * Event DataCollector
     *
     * @var MagentoCollector
     */
    protected $collector;

    /**
     * Constructor
     *
     * @param MagentoCollector $collector
     */
    public function __construct(Toolbar $toolbar, MagentoCollector $collector)
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
