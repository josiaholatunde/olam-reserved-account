<?php

namespace Teamapt\Monnify\Api\Data;

interface ReservedAccountConfigInterface
{
    /**
     * @return string
     */
    public function getApiKey();

    /**
     * @return string|null
     */
    public function getApiSecret();
}
