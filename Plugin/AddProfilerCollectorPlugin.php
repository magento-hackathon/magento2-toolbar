<?php

namespace MagentoHackathon\Toolbar\Plugin;

use Magento\Framework\Event\Manager;
use Magento\Framework\Profiler;
use MagentoHackathon\Toolbar\DataCollector\ProfilerCollector;
use MagentoHackathon\Toolbar\Toolbar;
use MagentoHackathon\Toolbar\DataCollector\EventsCollector;

/**
 * Plugin to collect profile information and add it to the Profiler DataCollector
 *
 */
class AddProfilerCollectorPlugin
{
    /** @var  Toolbar */
    protected $toolbar;

    /** @var ProfilerCollector  */
    protected $collector;

    /**
     * Constructor
     *
     * @param ProfilerCollector $collector
     */
    public function __construct(Toolbar $toolbar, ProfilerCollector $collector)
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

        // Register the profiler, reset the existing timers
        $this->collector->resetTime();
        Profiler::add($this->collector);
        Profiler::start('magento');
    }
}
