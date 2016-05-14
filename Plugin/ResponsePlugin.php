<?php
namespace MagentoHackathon\Toolbar\Plugin;

use Magento\Framework\App\ResponseInterface;
use Magento\Framework\View\LayoutInterface;
use MagentoHackathon\Toolbar\Api\RequestDataInterface;

/**
 * Plugin to add Toolbar to the Response add the
 * end of the body
 */
class ResponsePlugin
{
    /**
     * Layout
     *
     * @var LayoutInterface
     */
    protected $layout;

    /**
     * RequestData
     *
     * @var RequestDataInterface
     */
    protected $requestData;

    /**
     * Constructor
     *
     * @param LayoutInterface $layout
     * @param RequestDataInterface $requestData
     */
    public function __construct(
        LayoutInterface $layout,
        RequestDataInterface $requestData
    )
    {
        $this->layout = $layout;
        $this->requestData = $requestData;
    }

    /**
     * Add our toolbar to the response
     *
     * @param ResponseInterface $response
     */
    public function beforeSendResponse(ResponseInterface $response)
    {
        $this->requestData->collect();

        $body = $response->getBody();
        if (stripos($body, '</body>') === false) {
            return;
        }

        $body = str_ireplace('</body>', $this->getToolbarHtml() . '</body>', $body);
        $response->setBody($body);
    }

    /**
     * Get HTML for Toolbar
     *
     * @return string
     */
    protected function getToolbarHtml()
    {
        $block = $this->layout->createBlock(
            'MagentoHackathon\Toolbar\Block\Toolbar',
            'hackathon-toolbar',
            [
                'request_data' => $this->requestData
            ]
        );
        return $block->toHtml();
    }
}
