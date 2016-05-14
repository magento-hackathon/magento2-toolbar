<?php
namespace MagentoHackathon\Toolbar\Plugin;

class ResponsePlugin
{
    protected $layout;

    public function __construct(
        \Magento\Framework\View\LayoutInterface $layout
    )
    {
        $this->layout = $layout;
    }

    public function beforeSendResponse(\Magento\Framework\App\ResponseInterface $response)
    {
        $body = $response->getBody();
        $body = str_replace('</body>', $this->getToolbarHtml() . '</body>', $body);
        $response->setBody($body);
    }

    protected function getToolbarHtml()
    {
        $block = $this->layout->createBlock('MagentoHackathon\Toolbar\Block\Toolbar');
        return $block->toHtml();
    }
}