<?php

namespace MagentoHackathon\Toolbar\DataCollector;

use DebugBar\DataCollector\MessagesCollector;

/**
 * DataCollector that collects event names
 *
 */
class EventsCollector extends MessagesCollector
{
    /**
     * @return string
     */
    public function getName()
    {
        return 'events';
    }
    /**
     * @param $eventName
     * @param array $data
     */
    public function addEvent($eventName, $data = [])
    {
        $params = [];
        if ($data) {
            foreach($data as $key => $value){
                if (is_object($value)) {
                    $params[$key] = get_class($value);
                } else {
                    $params[$key] = $this->getDataFormatter()->formatVar($value);
                }
            }
        }
        $this->addMessage($eventName . ($params ?  ' => '. print_r($params, true) : ''));
    }
}
