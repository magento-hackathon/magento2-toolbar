# magento2-toolbar
Toolbar with developer and merchant functionality

# Overview
Goal is to create an extendible toolbar within Magento 2.
The toolbar is displayed on both frontend and
backend, and contains useful information for both developers and
merchants.

The work is going to be loosely based upon the following module:
https://github.com/vpietri/magento2-developer-quickdevbar/
So many thanks to @vpietri for providing the ground work, 
mainly on the presentation level.

Instead of extending from his extension, we have decided to create
a new module, stripped down from all features: The empty toolbar (this module).
Yet other modules can be created to add information to this toolbar.

# Possible tabs
- Observer and events
- Plugin and interceptor (see [magento2-plugin-visualization](https://github.com/magento-hackathon/magento2-plugin-visualization))
- Edit link (in backend) on various frontend pages
