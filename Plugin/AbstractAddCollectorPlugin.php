<?php

namespace MagentoHackathon\Toolbar\Plugin;

use MagentoHackathon\Toolbar\Toolbar;
use DebugBar\DataCollector\DataCollectorInterface;

/**
 * Plugin to add a collector to the toolbar
 *
 * Example usage in etc/di.xml:
 *
 * <type name="Magento\Framework\AppInterface">
 *   <plugin name="MyCollectorPlugin" type="MyCollectorPlugin" sortOrder="0" />
 * </type>
 *
 */
abstract class AbstractAddCollectorPlugin
{
    /** @var  Toolbar */
    protected $toolbar;

    /** @var DataCollectorInterface  */
    protected $collector;

    /**
     * Constructor
     *
     * @param Toolbar $toolbar
     * @param DataCollectorInterface $collector
     */
    public function __construct(Toolbar $toolbar, DataCollectorInterface $collector)
    {
        $this->toolbar = $toolbar;
        $this->collector = $collector;
    }

    /**
     * Add the collector
     *
     */
    public function beforeLaunch()
    {
        $this->toolbar->addCollector($this->collector);
    }
}
