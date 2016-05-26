<?php

namespace MagentoHackathon\Toolbar\DataCollector;

use DebugBar\DataCollector\DataCollector;
use DebugBar\DataCollector\Renderable;
use Magento\Framework\AppInterface;
use Magento\Framework\Locale\ResolverInterface;
use Magento\Framework\App\ProductMetadataInterface;

class MagentoCollector extends DataCollector implements Renderable
{
    /** @var ProductMetadataInterface  */
    protected $productMetadata;

    /** @var ResolverInterface */
    protected $resolver;

    /**
     * @param ProductMetadataInterface $productMetadata
     * @param ResolverInterface $localeResolver
     */
    public function __construct(
        ProductMetadataInterface $productMetadata,
        ResolverInterface $localeResolver
    ) {
        $this->productMetadata = $productMetadata;
        $this->resolver = $localeResolver;
    }

    /**
     * {@inheritDoc}
     */
    public function collect()
    {
        return array(
            "version" => $this->productMetadata->getVersion(),
            "locale" => $this->resolver->getLocale(),
        );
    }

    /**
     * {@inheritDoc}
     */
    public function getName()
    {
        return 'magento';
    }

    /**
     * {@inheritDoc}
     */
    public function getWidgets()
    {
        return array(
            "version" => array(
                "icon" => "github",
                "tooltip" => "Version",
                "map" => "magento.version",
                "default" => ""
            ),
            "locale" => array(
                "icon" => "flag",
                "tooltip" => "Current locale",
                "map" => "magento.locale",
                "default" => "",
            ),
        );
    }
}