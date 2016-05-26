<?php
namespace MagentoHackathon\Toolbar\Plugin;

use Magento\Framework\App\ResponseInterface;
use Magento\Framework\View\LayoutInterface;
use MagentoHackathon\Toolbar\Toolbar;

/**
 * Plugin to add Toolbar to the Response add the
 * end of the body
 */
class ResponsePlugin
{
    /**
     * Constructor
     *
     * @param Toolbar $toolbar
     */
    public function __construct(Toolbar $toolbar)
    {
        $this->toolbar = $toolbar;
    }

    /**
     * Add our toolbar to the response
     *
     * @param ResponseInterface $response
     */
    public function beforeSendResponse(ResponseInterface $response)
    {
        $this->toolbar->modifyResponse($response);
    }

}
