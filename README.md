# Magento 2 Sold Qty And Left Qty
UltraPlugin Sold & Left Qty extension allows the store owner to show how much stock is sold and how much stock is left on the product page with an attractive by default design. The store owner can manage labels for sold and left stock. The store owner can set sold quantity multiplier to show high stock sold on the website. This can be useful to attract customers for products. The store owner can manage icons for sold and left stock. No need developer to change the design of labels, the store owner easily modifies css style from the admin. This extension allows the store owner to set limits for sold and left quantity. Stock label updated immediately after invoicing. No need to clean the cache to see the latest stock on the product page. This extension is compatible with a varnish cache.

## Features
1. Enable/disable sold quantity label
2. Easy to modify sold quantity label
3. Set quantity multiplier to show high stock sold on frontend
4. Set a custom icon for sold quantity label
5. Set sold quantity limit to hide/show sold the label
6. Easy to modify CSS for sold quantity label from admin
7. Enable/Disable left quantity label
8. Easy to modify left quantity label
9. Set a custom icon for the left quantity label
10. Set left quantity limit to hide/show left quantity label
11. Easy to modify CSS for left quantity label from admin
12. Enable/disable label for specific store

## How to install Magento 2 Sold Qty And Left Qty

### 1. Download and install from Magento Marketplace
<a href="https://marketplace.magento.com/ultraplugin-module-sold-qty.html">Magento Marketplace Link</a>

### 2. Install via composer (GitHub)
Run the following command in Magento 2 root folder:
```
composer require ultraplugin/module-sold-qty
php bin/magento setup:upgrade
php bin/magento setup:di:compile
php bin/magento setup:static-content:deploy
```

## Extension Screenshots

<img src="https://github.com/ultraplugin/module-screenshots/blob/master/sold-qty/1-frontend.jpg"/>
<img src="https://github.com/ultraplugin/module-screenshots/blob/master/sold-qty/2-admin-enable-disable.jpg"/>
<img src="https://github.com/ultraplugin/module-screenshots/blob/master/sold-qty/3-admin-label.jpg"/>
<img src="https://github.com/ultraplugin/module-screenshots/blob/master/sold-qty/4-admin-multiplier.jpg"/>
<img src="https://github.com/ultraplugin/module-screenshots/blob/master/sold-qty/5-admin-icon.jpg"/>
<img src="https://github.com/ultraplugin/module-screenshots/blob/master/sold-qty/6-admin-css.jpg"/>
