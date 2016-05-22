<?php


namespace MagentoHackathon\Toolbar\Helper;

use Magento\Framework\App\Helper\Context;
use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\State;

class Data extends AbstractHelper
{
    /** @var  State */
    protected $state;

    /**
     * @param Context $context
     */
    public function __construct(Context $context, State $state)
    {
        parent::__construct($context);
        $this->state = $state;
    }

    /**
     * Get the url for this module
     * @param  string $route
     * @param  array $params
     * @return string
     */
    public function getUrl($route = '', $params = [])
    {
        $route = 'hackathon_toolbar/' . $route;

        return $this->_getUrl($route, $params);
    }

    /**
     * Get a Config value
     *
     * @param $path
     * @return mixed
     */
    public function getConfigValue($path)
    {
        return $this->scopeConfig->getValue($path);
    }

    /**
     * Get the current Request
     *
     * @return \Magento\Framework\App\RequestInterface
     */
    public function getRequest()
    {
        return $this->_getRequest();
    }

    /**
     * Check if the Toolbar should be enabled
     *
     * @return bool
     */
    public function isToolbarEnabled()
    {
        return $this->isDeveloperMode();
    }

    /**
     * Check if the Toolbar should be visible
     * @return bool
     */
    public function isToolbarVisible()
    {
        return true;
    }

    /**
     * Check if the current request is an internal Toolbar request
     *
     * @return bool
     */
    public function isInternalToolbarRequest()
    {
        return $this->_getRequest()->getModuleName() === 'hackathon_toolbar';
    }

    /**
     * Check if we are running in Developer Mode
     *
     * @return bool
     */
    protected function isDeveloperMode()
    {
        return $this->state->getMode() === State::MODE_DEVELOPER;
    }
}
