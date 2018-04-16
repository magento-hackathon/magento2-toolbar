<?php

namespace MagentoHackathon\Toolbar;

use DebugBar\DebugBar;
use DebugBar\DataCollector\DataCollectorInterface;
use Magento\Framework\UrlInterface;
use Magento\Framework\Controller\Result\Json;
use Magento\Framework\App\Request\Http as HttpRequest;
use Magento\Framework\App\Response\Http as HttpResponse;
use MagentoHackathon\Toolbar\Provider\StateProvider;
use MagentoHackathon\Toolbar\Storage\FilesystemStorage;
use Magento\Framework\App\State;

class Toolbar extends DebugBar
{
    /** @var  HttpRequest */
    protected $request;

    /** @var  UrlInterface */
    protected $url;

    /** @var  StateProvider */
    protected $state;

    /** @var State  */
    protected $appState;

    /**
     * Toolbar constructor.
     *
     * @param UrlInterface $url
     * @param FilesystemStorage $storage
     */
    public function __construct(
        UrlInterface $url,
        FilesystemStorage $storage,
        StateProvider $state,
        State $appState
    ) {
        $this->url = $url;
        $this->state = $state;
        $this->appState = $appState;
        $this->setStorage($storage);
    }

    /**
     * @param DataCollectorInterface $collector
     * @return bool
     */
    public function shouldCollectorRun(DataCollectorInterface $collector)
    {
        return $this->state->shouldCollectorRun($collector);
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
     * Adds a message to the MessagesCollector
     *
     * A message can be anything from an object to a string
     *
     * @param mixed $message
     * @param string $label
     */
    public function addMessage($message, $label = 'info')
    {
        if ($this->hasCollector('messages')) {
            /** @var \MagentoHackathon\Toolbar\DataCollector\MessagesCollector $collector */
            $collector = $this->getCollector('messages');
            $collector->addMessage($message, $label);
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
        $this->jsRenderer = new JavascriptRenderer($this, $this->url);
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
        $this->jsRenderer->setOpenHandlerUrl($this->url->getUrl('hackathon_toolbar/openhandler/handle'));
        $this->jsRenderer->setBindAjaxHandlerToXHR(true);

        return $this->jsRenderer;
    }

    /**
     * @param HttpResponse $response
     */
    public function modifyResponse(HttpResponse $response)
    {
        if ( ! $this->state->shouldToolbarRun()) {
            // Don't collect or store on internal routes
            return;
        } elseif ($response->isRedirect()) {
            // On redirects, stack the data for the next request
            $this->stackData();
        } elseif ($this->state->isAjaxRequest() || $response instanceof Json) {
            // On XHR requests, send the header so it can be shown by the active toolbar
            $this->sendDataInHeaders(true);
        } elseif($this->state->isToolbarVisible()) {
            // Inject the Toolbar into the HTML
            $this->appState->emulateAreaCode('frontend', function() use($response) {
                $this->injectToolbar($response);
            });
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
