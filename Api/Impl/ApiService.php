<?php
namespace Teamapt\Monnify\Api\Impl;

use Magento\Framework\HTTP\Client\Curl;
use Teamapt\Monnify\Api\Data\Impl\ReservedAccountResponseImpl;

class ApiService extends \Magento\Framework\App\Helper\AbstractHelper {

    private static $monnifySandboxBaseApiUrl = 'https://sandbox.monnify.com/api';
    private static $monnifyLiveBaseApiUrl = 'https://api.monnify.com/api';
    private $isTestMode = true;
    private static $testModeApiKeyStartString = "MK_TEST";
    private $accessToken = "";
    private $expiry = null;
    /**
     * @param \Magento\Framework\App\Helper\Context $context
     */
    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        Curl $curl
    ) {
        parent::__construct($context);
        $this->curl = $curl;
    }

    private function buildLoginHeaders($activeConfigObject) {
        $this->curl->addHeader("Content-Type", "application/json");
        $apiKey = $activeConfigObject['api_key'];
        $apiSecret = $activeConfigObject['api_secret'];
        $this->isTestMode = substr($apiKey, 0, strlen(self::$testModeApiKeyStartString)) === self::$testModeApiKeyStartString;
        $this->curl->setCredentials($apiKey, $apiSecret);
    }

    private function getBaseApiUrl() {
        return $this->isTestMode ? self::$monnifySandboxBaseApiUrl : self::$monnifyLiveBaseApiUrl; 
    }

    private function authenticate($activeConfigObject) {
        $this->buildLoginHeaders($activeConfigObject);
        $loginUrl = $this->getBaseApiUrl()."/v1/auth/login";
       try {
        $this->curl->post($loginUrl, []);
        $decodedResponse = json_decode($this->curl->getBody(), true);
        if ($decodedResponse && $decodedResponse['responseBody'] && $decodedResponse['responseBody']['accessToken']) {
            $this->accessToken = $decodedResponse['responseBody']['accessToken'];
            return $this->accessToken;
        }
        return null;
       } catch (\Exception $ex) {
           error_log('An error occurred while calling monnify authenticate service'.$ex->getMessage());
           return null;
       }
    }

    private function buildErrorResponse($message) {
        return new ReservedAccountResponseImpl(false, null, $message);
    }

    private function getFirstAccountDetailsFromResponse($data) {
        if ($data && count($data['accounts']) == 0) {
            throw new \Exception("Empty accounts response from Monnify");
        }
        return $data['accounts'][0];
    }

    private function extractRequiredResponseData($data) {
        $firstAccountDetails = $this->getFirstAccountDetailsFromResponse($data);
        return [
            'bankAccountName' => $data['accountName'],
            'bankAccountNumber' => $firstAccountDetails['accountNumber'], 
            'bankName' => $firstAccountDetails['bankName'], 
            'bankCode' => $firstAccountDetails['bankCode'],
            'accountReference' => $data['accountReference'],
            'customerName' => $data['customerName'],
            'customerEmail' => $data['customerEmail'],
        ];
    }

    private function buildSucessResponse($data) {
        $responseData = $this->extractRequiredResponseData($data);
        return  new ReservedAccountResponseImpl(true, $responseData, null);          
    }

    private function getReservedAccountDetailsIfExists($reservedAccountReference, $accessToken) {
        try {
            $this->setBearerAuthenticationHeader($accessToken);
            
            $monnifyReservedAccountApiUrl  = $this->getBaseApiUrl()."/v2/bank-transfer/reserved-accounts/$reservedAccountReference";
            $this->curl->get($monnifyReservedAccountApiUrl);
            $decodedResponse = json_decode($this->curl->getBody(), true);
            if (!!$decodedResponse && !!$decodedResponse['requestSuccessful']) {
                return $decodedResponse['responseBody'];
            } else {
                return null;
            }
        } catch (\Exception $ex) {
            $message = "An error occurred while calling monnify reserved account service ".$ex->getMessage();
            error_log($message);
            return null;
        }
    }

    /**
     * Create reserved account
     * @return \ReservedAccountResponseImpl
     */
    public function createReservedAccount(array $reservedAccountPayload, $activeConfigObject)
    {
        $accessToken = $this->authenticate($activeConfigObject);
        if (!!$accessToken) {
            try {
                $this->validateAccountReferenceInRequest($reservedAccountPayload);
                $accountReferenceSuffix = $activeConfigObject['account_reference_suffix'] ?? '';
                $accountReference = $this->deduceAccountReference($reservedAccountPayload['accountReference'], $accountReferenceSuffix);
                if ($reservedAccountDetails = $this->getReservedAccountDetailsIfExists($accountReference, $accessToken)) {
                    return $this->buildSucessResponse($reservedAccountDetails);
                } else {
                    $this->validateRequestPayloadForReservedAccount($reservedAccountPayload);
                    return $this->buildSucessResponse($this->createReservedAccountOnMonnify($reservedAccountPayload, $activeConfigObject,  $accessToken));
                } 
            } catch (\Exception $ex) {
                return $this->buildErrorResponse('One or more validation error(s) occurred. Message: '.$ex->getMessage());
            }
            
        }
        return $this->buildErrorResponse("An error occurred while authenticating with Monnify API");
    }

    private function deduceAccountReference($accountReference, $configSuffix) {
        return !empty($configSuffix) ? $accountReference.$configSuffix : $accountReference;
    }

    private function validateAccountReferenceInRequest($reservedAccountPayload) {
        $errorMessage = '';
        if (!array_key_exists('accountReference', $reservedAccountPayload) || empty(trim($reservedAccountPayload['accountReference']))) {
            $errorMessage .= 'Account Reference field is required.';
        }
        if (!!$errorMessage) {
            throw new \Exception($errorMessage);
        }
    }

    private function validateRequestPayloadForReservedAccount($reservedAccountPayload) {
        if (!array_key_exists('customerName', $reservedAccountPayload) || empty(trim($reservedAccountPayload['customerName']))) {
            $errorMessage = "Customer name field is required. ";
            throw new \Exception($errorMessage);
        }
        if (!array_key_exists('customerEmail', $reservedAccountPayload) || empty(trim($reservedAccountPayload['customerEmail']))) {
            $errorMessage = "Customer email field is required. ";
            throw new \Exception($errorMessage);
        }
        if (!array_key_exists('accountName', $reservedAccountPayload) || empty(trim($reservedAccountPayload['accountName']))) {
            $errorMessage = "Account name field is required. ";
            throw new \Exception($errorMessage);
        }
    }

    private function createReservedAccountOnMonnify($reservedAccountPayload, $activeConfigObject, $accessToken) {
        try {
            $accountReferenceSuffix = $activeConfigObject['account_reference_suffix'] ?? '';
            $accountReference = $this->deduceAccountReference($reservedAccountPayload['accountReference'], $accountReferenceSuffix);
            $params = [
                'accountReference' => $accountReference,
                'accountName' => $reservedAccountPayload['accountName'],
                'currencyCode' => 'NGN',
                "customerEmail"=> $reservedAccountPayload['customerEmail'],
                "customerName" => $reservedAccountPayload['customerName'],
                'contractCode' => $activeConfigObject['contract_code'],
                "getAllAvailableBanks" => true
            ];
            $this->setBearerAuthenticationHeader($accessToken);
            $monnifyReservedAccountApiUrl  = $this->getBaseApiUrl()."/v2/bank-transfer/reserved-accounts";
            $this->curl->post($monnifyReservedAccountApiUrl, json_encode($params));
            $decodedResponse = json_decode($this->curl->getBody(), true);
            if (!!$decodedResponse && !!$decodedResponse['requestSuccessful']) {
                return $decodedResponse['responseBody'];
            } else {
                return $this->buildErrorResponse('An error occurred while calling monnify reserved account service');
            }
        } catch (\Exception $ex) {
            return $this->buildErrorResponse('An error occurred while calling monnify reserved account service'.$ex->getMessage());
        }
    }

    private function setBearerAuthenticationHeader($accessToken) {
        $this->curl->addHeader("Content-Type", "application/json");
        $this->curl->addHeader("Authorization", "Bearer $accessToken");
    }
}