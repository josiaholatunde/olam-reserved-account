<?php

namespace Teamapt\Monnify\Api\Data;

interface ReservedAccountResponse
{
    /**
     * @return boolean
     */
    public function getRequestSuccessful();

    /**
     * @return string|null
     */
    public function getMessage();

     /**
     * @return Teamapt\Monnify\Api\Data\ReservedAccountDetailsResponse|null
     */
    public function getData();

}
