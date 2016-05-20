<?php

namespace MagentoHackathon\Toolbar;

use DebugBar\DebugBar;
use DebugBar\DataCollector\MessagesCollector;
use DebugBar\DataCollector\TimeDataCollector;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\Controller\Result\Json;
use Magento\Framework\App\Request\Http as HttpRequest;
use Magento\Framework\App\Response\Http as HttpResponse;
use MagentoHackathon\Toolbar\DataCollector\MagentoCollector;
use MagentoHackathon\Toolbar\Storage\FilesystemStorage;

class Toolbar extends DebugBar
{
    /** @var  HttpRequest */
    protected $request;

    /**
     * Toolbar constructor.
     *
     * @param HttpRequest $request
     * @param FilesystemStorage $storage
     * @param StoreManagerInterface $storeManager
     * @param MessagesCollector $messagesCollector
     * @param TimeDataCollector $timeDataCollector
     */
    public function __construct(
        HttpRequest $request,
        FilesystemStorage $storage,
        StoreManagerInterface $storeManager,
        MagentoCollector $magentoCollector,
        MessagesCollector $messagesCollector,
        TimeDataCollector $timeDataCollector
    )
    {
        $this->request = $request;
        $this->setStorage($storage);

        // Add some default collectors
        $this->addCollector($magentoCollector);
        $this->addCollector($messagesCollector);
        $this->addCollector($timeDataCollector);

        // Link to the static assets
        $baseUrl = $storeManager->getStore()->getBaseUrl() . 'hackathon_toolbar';

        // Create our own JavascriptRenderer
        $this->jsRenderer = new JavascriptRenderer($this, $baseUrl);
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
        $this->jsRenderer->setOpenHandlerUrl($baseUrl . '/openhandler/handle');
        $this->jsRenderer->setBindAjaxHandlerToXHR(true);
    }

    /**
     * @param HttpResponse $response
     */
    public function modifyResponse(HttpResponse $response)
    {
        /** @var HttpRequest $request */
        $request = $this->request;

        if ($request->getControllerModule() == 'MagentoHackathon_Toolbar') {
            // Don't collect or store on internal routes
            return;
        } elseif ($response->isRedirect()) {
            // On redirects, stack the data for the next request
            $this->stackData();
        } elseif ($request->isAjax() || $response instanceof Json) {
            // On XHR requests, send the header so it can be shown by the active toolbar
            $this->sendDataInHeaders(true);
        } elseif($this->shouldInject($request, $response)) {
            // Inject the Toolbar into the HTML
            $this->injectToolbar($response);
        } else {
            // Just collect the data without rendering (for later viewing)ß
            $this->collect();
        }
    }

    /**
     * Determine if the Toolbar should be injected on the current request.
     *
     * @todo  Check the config/mode
     * @param HttpRequest $request
     * @param HttpResponse $response
     * @return bool
     */
    protected function shouldInject(HttpRequest $request, HttpResponse $response)
    {
        return true;
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
