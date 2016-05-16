<?php

namespace MagentoHackathon\Toolbar;

use DebugBar\DebugBar;
use DebugBar\DataCollector\ExceptionsCollector;
use DebugBar\DataCollector\MessagesCollector;
use DebugBar\DataCollector\RequestDataCollector;
use DebugBar\DataCollector\TimeDataCollector;
use Magento\Framework\App\Request\Http as HttpRequest;
use Magento\Framework\App\Response\Http as HttpResponse;
use MagentoHackathon\Toolbar\Storage\FilesystemStorage;

class Toolbar extends DebugBar
{
    /** @var  HttpRequest */
    protected $request;

    /**
     * Toolbar constructor.
     */
    public function __construct(HttpRequest $request, FilesystemStorage $storage)
    {
        $this->request = $request;

        // Add some default collectors
        $this->addCollector(new RequestDataCollector());

        // Link to the static assets
        $renderer = $this->getJavascriptRenderer();

        // Add our own custom CSS
        $renderer->addAssets([
            'toolbar.css',
            'font-awesome.css'
        ], [], __DIR__ . '/view/base/web');

        // Use RequireJS to include jQuery
        $renderer->disableVendor('jquery');
        $renderer->disableVendor('fontawesome');
        $renderer->setUseRequireJs(true);

        $this->setStorage($storage);
        $renderer->setOpenHandlerUrl('/hackathon_toolbar/openhandler/handle');

    }

    /**
     * @param HttpResponse $response
     */
    public function modifyResponse(HttpResponse $response)
    {
        $request = $this->request;

        // Don't collect or store on internal routes
        if ($request->getControllerModule() == 'MagentoHackathon_Toolbar') {
            return;
        }

        // Collect the data
        $this->collect();

        // Store data for later usage
        if ($this->storage) {
            $this->storage->save($this->getCurrentRequestId(), $this->data);
        }

        if ($this->shouldInject($request, $response)) {
            $this->injectToolbar($response);
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
        return ! $response->isRedirect() && ! $request->isAjax();
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
        if (false !== $pos) {

            // Link to our controller routes
            $assets  = "<link rel='stylesheet' type='text/css' href='/hackathon_toolbar/assets/css'>";
            $assets .= "<script type='text/javascript' src='/hackathon_toolbar/assets/js'></script>";

            $toolbar = $assets . $renderer->render();
            $content = substr($content, 0, $pos) . $toolbar . substr($content, $pos);

            // Update the response content
            $response->setBody($content);
        }
    }
}