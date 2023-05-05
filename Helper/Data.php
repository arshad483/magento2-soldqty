<?php
/**
 * UltraPlugin
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the ultraplugin.com license that is
 * available through the world-wide-web at this URL:
 * https://ultraplugin.com/end-user-license-agreement
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * version in the future.
 *
 * @category    UltraPlugin
 * @package     Ultraplugin_SoldQty
 * @copyright   Copyright (c) UltraPlugin (https://ultraplugin.com/)
 * @license     https://ultraplugin.com/end-user-license-agreement
 */

namespace Ultraplugin\SoldQty\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Framework\Registry;
use Magento\Framework\UrlInterface;
use Magento\Store\Model\ScopeInterface;
use Magento\Store\Model\StoreManagerInterface;

class Data extends AbstractHelper
{
    /**
     * Config paths
     */
    protected const XML_PATH_SOLD_QTY_ENABLED = 'soldleftqty/sold_qty/enabled';
    protected const XML_PATH_SOLD_QTY_LABEL = 'soldleftqty/sold_qty/label';
    protected const XML_PATH_SOLD_QTY_MULTIPLIER = 'soldleftqty/sold_qty/multiplier';
    protected const XML_PATH_SOLD_QTY_DISPLAY_AFTER = 'soldleftqty/sold_qty/display_after';
    protected const XML_PATH_SOLD_QTY_ICON = 'soldleftqty/sold_qty/icon';
    protected const XML_PATH_SOLD_QTY_STYLE = 'soldleftqty/sold_qty/style';
    protected const XML_PATH_LEFT_QTY_ENABLED = 'soldleftqty/left_qty/enabled';
    protected const XML_PATH_LEFT_QTY_LABEL = 'soldleftqty/left_qty/label';
    protected const XML_PATH_LEFT_QTY_DISPLAY_AFTER = 'soldleftqty/left_qty/display_after';
    protected const XML_PATH_LEFT_QTY_ICON = 'soldleftqty/left_qty/icon';
    protected const XML_PATH_LEFT_QTY_STYLE = 'soldleftqty/left_qty/style';

    /**
     * @var Registry
     */
    protected $registry;

    /**
     * @var StoreManagerInterface
     */
    protected $storeManager;

    /**
     * @param Context $context
     * @param Registry $registry
     * @param StoreManagerInterface $storeManager
     */
    public function __construct(
        Context $context,
        Registry $registry,
        StoreManagerInterface $storeManager
    ) {
        $this->registry = $registry;
        $this->storeManager = $storeManager;
        parent::__construct($context);
    }

    /**
     * Get config value
     *
     * @param string $path
     * @return mixed
     */
    public function getConfig($path)
    {
        return $this->scopeConfig->getValue(
            $path,
            ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * Get current product
     *
     * @return mixed|null
     */
    public function getProduct()
    {
        return $this->registry->registry('current_product');
    }

    /**
     * Check if sold qty enabled
     *
     * @return bool
     */
    public function isSoldQtyEnabled()
    {
        return $this->scopeConfig->isSetFlag(self::XML_PATH_SOLD_QTY_ENABLED);
    }

    /**
     * Check if left qty enabled
     *
     * @return bool
     */
    public function isLeftQtyEnabled()
    {
        return $this->scopeConfig->isSetFlag(self::XML_PATH_LEFT_QTY_ENABLED);
    }

    /**
     * Get sold qty label
     *
     * @return string
     */
    public function getSoldQtyLabel()
    {
        return $this->getConfig(self::XML_PATH_SOLD_QTY_LABEL);
    }

    /**
     * Get left qty label
     *
     * @return string
     */
    public function getLeftQtyLabel()
    {
        return $this->getConfig(self::XML_PATH_LEFT_QTY_LABEL);
    }

    /**
     * Get sold qty icon url
     *
     * @return string
     */
    public function getSoldQtyIcon()
    {
        try {
            $iconUrl = '';
            $icon = $this->getConfig(self::XML_PATH_SOLD_QTY_ICON);
            if ($icon) {
                $mediaUrl = $this->storeManager->getStore()->getBaseUrl(UrlInterface::URL_TYPE_MEDIA);
                $iconUrl = $mediaUrl . 'soldqty/' . $icon;
            }
        } catch (\Exception $e) {
            $iconUrl = '';

        }
        return $iconUrl;
    }

    /**
     * Get left qty icon url
     *
     * @return string
     */
    public function getLeftQtyIcon()
    {
        try {
            $iconUrl = '';
            $icon = $this->getConfig(self::XML_PATH_LEFT_QTY_ICON);
            if ($icon) {
                $mediaUrl = $this->storeManager->getStore()->getBaseUrl(UrlInterface::URL_TYPE_MEDIA);
                $iconUrl = $mediaUrl . 'soldqty/' . $icon;
            }
        } catch (\Exception $e) {
            $iconUrl = '';
        }
        return $iconUrl;
    }

    /**
     * Get sold qty css style
     *
     * @return string
     */
    public function getSoldQtyStyle()
    {
        return $this->getConfig(self::XML_PATH_SOLD_QTY_STYLE);
    }

    /**
     * Get left qty css style
     *
     * @return string
     */
    public function getLeftQtyStyle()
    {
        return $this->getConfig(self::XML_PATH_LEFT_QTY_STYLE);
    }

    /**
     * Get sold qty multiplier
     *
     * @return mixed
     */
    public function getSoldQtyMultiplier()
    {
        return $this->getConfig(self::XML_PATH_SOLD_QTY_MULTIPLIER);
    }

    /**
     * Get sold qty for display after restriction
     *
     * @return mixed
     */
    public function getSoldQtyDisplayAfterQty()
    {
        return $this->getConfig(self::XML_PATH_SOLD_QTY_DISPLAY_AFTER);
    }

    /**
     * Get left qty for display after restriction
     *
     * @return mixed
     */
    public function getLeftQtyDisplayAfterQty()
    {
        return $this->getConfig(self::XML_PATH_LEFT_QTY_DISPLAY_AFTER);
    }

    /**
     * Get website code
     *
     * @return string
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getWebsiteCode()
    {
        return $this->storeManager->getWebsite()->getCode();
    }
}
