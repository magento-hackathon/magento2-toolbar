<?php

namespace MagentoHackathon\Toolbar\Plugin;

use DebugBar\DataCollector\MessagesCollector;
use Magento\Framework\Event\Manager;
use MagentoHackathon\Toolbar\DataCollector\LoggerCollector;
use MagentoHackathon\Toolbar\Toolbar;

/**
 * Plugin to collect event names and add it to the Event DataCollector
 *
 */
class AddLoggerCollectorPlugin
{
    /** @var  MessagesCollector */
    protected $messages;

    /** @var LoggerCollector  */
    protected $collector;

    /**
     * Constructor
     *
     * @param MessagesCollector $messages
     * @param LoggerCollector $collector
     *
     */
    public function __construct(MessagesCollector $messages, LoggerCollector $collector)
    {
        $this->messages = $messages;
        $this->collector = $collector;
    }

    /**
     * Add the EventCollector
     *
     */
    public function beforeLaunch()
    {
        $this->messages->aggregate($this->collector);
    }
}
