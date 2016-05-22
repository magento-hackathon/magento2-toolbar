<?php

namespace MagentoHackathon\Toolbar;

use DebugBar\JavascriptRenderer as BaseJavascriptRenderer;
use MagentoHackathon\Toolbar\Helper\Data as Helper;

class JavascriptRenderer extends BaseJavascriptRenderer
{
    /** @var  Helper */
    protected $helper;

    public function __construct(Toolbar $debugBar, Helper $helper)
    {
        $this->helper = $helper;

        parent::__construct($debugBar);
    }

    /**
     * Renders the html to include needed assets
     *
     * @return string
     */
    public function renderHead()
    {
        $cssUrl = $this->helper->getUrl('assets/css?v=' . $this->getAssetsHash('css'));
        $jsUrl = $this->helper->getUrl('assets/js?v=' . $this->getAssetsHash('js'));

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