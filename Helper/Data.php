<?php


namespace MagentoHackathon\Toolbar\Helper;

use Magento\Framework\App\Helper\Context;
use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\State;
use Magento\Store\Model\StoreManagerInterface;

class Data extends AbstractHelper
{
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
        return $this->getConfigValue('dev/hackathon_toolbar/enabled');
    }

    /**
     * @return bool
     */
    public function shouldToolbarRun()
    {
        return $this->isToolbarEnabled() && ! $this->isInternalToolbarRequest();
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
    protected function isInternalToolbarRequest()
    {
        return $this->_getRequest()->getModuleName() === 'hackathon_toolbar';
    }
}
