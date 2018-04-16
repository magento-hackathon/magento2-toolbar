<?php
namespace MagentoHackathon\Toolbar\Plugin;

use MagentoHackathon\Toolbar\DataCollector\EventCollector;
use MagentoHackathon\Toolbar\DataCollector\ObserverCollector;
use MagentoHackathon\Toolbar\Toolbar;
use Magento\Framework\Event\ManagerInterface;
use Magento\Framework\Event\ConfigInterface;

/**
 * Plugin to add Toolbar to the Response add the
 * end of the body
 */
class EventManagerPlugin
{
    /** @var EventCollector  */
    protected $eventCollector;

    /** @var ObserverCollector  */
    protected $observerCollector;

    /** @var ConfigInterface */
    protected $config;

    public function __construct(
        Toolbar $toolbar,
        EventCollector $eventCollector,
        ConfigInterface $config
    ) {
        $this->toolbar = $toolbar;
        $this->eventCollector = $eventCollector;
        $this->config = $config;
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
            if ($observers = $this->config->getObservers($eventName)) {
                $data['__observers'] = $observers;
            }

            $this->eventCollector->addEvent($eventName, $start, $end, $data);
        }

        return $res;
    }

}
