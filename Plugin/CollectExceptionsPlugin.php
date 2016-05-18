<?php

namespace MagentoHackathon\Toolbar\Plugin;

use DebugBar\DataCollector\ExceptionsCollector;
use DebugBar\DataCollector\MessagesCollector;
use MagentoHackathon\Toolbar\DataCollector\EventsCollector;
use Magento\Framework\Event\Manager;
use Psr\Log\LoggerInterface;

/**
 * Plugin to collect messages and exceptions from the Logger and add it to the collector
 */
class CollectExceptionsPlugin
{
    /** @var ExceptionsCollector  */
    protected $messages;

    /**
     * Constructor
     *
     * @param ExceptionsCollector $collector
     */
    public function __construct(ExceptionsCollector $collector)
    {
        $this->collector = $collector;
    }

    /**
     * Add event name to collector on dispatch
     *
     * @param LoggerInterface $logger
     * @param mixed  $message
     */
    public function beforeEmergency($logger, $message)
    {
        $this->addMessage($message);
    }

    public function beforeAlert($logger, $message)
    {
        $this->addMessage($message);
    }

    public function beforeCritical($logger, $message)
    {
        $this->addMessage($message);
    }

    public function beforeError($logger, $message)
    {
        $this->addMessage($message);
    }

    public function beforeWarning($logger, $message)
    {
        $this->addMessage($message);
    }

    public function beforeNotice($logger, $message)
    {
        $this->addMessage($message);
    }

    public function beforeInfo($logger, $message)
    {
        $this->addMessage($message);
    }

    public function beforeDebug($logger, $message)
    {
        $this->addMessage($message);
    }

    public function beforeLog($logger, $message)
    {
        $this->addMessage($message);
    }

    protected function addMessage($message)
    {
        if ($message instanceof \Exception) {
            $this->collector->addException($message);
        }
    }
}
