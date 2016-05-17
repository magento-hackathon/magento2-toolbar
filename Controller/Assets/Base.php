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

        // Add cache headers
        $date =  new \DateTime('+1 year');
        $date->setTimezone(new \DateTimeZone('UTC'));
        $result->setHeader('expires', $date->format('D, d M Y H:i:s').' GMT');
        $result->setHeader('shared-max-age', 31536000);
        $result->setHeader('max-age', 31536000);
        $result->setHeader('cache-control', 'public');
        $result->setHeader('pragma', 'cache');


        // Run the callback, catch the echo'd output to create the response
        ob_start();
        $callback();
        $result->setContents(ob_get_contents());
        ob_end_clean();

        return $result;
    }
}