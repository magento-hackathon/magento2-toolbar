<?php

if ( ! function_exists('toolbar')) {

    /**
     * @return MagentoHackathon\Toolbar\Toolbar
     */
    function toolbar()
    {
        /** @var \MagentoHackathon\Toolbar\Toolbar $toolbar */
        $toolbar = \Magento\Framework\App\ObjectManager::getInstance()
            ->get(\MagentoHackathon\Toolbar\Toolbar::class);

        return $toolbar;
    }
}

if ( ! function_exists('debug')) {

    /**
     * @param mixed ...$args
     * @return void
     */
    function debug(...$args)
    {
        /** @var \MagentoHackathon\Toolbar\Toolbar $toolbar */
        $toolbar = \Magento\Framework\App\ObjectManager::getInstance()
            ->get(\MagentoHackathon\Toolbar\Toolbar::class);

        foreach ($args as $value) {
            $toolbar->addMessage($value);
        }
    }
}
