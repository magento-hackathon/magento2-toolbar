<?php

namespace MagentoHackathon\Toolbar\Api;

use Serializable;

/**
 * DataCollector Interface
 *
 * This interface should be implemented to collect your own data for a request.
 * It is up to the implementation to decide at which moment and in which way the data
 * is collected.
 */
interface DataCollectorInterface extends Serializable
{
    /**
     * Collect data not already collected
     *
     * This function is called just before the collector
     * is serialized and stored, it allows you to collect
     * data not already collected
     *
     * @return void
     */
    public function collect();

    /**
     * Get collected data
     *
     * @return mixed
     */
    public function getData();
}
