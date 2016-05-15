<?php

namespace MagentoHackathon\Toolbar\Block;

use MagentoHackathon\Toolbar\Toolbar;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Magento\Framework\View\Asset\Repository as AssetRepository;

class Components extends Template
{
    public function __construct(Context $context,
        array $data = [],
        Toolbar $toolbar,
        AssetRepository $assetRepo
    ) {
        // Link to the static assets
        $baseUrl = $assetRepo->getUrlWithParams('MagentoHackathon_Toolbar', []);
        $basePath = __DIR__ . '/../view/base/web';
        $renderer = $toolbar->getJavascriptRenderer($baseUrl . '/debugbar', $basePath . '/debugbar');

        // Add our own custom CSS
        $renderer->addAssets([
                'toolbar.css',
            ], [], $basePath, $baseUrl);

        parent::__construct($context, $data);
    }
}