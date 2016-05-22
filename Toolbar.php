<?php

namespace MagentoHackathon\Toolbar;

use DebugBar\DataCollector\DataCollectorInterface;
use DebugBar\DebugBar;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\Controller\Result\Json;
use Magento\Framework\App\Request\Http as HttpRequest;
use Magento\Framework\App\Response\Http as HttpResponse;
use MagentoHackathon\Toolbar\Helper\Data as Helper;
use MagentoHackathon\Toolbar\DataCollector\MagentoCollector;
use MagentoHackathon\Toolbar\Storage\FilesystemStorage;

class Toolbar extends DebugBar
{
    /** @var  HttpRequest */
    protected $request;

    /** @var  Helper */
    protected $helper;

    /**
     * Toolbar constructor.
     *
     * @param Helper $helper
     * @param FilesystemStorage $storage
     */
    public function __construct(Helper $helper,  FilesystemStorage $storage)
    {
        $this->helper = $helper;
        $this->setStorage($storage);
    }

    /**
     * @param DataCollectorInterface $collector
     * @return bool
     */
    public function shouldCollectorRun(DataCollectorInterface $collector)
    {
        if ( ! $this->helper->shouldToolbarRun()) {
            return false;
        }

        $configPath = 'dev/hackathon_toolbar_collectors/' . $collector->getName();

        return (bool) $this->helper->getConfigValue($configPath);
    }

    /**
     * @param DataCollectorInterface $collector
     * @return $this
     * @throws \DebugBar\DebugBarException
     */
    public function addCollector(DataCollectorInterface $collector)
    {
        $collectorName = $collector->getName();

        if ($this->shouldCollectorRun($collector) && ! $this->hasCollector($collectorName)) {
            return parent::addCollector($collector);
        }
    }

    /**
     * Get the JavascriptRenderer
     *
     * @param string|null $baseUrl
     * @param string|null $basePath
     * @return \DebugBar\JavascriptRenderer
     */
    public function getJavascriptRenderer($baseUrl = null, $basePath = null)
    {
        if ($this->jsRenderer !== null) {
            return $this->jsRenderer;
        }

        // Create our own JavascriptRenderer
        $this->jsRenderer = new JavascriptRenderer($this, $this->helper);
        $this->jsRenderer = $this->getJavascriptRenderer();

        // Add our own custom CSS
        $this->jsRenderer->addAssets([
            'toolbar.css',
            'font-awesome.css'
        ], [], __DIR__ . '/view/base/web');

        // Use RequireJS to include jQuery
        $this->jsRenderer->disableVendor('jquery');
        $this->jsRenderer->disableVendor('fontawesome');
        $this->jsRenderer->setUseRequireJs(true);

        // Enable the openHandler and bind to XHR requests
        $this->jsRenderer->setOpenHandlerUrl($this->helper->getUrl('openhandler/handle'));
        $this->jsRenderer->setBindAjaxHandlerToXHR(true);

        return $this->jsRenderer;
    }

    /**
     * @param HttpResponse $response
     */
    public function modifyResponse(HttpResponse $response)
    {
        /** @var HttpRequest $request */
        $request = $this->helper->getRequest();

        if ( ! $this->helper->shouldToolbarRun()) {
            // Don't collect or store on internal routes
            return;
        } elseif ($response->isRedirect()) {
            // On redirects, stack the data for the next request
            $this->stackData();
        } elseif ($request->isAjax() || $response instanceof Json) {
            // On XHR requests, send the header so it can be shown by the active toolbar
            $this->sendDataInHeaders(true);
        } elseif($this->helper->isToolbarVisible()) {
            // Inject the Toolbar into the HTML
            $this->injectToolbar($response);
        } else {
            // Just collect the data without rendering (for later viewing)ß
            $this->collect();
        }
    }

    /**
     * Inject the toolbar in the HTML response.
     *
     * @param HttpResponse $response
     */
    protected function injectToolbar(HttpResponse $response)
    {
        $content = (string) $response->getBody();
        $renderer = $this->getJavascriptRenderer();

        $pos = strripos($content, '</body>');
        if (false === $pos) {
            return;
        }

        $toolbar = $renderer->renderHead() . $renderer->render();
        $content = substr($content, 0, $pos) . $toolbar . substr($content, $pos);

        // Update the response content
        $response->setBody($content);
    }
}
