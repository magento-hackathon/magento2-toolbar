<?php

namespace MagentoHackathon\Toolbar\Controller\Assets;

use MagentoHackathon\Toolbar\Toolbar;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\Result\Raw;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Controller\ResultInterface;

abstract class Base extends Action
{
    /** @var Toolbar  */
    protected $toolbar;

    public function __construct(Context $context, Toolbar $toolbar)
    {
        $this->toolbar = $toolbar;

        parent::__construct($context);
    }

    /**
     * @param $contentType
     * @param callable $callback
     * @return ResultInterface
     */
    protected function createResponse($contentType, callable $callback)
    {
        /** @var Raw $result */
        $result = $this->resultFactory->create(ResultFactory::TYPE_RAW);
        $result->setHeader('content-type', $contentType);

        // Run the callback, catch the echo'd output to create the response
        ob_start();
        $callback();
        $result->setContents(ob_get_contents());
        ob_end_clean();

        return $result;
    }
}