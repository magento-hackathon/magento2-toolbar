<?php

namespace MagentoHackathon\Toolbar;

use DebugBar\JavascriptRenderer as BaseJavascriptRenderer;
use MagentoHackathon\Toolbar\Helper\Data as Helper;
use Magento\Framework\UrlInterface;

class JavascriptRenderer extends BaseJavascriptRenderer
{
    /** @var  UrlInterface */
    protected $url;

    public function __construct(Toolbar $debugBar, UrlInterface $url)
    {
        $this->url = $url;

        parent::__construct($debugBar);
    }

    /**
     * Renders the html to include needed assets
     *
     * @return string
     */
    public function renderHead()
    {
        $cssUrl = $this->url->getUrl('hackathon_toolbar/assets/css?v=' . $this->getAssetsHash('css'));
        $jsUrl = $this->url->getUrl('hackathon_toolbar/assets/js?v=' . $this->getAssetsHash('js'));

        $html  = "<link rel='stylesheet' type='text/css' property='stylesheet' href='{$cssUrl}'>";
        $html .= "<script type='text/javascript' src='{$jsUrl}'></script>";

        return $html;
    }

    /**
     * Get the hash of the included assets, based on filename and modified time.
     *
     * @param string $type 'js' or 'css'
     * @return string
     */
    protected function getAssetsHash($type)
    {
        $assets = [];
        foreach ($this->getAssets($type) as $file) {
            $assets[$file] = filemtime($file);
        }
        return md5(serialize($assets));
    }
}