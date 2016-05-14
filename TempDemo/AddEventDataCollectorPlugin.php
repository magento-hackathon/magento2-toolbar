<?php

namespace MagentoHackathon\Toolbar\TempDemo;

use MagentoHackathon\Toolbar\Toolbar;
use MagentoHackathon\Toolbar\Api\RequestDataInterface;

/**
 * Plugin to add Event DataCollector to the RequestData
 *
 * TODO: Determine if we should use a plugin or an event to
 *       allow modules to add it's DataCollector to the RequestData
 *
 * TODO: Remove
 */
class AddEventDataCollectorPlugin
{
    /** @var  Toolbar $toolbar */
    protected $toolbar;
    protected $collector;

    /**
     * Constructor
     *
     * @param RequestDataInterface $requestData
     * @param EventDataCollector $collector
     */
    public function __construct(
        Toolbar $toolbar,
        EventDataCollector $collector
    )
    {
        $this->toolbar = $toolbar;
        $this->collector = $collector;
    }

    /**
     * Add DataCollector to the RequestData when
     * launching our application
     */
    public function beforeLaunch()
    {
        $this->toolbar->addCollector($this->collector);
    }
}
