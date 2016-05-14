<?php

namespace MagentoHackathon\Toolbar\TempDemo;

use MagentoHackathon\Toolbar\DataCollector\AbstractDataCollector;

/**
 * DataCollector that collects event names
 *
 * TODO: Remove
 */
class EventDataCollector extends AbstractDataCollector
{
    /**
     * @param $eventName
     */
    public function addEvent($eventName)
    {
        // Just store the event name for now so we are sure the
        // data can be serialized/deserialized
        $this->data[] = $eventName;
    }

    /**
     * {@inheritDoc}
     */
    public function collect()
    {
        // Nothing to collect, we've already got all data added
    }
}
