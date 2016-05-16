<?php

namespace MagentoHackathon\Toolbar\Plugin;

use DebugBar\DataCollector\ExceptionsCollector;
use DebugBar\DataCollector\MessagesCollector;
use Magento\Framework\Event\Manager;
use MagentoHackathon\Toolbar\Toolbar;

/**
 * Plugin to collect event names and add it to the Event DataCollector
 *
 */
class AddExceptionsCollectorPlugin
{
    /** @var  Toolbar */
    protected $toolbar;

    /** @var MessagesCollector  */
    protected $collector;

    /**
     * Constructor
     *
     * @param ExceptionsCollector $collector
     */
    public function __construct(Toolbar $toolbar, ExceptionsCollector $collector)
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
