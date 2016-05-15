<?php

namespace MagentoHackathon\Toolbar\Block;

use DebugBar\JavascriptRenderer;
use MagentoHackathon\Toolbar\Toolbar;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Magento\Framework\View\Asset\Repository as AssetRepository;

class Head extends Template
{
    /** @var JavascriptRenderer $renderer */
    public $renderer;

    public function __construct(Context $context,
        array $data = [],
        Toolbar $toolbar,
        AssetRepository $assetRepo
    ) {
        $baseUrl = $assetRepo->getUrlWithParams('MagentoHackathon_Toolbar', []);
        $basePath = __DIR__ . '/../view/base/web';

        $this->renderer = $toolbar->getJavascriptRenderer($baseUrl . '/debugbar', $basePath . '/debugbar');
        $this->renderer->addAssets([
                'toolbar.css',
            ], [], $basePath, $baseUrl);

        parent::__construct($context, $data);
    }

}