<?php
namespace MagentoHackathon\Toolbar\Plugin;

use MagentoHackathon\Toolbar\DataCollector\EventCollector;
use MagentoHackathon\Toolbar\Toolbar;
use Magento\Framework\Event\ManagerInterface;

/**
 * Plugin to add Toolbar to the Response add the
 * end of the body
 */
class EventManagerPlugin
{
    /** @var EventCollector  */
    protected $eventCollector;
    
    /**
     * Constructor
     *
     * @param Toolbar $toolbar
     */
    public function __construct(Toolbar $toolbar, EventCollector $eventCollector)
    {
        $this->toolbar = $toolbar;
        $this->eventCollector = $eventCollector;
    }

    public function aroundDispatch(
        ManagerInterface $subject,
        \Closure $proceed,
        $eventName,
        array $data = []
    ) {
        $start = microtime(true);
        $res = $proceed($eventName, $data);
        $end = microtime(true);

        if ($this->toolbar->shouldCollectorRun($this->eventCollector)) {
            $this->eventCollector->addEvent($eventName, $start, $end, $data);
        }

        return $res;
    }

}
