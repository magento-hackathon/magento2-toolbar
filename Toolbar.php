<?php

namespace MagentoHackathon\Toolbar;

use DebugBar\DebugBar;
use DebugBar\DataCollector\ExceptionsCollector;
use DebugBar\DataCollector\MemoryCollector;
use DebugBar\DataCollector\MessagesCollector;
use DebugBar\DataCollector\PhpInfoCollector;
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
        // Add the default collectors
        $this->addCollector(new PhpInfoCollector());
        $this->addCollector(new MessagesCollector());
        $this->addCollector(new RequestDataCollector());
        $this->addCollector(new TimeDataCollector());
        $this->addCollector(new MemoryCollector());
        $this->addCollector(new ExceptionsCollector());
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
        if (false !== $pos) {

            $toolbar = $renderer->renderHead() . $renderer->render();
            $content = substr($content, 0, $pos) . $toolbar . substr($content, $pos);

            // Update the response content
            $response->setBody($content);
        }
    }
}