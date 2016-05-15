# magento2-toolbar
Toolbar with developer and merchant functionality

# Overview
Goal is to create an extendible toolbar within Magento 2.
The toolbar is displayed on both frontend and
backend, and contains useful information for both developers and
merchants.

The toolbar is based on https://github.com/maximebf/php-debugbar

Instead of extending from his extension, we have decided to create
a new module, stripped down from all features: The empty toolbar (this module).
Yet other modules can be created to add information to this toolbar.

# Possible tabs
- Observer and events
- Plugin and interceptor (see [magento2-plugin-visualization](https://github.com/magento-hackathon/magento2-plugin-visualization))
- Edit link (in backend) on various frontend pages
