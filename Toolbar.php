<?php

namespace MagentoHackathon\Toolbar;

use DebugBar\DebugBar;
use DebugBar\DataCollector\ExceptionsCollector;
use DebugBar\DataCollector\MessagesCollector;
use DebugBar\DataCollector\RequestDataCollector;
use DebugBar\DataCollector\TimeDataCollector;
use Magento\Framework\App\Response\Http;

class Toolbar extends DebugBar
{
    /**
     * Toolbar constructor.
     */
    public function __construct()
    {
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
    }

    /**
     * @param Http $response
     */
    public function modifyResponse(Http $response)
    {
        if ($this->shouldInject($response)) {
            $this->injectToolbar($response);
        }
    }

    /**
     * Determine if the Toolbar should be injected on the current request.
     *
     * @todo  Check the config/mode
     * @param Http $response
     * @return bool
     */
    protected function shouldInject(Http $response)
    {
        return ! $response->isRedirect();
    }


    /**
     * Inject the toolbar in the HTML response.
     *
     * @param Http $response
     */
    protected function injectToolbar(Http $response)
    {
        $content = (string) $response->getBody();
        $renderer = $this->getJavascriptRenderer();

        $pos = strripos($content, '</body>');
        if (false === $pos) {
            return;
        }

        // Link to our controller routes
        $assets  = "<link rel='stylesheet' type='text/css' href='/hackathon_toolbar/assets/css'>";
        $assets .= "<script type='text/javascript' src='/hackathon_toolbar/assets/js'></script>";

        $toolbar = $assets . $renderer->render();
        $content = substr($content, 0, $pos) . $toolbar . substr($content, $pos);

        // Update the response content
        $response->setBody($content);
    }
}
