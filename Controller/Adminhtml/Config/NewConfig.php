<?php
namespace Teamapt\Monnify\Controller\Adminhtml\Config;

use Magento\Framework\Controller\ResultFactory;

class NewConfig extends \Magento\Backend\App\Action
{
    public function execute()
    {
        return $this->resultFactory->create(ResultFactory::TYPE_PAGE);
    }
}