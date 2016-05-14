<?php

namespace MagentoHackathon\Toolbar\DataCollector;

use MagentoHackathon\Toolbar\Api\DataCollectorInterface;

/**
 * Base implementation that can be used to implement DataCollector
 *
 * Children of this class must store the collected data in the data property.
 */
abstract class AbstractDataCollector implements DataCollectorInterface
{
    protected $data = array();

    /**
     * {@inheritDoc}
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * {@inheritDoc}
     */
    public function serialize()
    {
        return serialize($this->data);
    }

    /**
     * {@inheritDoc}
     */
    public function unserialize($data)
    {
        $this->data = unserialize($data);
    }
}
