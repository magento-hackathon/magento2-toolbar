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
class CollectLoggerPlugin
{
    /** @var MessagesCollector  */
    protected $messages;

    /** @var ExceptionsCollector  */
    protected $exceptions;

    /**
     * Constructor
     *
     * @param MessagesCollector $collector
     */
    public function __construct(MessagesCollector $collector, ExceptionsCollector $exceptions)
    {
        $this->messages = $collector;
        $this->exceptions = $exceptions;
    }

    /**
     * Add event name to collector on dispatch
     *
     * @param LoggerInterface $logger
     * @param mixed  $message
     */
    public function beforeEmergency($logger, $message)
    {
        $this->addMessage($message, 'emergency');
    }

    public function beforeAlert($logger, $message)
    {
        $this->addMessage($message, 'alert');
    }

    public function beforeCritical($logger, $message)
    {
        $this->addMessage($message, 'critical');
    }

    public function beforeError($logger, $message)
    {
        $this->addMessage($message, 'error');
    }

    public function beforeWarning($logger, $message)
    {
        $this->addMessage($message, 'warning');
    }

    public function beforeNotice($logger, $message)
    {
        $this->addMessage($message, 'notice');
    }

    public function beforeInfo($logger, $message)
    {
        $this->addMessage($message, 'info');
    }

    public function beforeDebug($logger, $message)
    {
        $this->addMessage($message, 'debug');
    }

    public function beforeLog($logger, $message)
    {
        $this->addMessage($message, 'log');
    }

    protected function addMessage($message, $label = 'info')
    {
        $this->messages->addMessage($message, $label);

        if ($message instanceof \Exception) {
            $this->exceptions->addException($message);
        }
    }
}
