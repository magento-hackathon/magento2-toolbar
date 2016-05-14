<?php

namespace MagentoHackathon\Toolbar\Api;

use MagentoHackathon\Toolbar\Exception\DataCollectorNotFoundException;
use Serializable;

/**
 * Container for DataCollectors in a request
 */
interface RequestDataInterface extends Serializable
{
    /**
     * Add DataCollector
     *
     * @param string                 $name
     * @param DataCollectorInterface $dataCollector
     *
     * @return void
     */
    public function addDataCollector($name, DataCollectorInterface $dataCollector);

    /**
     * Get DataCollectors added in the request
     *
     * @return array
     */
    public function getDataCollectors();

    /**
     * Get specific DataCollector by name
     *
     * @param string $name
     *
     * @return DataCollectorInterface
     *
     * @throws DataCollectorNotFoundException
     */
    public function getDataCollector($name);
}
