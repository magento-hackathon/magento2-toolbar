<?php

namespace MagentoHackathon\Toolbar;

use DebugBar\DebugBar;
use DebugBar\JavascriptRenderer;
use DebugBar\DataCollector\ExceptionsCollector;
use DebugBar\DataCollector\MemoryCollector;
use DebugBar\DataCollector\MessagesCollector;
use DebugBar\DataCollector\PhpInfoCollector;
use DebugBar\DataCollector\RequestDataCollector;
use DebugBar\DataCollector\TimeDataCollector;
use Magento\Framework\App\Response\Http;
use Magento\Framework\View\Asset\Repository as AssetRepository;
use MagentoHackathon\Toolbar\DataCollector\EventDataCollector;

class Toolbar extends DebugBar
{
    /**
     * @var AssetRepository
     */
    protected $assetRepo;

    /**
     * Toolbar constructor.
     * @param AssetRepository $assetRepo
     */
    public function __construct(AssetRepository $assetRepo) {
        $this->assetRepo = $assetRepo;

        // Add the default collectors
        $this->addCollector(new PhpInfoCollector());
        $this->addCollector(new MessagesCollector());
        $this->addCollector(new RequestDataCollector());
        $this->addCollector(new TimeDataCollector());
        $this->addCollector(new MemoryCollector());
        $this->addCollector(new ExceptionsCollector());
    }

    /**
     * Returns a JavascriptRenderer for this instance
     *
     * @param string $baseUrl
     * @param string $basePath
     * @return JavascriptRenderer
     */
    public function getJavascriptRenderer($baseUrl = null, $basePath = null)
    {
        if ($this->jsRenderer === null) {
            $baseUrl = $this->assetRepo->getUrlWithParams('MagentoHackathon_Toolbar', []);
            $basePath = __DIR__ . '/../view/base/web';
            $this->jsRenderer = new JavascriptRenderer($this, $baseUrl . '/debugbar', $basePath . '/debugbar');

            $this->jsRenderer->addAssets([
                'toolbar.css',
            ], [], $basePath, $baseUrl);
        }

        return $this->jsRenderer;
    }

    /**
     * @param Http $response
     */
    public function modifyResponse(Http $response)
    {
        $this->collect();

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

        $pos = strripos($content, '</head>');
        if (false !== $pos) {
            $renderedHead = $renderer->renderHead();
            $content = substr($content, 0, $pos) . $renderedHead . substr($content, $pos);
        } else {
            return; // Not correct HTML
        }

        $pos = strripos($content, '</body>');
        if (false !== $pos) {
            $renderedContent = $renderer->render();
            $content = substr($content, 0, $pos) . $renderedContent . substr($content, $pos);
        } else {
            return; // Not correct HTML
        }

        $response->setBody($content);
    }
}