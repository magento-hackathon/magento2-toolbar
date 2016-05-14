<?php

namespace MagentoHackathon\Toolbar\TempDemo;

use DebugBar\DataCollector\TimeDataCollector;


/**
 * DataCollector that collects event names
 *
 */
class EventDataCollector extends TimeDataCollector
{
    /**
     * @param $eventName
     */
    public function addEvent($eventName)
    {
        $time = microtime(true);
        $this->addMeasure($eventName, $time, $time);
    }

    public function collect()
    {
        $data = parent::collect();

        $data['nb_measures'] = count($data['measures']);
        return $data;
    }

    public function getName()
    {
        return 'event';
    }

    public function getWidgets()
    {
        return array(
            "events" => array(
                "icon" => "tasks",
                "widget" => "PhpDebugBar.Widgets.TimelineWidget",
                "map" => "event",
                "default" => "{}",
            ),
            'events:badge' => array(
                'map' => 'event.nb_measures',
                'default' => 0,
            ),
        );
    }
}
