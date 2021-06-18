<?php

namespace Teamapt\Monnify\Controller\Adminhtml\Config\Index;

use Magento\Framework\Controller\ResultFactory;

class Index extends \Magento\Backend\App\Action
{
    public function execute()
    {
        $resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);
        $resultPage->getConfig()->getTitle()->prepend((__('Reserved Account')));
        return $resultPage;
    }
}
