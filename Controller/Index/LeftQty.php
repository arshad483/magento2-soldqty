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

namespace Ultraplugin\SoldQty\Controller\Index;

use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\App\RequestInterface;
use Magento\InventorySalesApi\Api\GetProductSalableQtyInterface;
use Magento\InventorySalesApi\Api\StockResolverInterface;
use Magento\InventorySalesApi\Api\Data\SalesChannelInterface;
use Psr\Log\LoggerInterface;
use Ultraplugin\SoldQty\Helper\Data as HelperData;
use Magento\Framework\Controller\Result\JsonFactory;

class LeftQty implements HttpPostActionInterface
{
    /**
     * @var GetProductSalableQtyInterface
     */
    protected $salableQty;

    /**
     * @var StockResolverInterface
     */
    protected $stockResolver;

    /**
     * @var HelperData
     */
    protected $helper;

    /**
     * @var RequestInterface
     */
    protected $request;

    /**
     * @var JsonFactory
     */
    protected $resultJson;

    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * @param GetProductSalableQtyInterface $salableQty
     * @param StockResolverInterface $stockResolver
     * @param HelperData $helper
     * @param RequestInterface $request
     * @param JsonFactory $resultJson
     * @param LoggerInterface $logger
     */
    public function __construct(
        GetProductSalableQtyInterface $salableQty,
        StockResolverInterface $stockResolver,
        HelperData $helper,
        RequestInterface $request,
        JsonFactory $resultJson,
        LoggerInterface $logger
    ) {
        $this->salableQty = $salableQty;
        $this->stockResolver = $stockResolver;
        $this->helper = $helper;
        $this->request = $request;
        $this->resultJson = $resultJson;
        $this->logger = $logger;
    }

    /**
     * Get left qty label
     *
     * @return \Magento\Framework\Controller\Result\Json
     */
    public function execute()
    {
        $response = ['display' => false];
        try {
            $sku = $this->request->getParam('sku');
            $typeId = $this->request->getParam('typeId');
            if ($typeId != 'configurable' && $typeId != 'bundle' && $typeId != 'grouped') {
                $websiteCode = $this->helper->getWebsiteCode();
                $stock = $this->stockResolver->execute(SalesChannelInterface::TYPE_WEBSITE, $websiteCode);
                $stockQty = $this->salableQty->execute($sku, $stock->getStockId());
                $displayAfter = $this->helper->getLeftQtyDisplayAfterQty();
                if ($stockQty > 0 && $stockQty < $displayAfter) {
                    $label = __($this->helper->getLeftQtyLabel(), $stockQty);
                    $response = ['display' => true, 'label' => $label];
                } else {
                    $response = ['display' => false];
                }
            }
        } catch (\Exception $e) {
            $message = 'LeftQty Error: ' . $e->getMessage();
            $this->logger->error($message);
        }
        $resultJson = $this->resultJson->create();
        return $resultJson->setData($response);
    }
}
