<?php

namespace MagentoHackathon\Toolbar\Controller\Assets;

class Css extends Base
{
    public function execute()
    {
        return $this->createResponse('text/css', function(){
            $this->toolbar->getJavascriptRenderer()->dumpCssAssets();
        });
    }
}