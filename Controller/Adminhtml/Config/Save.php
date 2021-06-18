<?php

namespace Teamapt\Monnify\Controller\Adminhtml\Config;

use Teamapt\Monnify\Model\ReservedAccountConfigFactory;

class Save extends \Magento\Backend\App\Action
{
    private $reservedAccountConfigFactory;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        ReservedAccountConfigFactory $reservedAccountConfigFactory
    ) {
        $this->reservedAccountConfigFactory = $reservedAccountConfigFactory;
        parent::__construct($context);
    }

    public function execute()
    {
        $this->reservedAccountConfigFactory->create()
            ->setData($this->getRequest()->getPostValue()['general'])
            ->save();
        return $this->resultRedirectFactory->create()->setPath('reserved_account/index/index');
    }
}
