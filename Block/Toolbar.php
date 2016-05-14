<?php

namespace MagentoHackathon\Toolbar\Block;

use Magento\Framework\View\Element\Template;

/**
 * Toolbar Block
 */
class Toolbar extends Template
{
    /**
     * Constructor
     *
     * @param Template\Context $context
     * @param array $data
     */
    public function __construct(
        Template\Context $context,
        array $data = [])
    {
        parent::__construct($context, $data);
        $this->setTemplate('toolbar/toolbar.phtml');
    }
}
