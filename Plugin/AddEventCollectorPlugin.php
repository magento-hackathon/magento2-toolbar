<?php

namespace MagentoHackathon\Toolbar\Plugin;

use MagentoHackathon\Toolbar\DataCollector\EventCollector;
use MagentoHackathon\Toolbar\Toolbar;

/**
 * Adds the Magento collector
 *
 */
class AddEventCollectorPlugin extends AbstractAddCollectorPlugin
{
    public function __construct(Toolbar $toolbar, EventCollector $collector)
    {
        parent::__construct($toolbar, $collector);
    }
}
