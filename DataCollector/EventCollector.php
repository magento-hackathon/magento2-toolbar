<?php
namespace MagentoHackathon\Toolbar\DataCollector;

use MagentoHackathon\Toolbar\DataFormatter\SimpleFormatter;
use DebugBar\DataCollector\TimeDataCollector;

class EventCollector extends TimeDataCollector
{
    public function __construct($requestStartTime = null)
    {
        parent::__construct($requestStartTime);
        $this->setDataFormatter(new SimpleFormatter());
    }

    public function addEvent($name, $start, $end, $params)
    {
        $params = $this->prepareParams($params);

        return $this->addMeasure($name, $start, $end, $params);
    }

    protected function prepareParams($params)
    {
        $data = [];
        foreach ($params as $key => $value) {
            $data[$key] = htmlentities($this->getDataFormatter()->formatVar($value), ENT_QUOTES, 'UTF-8', false);
        }
        return $data;
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
        return [
            "events" => [
                "icon" => "tasks",
                "widget" => "PhpDebugBar.Widgets.TimelineWidget",
                "map" => "event",
                "default" => "{}",
            ],
            'events:badge' => [
                'map' => 'event.nb_measures',
                'default' => 0,
            ],
        ];
    }
}