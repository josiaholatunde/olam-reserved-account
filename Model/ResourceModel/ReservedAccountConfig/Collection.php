<?php
namespace Teamapt\Monnify\Model\ResourceModel\ReservedAccountConfig;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Teamapt\Monnify\Model\ReservedAccountConfig;
use Teamapt\Monnify\Model\ResourceModel\ReservedAccountConfig as ReservedAccountConfigResource;

class Collection extends AbstractCollection
{
    protected $_idFieldName = 'id';

    protected function _construct()
    {
        $this->_init(ReservedAccountConfig::class, ReservedAccountConfigResource::class);
    }
}