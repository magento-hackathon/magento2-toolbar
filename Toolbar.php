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
        if ( ! $response->isRedirect()) {
            $this->injectToolbar($response);
        }
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
            $content = substr($content, 0, $pos) . $renderer->render() . substr($content, $pos);

            // Update the response content
            $response->setBody($content);
        }
    }
}