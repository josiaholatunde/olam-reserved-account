<?php

namespace Teamapt\Monnify\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class ReservedAccountConfig extends AbstractDb
{
    protected function _construct()
    {
        $this->_init('reserved_account_config', 'id');
    }
}