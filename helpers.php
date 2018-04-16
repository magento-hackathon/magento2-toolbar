<?php

if ( ! function_exists('toolbar')) {

    /**
     * @param mixed|null ...$args
     * @return MagentoHackathon\Toolbar\Toolbar
     */
    function toolbar($args = null)
    {
        /** @var \MagentoHackathon\Toolbar\Toolbar $toolbar */
        $toolbar = \Magento\Framework\App\ObjectManager::getInstance()
            ->get(\MagentoHackathon\Toolbar\Toolbar::class);

        foreach (func_get_args() as $value) {
            $toolbar->addMessage($value);
        }

        return $toolbar;
    }
}
