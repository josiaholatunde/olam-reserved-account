<?php

namespace Teamapt\Monnify\Api\Data;

interface ReservedAccountDetailsResponse
{
    /**
    * @return string
    */
   public function getBankAccountName();

    /**
     * @return string
     */
    public function getBankAccountNumber();

     /**
     * @return string
     */
    public function getAccountReference();

     /**
     * @return string
     */
    public function getBankName();

     /**
     * @return string
     */
    public function getBankCode();

     /**
     * @return string
     */
    public function getCustomerEmail();

    /**
     * @return string
     */
    public function getCustomerName();
}

