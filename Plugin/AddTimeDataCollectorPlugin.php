<?php

namespace MagentoHackathon\Toolbar\Plugin;

use DebugBar\DataCollector\TimeDataCollector;
use MagentoHackathon\Toolbar\Toolbar;
use MagentoHackathon\Toolbar\DataCollector\MagentoCollector;

/**
 * Adds the Events collector
 *
 */
class AddTimeDataCollectorPlugin extends AbstractAddCollectorPlugin
{
    public function __construct(Toolbar $toolbar, TimeDataCollector $collector)
    {
        parent::__construct($toolbar, $collector);
    }
}
