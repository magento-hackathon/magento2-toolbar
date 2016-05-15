<?php

namespace MagentoHackathon\Toolbar\Controller\Assets;

class Js extends Base
{
    public function execute()
    {
        return $this->createResponse('text/javascript', function(){
            $this->toolbar->getJavascriptRenderer()->dumpJsAssets();
        });
    }
}