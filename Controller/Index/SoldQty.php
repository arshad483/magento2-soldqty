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
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Reports\Model\ResourceModel\Product\Sold\CollectionFactory as SoldCollectionFactory;
use Psr\Log\LoggerInterface;
use Ultraplugin\SoldQty\Helper\Data as HelperData;

class SoldQty implements HttpPostActionInterface
{
    /**
     * @var SoldCollectionFactory
     */
    protected $soldCollectionFactory;

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
     * @param SoldCollectionFactory $soldCollectionFactory
     * @param HelperData $helper
     * @param RequestInterface $request
     * @param JsonFactory $resultJson
     * @param LoggerInterface $logger
     */
    public function __construct(
        SoldCollectionFactory $soldCollectionFactory,
        HelperData $helper,
        RequestInterface $request,
        JsonFactory $resultJson,
        LoggerInterface $logger
    ) {
        $this->soldCollectionFactory = $soldCollectionFactory;
        $this->helper = $helper;
        $this->request = $request;
        $this->resultJson = $resultJson;
        $this->logger = $logger;
    }

    /**
     * Get sold qty label
     *
     * @return \Magento\Framework\Controller\Result\Json
     */
    public function execute()
    {
        $response = ['display' => false];
        try {
            $soldQty = 0;
            $productId = $this->request->getParam('productId');
            $soldProductCollection = $this->soldCollectionFactory->create();
            $soldProductCollection
                ->addOrderedQty()
                ->addAttributeToFilter("product_id", $productId);

            if ($soldProductCollection->getSize() > 0) {
                foreach ($soldProductCollection as $soldProduct) {
                    $soldQty += $soldProduct->getOrderedQty();
                }
            }

            $qtyMultiplier = $this->helper->getSoldQtyMultiplier();
            if ($soldQty > 0 && $qtyMultiplier > 0) {
                $soldQty = $soldQty * $qtyMultiplier;
            }

            $displayAfter = $this->helper->getSoldQtyDisplayAfterQty();
            if ($soldQty > $displayAfter) {
                $label = __($this->helper->getSoldQtyLabel(), $soldQty);
                $response = ['display' => true, 'label' => $label];
            } else {
                $response = ['display' => false];
            }
        } catch (\Exception $e) {
            $message = 'SoldQty Error: ' . $e->getMessage();
            $this->logger->error($message);
        }
        $resultJson = $this->resultJson->create();
        return $resultJson->setData($response);
    }
}
