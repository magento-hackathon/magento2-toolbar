<?php
namespace MagentoHackathon\Toolbar\Block;

class Toolbar extends \Magento\Framework\View\Element\AbstractBlock
{
    /**
     * Constructor
     *
     * @param \Magento\Framework\View\Element\Context $context
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Context $context,
        array $data = []
    ) {
        return parent::__construct($context, $data);
    }
}
