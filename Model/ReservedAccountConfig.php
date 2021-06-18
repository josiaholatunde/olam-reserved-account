<?php

namespace Teamapt\Monnify\Model;

use Magento\Framework\Model\AbstractModel;

class ReservedAccountConfig extends AbstractModel
{
    const IS_ACTIVE = 'is_active';
    const ENTITY_ID = 'id';

    protected function _construct()
    {
        $this->_init(\Teamapt\Monnify\Model\ResourceModel\ReservedAccountConfig::class);
    }

    public function setIsActive($isActive) {
        $this->setData(self::IS_ACTIVE, $isActive);
    }

    public function setId($id) {
        $this->setData(self::ENTITY_ID, $id);
    }
}