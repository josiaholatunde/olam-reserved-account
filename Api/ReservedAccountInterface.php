<?php
namespace Teamapt\Monnify\Api;;

interface ReservedAccountInterface {

    /**
     * Create reserved account
     * @return Teamapt\Monnify\Api\Data\ReservedAccountResponse
     */
    public function createReservedAccount();
}