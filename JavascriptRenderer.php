<?php

namespace MagentoHackathon\Toolbar;

use DebugBar\JavascriptRenderer as BaseJavascriptRenderer;

class JavascriptRenderer extends BaseJavascriptRenderer
{
    /**
     * Renders the html to include needed assets
     *
     * @return string
     */
    public function renderHead()
    {
        $cssUrl = $this->baseUrl . 'assets/css?' . $this->getAssetsHash('css');
        $jsUrl = $this->baseUrl . 'assets/js?' . $this->getAssetsHash('js');

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