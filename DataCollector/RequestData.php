<?php

namespace MagentoHackathon\Toolbar\DataCollector;

use MagentoHackathon\Toolbar\Api\DataCollectorInterface;
use MagentoHackathon\Toolbar\Api\RequestDataInterface;
use MagentoHackathon\Toolbar\Exception\DataCollectorNotFoundException;

/**
 * Storage for DataCollectors in a request
 */
class RequestData implements RequestDataInterface
{
    /**
     * Registered DataCollectors
     *
     * @var array
     */
    private $dataCollectors = array();

    /**
     * {@inheritDoc}
     */
    public function addDataCollector($name, DataCollectorInterface $dataCollector)
    {
        $this->dataCollectors[$name] = $dataCollector;
    }

    /**
     * {@inheritDoc}
     */
    public function getDataCollectors()
    {
        return $this->dataCollectors;
    }

    /**
     * {@inheritDoc}
     */
    public function getDataCollector($name)
    {
        if (!array_key_exists($name, $this->dataCollectors)) {
            throw new DataCollectorNotFoundException(sprintf(
                'No DataCollector found for "%s"',
                $name
            ));
        }

        return $this->dataCollectors[$name];
    }

    /**
     * {@inheritDoc}
     */
    public function collect()
    {
        foreach($this->getDataCollectors() as $dataCollector) {
            $dataCollector->collect();
        }
    }

    /**
     * {@inheritDoc}
     */
    public function serialize()
    {
        return serialize($this->dataCollectors);
    }

    /**
     * {@inheritDoc}
     */
    public function unserialize($data)
    {
        $this->dataCollectors = unserialize($data);
    }
}
