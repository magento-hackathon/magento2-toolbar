<?php

namespace MagentoHackathon\Toolbar\Plugin;

use MagentoHackathon\Toolbar\Toolbar;
use MagentoHackathon\Toolbar\DataCollector\MagentoCollector;

/**
 * Adds the Events collector
 *
 */
class AddMagentoCollectorPlugin extends AbstractAddCollectorPlugin
{
    public function __construct(Toolbar $toolbar, MagentoCollector $collector)
    {
        parent::__construct($toolbar, $collector);
    }
}
