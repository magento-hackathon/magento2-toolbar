<?php

namespace MagentoHackathon\Toolbar\Controller\OpenHandler;

use MagentoHackathon\Toolbar\Toolbar;
use DebugBar\OpenHandler;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\Result\Raw;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Controller\ResultInterface;

class Handle extends Action
{
    /** @var Toolbar  */
    protected $toolbar;

    public function __construct(Context $context, Toolbar $toolbar)
    {
        $this->toolbar = $toolbar;

        parent::__construct($context);
    }

    /**
     * Dispatch request
     *
     * @return \Magento\Framework\Controller\ResultInterface|ResponseInterface
     * @throws \Magento\Framework\Exception\NotFoundException
     */
    public function execute()
    {
        /** @var Raw $result */
        $result = $this->resultFactory->create(ResultFactory::TYPE_RAW);
        $result->setHeader('content-type', 'application/json');

        $openHandler = new OpenHandler($this->toolbar);
        $data = $openHandler->handle(null, false, false);

        $result->setContents($data);

        return $result;
    }
}