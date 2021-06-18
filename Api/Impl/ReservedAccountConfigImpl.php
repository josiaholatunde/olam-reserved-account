<?php

namespace Teamapt\Monnify\Api\Impl;

use Magento\Framework\App\Action\Context;
use Teamapt\Monnify\Api\ReservedAccountConfigInterface;
use Teamapt\Monnify\Model\ReservedAccountConfigFactory;
use Teamapt\Monnify\Model\ResourceModel\ReservedAccountConfig\CollectionFactory;

class ReservedAccountConfigImpl implements ReservedAccountConfigInterface
{
    private $reservedAccountConfigFactory;
    private $itemFactory;

    /* @param \Magento\Framework\App\Action\Context $context
    * 
    */
    public function __construct(Context $context,
    CollectionFactory $reservedAccountConfigFactory) {
        $this->reservedAccountConfigFactory = $reservedAccountConfigFactory;
    }

    public function getActiveConfig()
    {
        $collectionFactory = $this->reservedAccountConfigFactory->create();
        $collection = $collectionFactory->addFieldToFilter('is_active', ['eq' => 1]);
       return $collection;
    }
}
