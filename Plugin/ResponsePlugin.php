<?php
namespace MagentoHackathon\Toolbar\Plugin;

class ResponsePlugin
{
    public function beforeSendResponse(\Magento\Framework\App\ResponseInterface $response)
    {
        $body = $response->getBody();
        $body = str_replace('</body>', $this->getToolbarHtml() . '</body>', $body);
        $response->setBody($body);
    }

    protected function getToolbarHtml()
    {
        return 'this is awesome';
    }
}