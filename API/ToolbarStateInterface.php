<?php

namespace MagentoHackathon\Toolbar\API;

use DebugBar\DataCollector\DataCollectorInterface;

interface ToolbarStateInterface
{
    /**
     * Check if the Toolbar should be enabled.
     *
     * @return bool
     */
    public function isToolbarEnabled();

    /**
     * Check if the Toolbar should run at all.
     *
     * @return bool
     */
    public function shouldToolbarRun();

    /**
     * Determine if a specific collector should run.
     *
     * @param DataCollectorInterface $collector
     * @return bool
     */
    public function shouldCollectorRun(DataCollectorInterface $collector);
}