<?php

namespace Teamapt\Monnify\Api\Impl;

use Magento\Framework\App\Action\Context;
use Teamapt\Monnify\Api\ReservedAccountInterface;
use Teamapt\Monnify\Api\ReservedAccountConfigInterface;

class MonnifyReservedAccountImpl implements ReservedAccountInterface
{
    private $apiService;
    private $config;
    /**
     * @var \Magento\Framework\Webapi\Rest\Request
     */
    protected $request;

    /* @param \Magento\Framework\App\Action\Context $context
    * @param \Magento\Framework\Webapi\Rest\Request $request
    */
    public function __construct(Context $context, \Magento\Framework\Webapi\Rest\Request $request,
    ReservedAccountConfigInterface $config,
    ApiService $apiService) {
        $this->apiService = $apiService;
        $this->request = $request;
        $this->config = $config;
    }

     /**
     * Create reserved account
     * @return Teamapt\Monnify\Api\Data\ReservedAccountResponse
     */
    public function createReservedAccount()
    {
        error_log('Request'.json_encode($this->request->getBodyParams()));
        $activeConfig = $this->config->getActiveConfig();
        $activeConfigObject = $activeConfig->getData();
        if ($activeConfigObject == null || empty($activeConfigObject)) {
            error_log("Could not find default active monnify config. Please do so using the backoffice");
            return;
        }
        return $this->apiService->createReservedAccount($this->request->getBodyParams(), $activeConfigObject[0]);
       
    }
}
