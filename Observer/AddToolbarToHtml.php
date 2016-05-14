<?php
namespace MagentoHackathon\Toolbar\Observer;

use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\App\Response\Http;

class AddToolbarToHtml implements ObserverInterface
{
    protected $logger;

    public function __construct(\Psr\Log\LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        // @todo: Add configuration to switch off the toolbar
        // @todo: Fetch the root block and add the toolbar block to it
        $event = $observer->getEvent();

        /** @var Http $response */
        $response = $event->getResponse();
        $body = $response->getBody();
        $body = str_replace('</body>', $this->getToolbarHtml() . '</body>', $body);
        $response->setBody($body);
    }

    protected function getToolbarHtml()
    {
        return 'this is awesome';
    }
}
