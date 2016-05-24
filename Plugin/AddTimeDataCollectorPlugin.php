<?php

namespace MagentoHackathon\Toolbar\Plugin;

use MagentoHackathon\Toolbar\Toolbar;
use DebugBar\DataCollector\TimeDataCollector;

/**
 * Adds the Time collector
 *
 */
class AddTimeDataCollectorPlugin extends AbstractAddCollectorPlugin
{
    public function __construct(Toolbar $toolbar, TimeDataCollector $collector)
    {
        parent::__construct($toolbar, $collector);
    }
}
