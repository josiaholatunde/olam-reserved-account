<?php

namespace Teamapt\Monnify\Api\Data\Impl;

use Teamapt\Monnify\Api\Data\ReservedAccountDetailsResponse;

class ReservedAccountDetailsResponseImpl implements ReservedAccountDetailsResponse
{

    private $bankAccountName;
    private $bankAccountNumber;
    private $accountReference;
    private $bankName;
    private $bankCode;
    private $customerName;
    private $customerEmail;

    public function __construct($bankAccountName, $bankAccountNumber, $accountReference, $bankName, $bankCode,
    $customerName, $customerEmail)
    {
       $this->bankAccountName = $bankAccountName;
       $this->bankAccountNumber = $bankAccountNumber;
       $this->accountReference = $accountReference;
       $this->bankName = $bankName;
       $this->bankCode = $bankCode;
       $this->customerEmail = $customerEmail;
       $this->customerName = $customerName; 
    }

    /**
     * @return string
     */
    public function getBankAccountName() {
        return $this->bankAccountName;
    }

    /**
     * @return string
     */
    public function getBankAccountNumber() {
        return $this->bankAccountNumber; 
    }

     /**
     * @return string
     */
    public function getAccountReference() {
        return $this->accountReference;  
    }

    /**
     * @return string
     */
    public function getBankName() {
        return $this->bankName;  
    }

    /**
     * @return string
     */
    public function getBankCode() {
        return $this->bankCode;  
    }

    /**
     * @return string
     */
    public function getCustomerName() {
        return $this->customerName;  
    }

     /**
     * @return string
     */
    public function getCustomerEmail() {
        return $this->customerEmail;  
    }
}

