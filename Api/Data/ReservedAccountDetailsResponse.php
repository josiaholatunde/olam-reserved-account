<?php

namespace Teamapt\Monnify\Api\Data;

interface ReservedAccountDetailsResponse
{
    /**
     * @return string
     */
    public function getContractCode();

    /**
     * @return string
     */
    public function getCurrencyCode();

     /**
     * @return string
     */
    public function getAccountReference();
}
