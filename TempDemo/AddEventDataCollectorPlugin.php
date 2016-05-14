<?php

namespace MagentoHackathon\Toolbar\TempDemo;


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
    protected $requestData;
    protected $collector;

    /**
     * Constructor
     *
     * @param RequestDataInterface $requestData
     * @param EventDataCollector $collector
     */
    public function __construct(
        RequestDataInterface $requestData,
        EventDataCollector $collector
    )
    {
        $this->requestData = $requestData;
        $this->collector = $collector;
    }

    /**
     * Add DataCollector to the RequestData when
     * launching our application
     */
    public function beforeLaunch()
    {
        $this->requestData->addDataCollector("events", $this->collector);
    }
}
