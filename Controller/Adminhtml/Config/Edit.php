<?php

namespace Teamapt\Monnify\Controller\Adminhtml\Config;

use Teamapt\Monnify\Model\ReservedAccountConfigFactory;
use Teamapt\Monnify\Api\ReservedAccountConfigInterface;


class Edit extends \Magento\Backend\App\Action
{
    private $reservedAccountConfigFactory;
    private $config;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        ReservedAccountConfigFactory $reservedAccountConfigFactory,
        ReservedAccountConfigInterface $configInterface
    ) {
        $this->reservedAccountConfigFactory = $reservedAccountConfigFactory;
        $this->config = $configInterface;
        parent::__construct($context);
    }

    public function execute()
    {
        $rowId = (int) $this->getRequest()->getParam('id');
        $factory = $this->reservedAccountConfigFactory->create();
        if ($rowId) {
            $previouslyActiveConfig = $this->config->getActiveConfig();
            foreach($previouslyActiveConfig->getData() as &$config) {
                $this->updateEntityActiveStatus($factory, $config['id'], 0);
            }
            $this->updateEntityActiveStatus($factory, $rowId, 1);
            $this->messageManager->addSuccess(__('Config has been successfully updated.'));
        } else {
            $this->messageManager->addError(__('Entity does not exist'));
        }
        return $this->resultRedirectFactory->create()->setPath('reserved_account/index/index');
    }

    private function updateEntityActiveStatus($factory, $entityId, $isActive) {
        $currentData = $factory->load($entityId);
        $currentData->setIsActive($isActive);
        $currentData->setId($entityId);
        $currentData->save();
    }
}
