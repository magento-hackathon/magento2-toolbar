<?php

namespace MagentoHackathon\Toolbar\DataCollector;

use DebugBar\DataCollector\DataCollector;
use DebugBar\DataCollector\Renderable;
use Magento\Framework\AppInterface;
use Magento\Framework\Locale\ResolverInterface;

class MagentoCollector extends DataCollector implements Renderable
{
    /** @var ResolverInterface */
    protected $resolver;

    /**
     * @param ResolverInterface $localeResolver
     */
    public function __construct(ResolverInterface $localeResolver)
    {
        $this->resolver = $localeResolver;
    }

    /**
     * {@inheritDoc}
     */
    public function collect()
    {
        return array(
            "version" => AppInterface::VERSION,
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