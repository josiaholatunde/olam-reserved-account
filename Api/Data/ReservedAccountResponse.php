<?php

namespace Teamapt\Monnify\Api\Data;

interface ReservedAccountResponse
{
    /**
     * @return boolean
     */
    public function getRequestSuccessful();

    /**
     * @return boolean
     */
    public function setRequestSuccessful($isSuccessful);

    /**
     * @return string|null
     */
    public function getMessage();

     /**
     * @return string|null
     */
    public function setMessage($message);

     /**
     * @return Teamapt\Monnify\Api\Data\ReservedAccountDetailsResponse|null
     */
    public function getData();

    /**
     * @return Teamapt\Monnify\Api\Data\ReservedAccountDetailsResponse|null
     */
    public function setData($data);
}
