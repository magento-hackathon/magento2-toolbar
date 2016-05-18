<?php

namespace MagentoHackathon\Toolbar\DataCollector;

use DebugBar\DataCollector\MessagesCollector;

/**
 * DataCollector that collects event names
 *
 */
class LoggerCollector extends MessagesCollector
{
    /**
     * @return string
     */
    public function getName()
    {
        return 'logger';
    }
}
