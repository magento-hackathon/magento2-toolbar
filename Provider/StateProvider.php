<?php

namespace MagentoHackathon\Toolbar\Provider;

use DebugBar\DataCollector\DataCollectorInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\App\Request\Http as HttpRequest;
use MagentoHackathon\Toolbar\API\ToolbarStateInterface;

class StateProvider implements ToolbarStateInterface
{
    /** @var  ScopeConfigInterface */
    protected $scopeConfig;

    /** @var  HttpRequest */
    protected $request;

    public function __construct(ScopeConfigInterface $scopeConfig, HttpRequest $request)
    {
        $this->scopeConfig = $scopeConfig;
        $this->request = $request;
    }

    /**
     * Check if the Toolbar should be enabled.
     *
     * @return bool
     */
    public function isToolbarEnabled()
    {
        return $this->getConfigValue('dev/hackathon_toolbar/enabled');
    }

    /**
     * Check if the Toolbar should run at all.
     *
     * @return bool
     */
    public function shouldToolbarRun()
    {
        return $this->isToolbarEnabled() && ! $this->isInternalToolbarRequest();
    }

    /**
     * Determine if a specific collector should run.
     *
     * @param DataCollectorInterface $collector
     * @return bool
     */
    public function shouldCollectorRun(DataCollectorInterface $collector)
    {
        if ( ! $this->shouldToolbarRun()) {
            return false;
        }

        $configPath = 'dev/hackathon_toolbar_collectors/' . $collector->getName();

        return (bool) $this->scopeConfig->getValue($configPath);
    }

    /**
     * Check if the Toolbar should be visible on the frontend.
     *
     * @return bool
     */
    public function isToolbarVisible()
    {
        return true;
    }

    /**
     * Check if the current request is an ajax request.
     *
     * @return bool
     */
    public function isAjaxRequest()
    {
        return $this->request->isAjax();
    }

    /**
     * Check if the current request is an internal Toolbar request.
     *
     * @return bool
     */
    protected function isInternalToolbarRequest()
    {
        return $this->request->getModuleName() === 'hackathon_toolbar';
    }

    /**
     * Get a Config value.
     *
     * @param $path
     * @return mixed
     */
    protected function getConfigValue($path)
    {
        return $this->scopeConfig->getValue($path);
    }
}
