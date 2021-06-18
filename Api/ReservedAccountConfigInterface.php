<?php
namespace Teamapt\Monnify\Api;

interface ReservedAccountConfigInterface {

    /**
     * Create reserved account config
     * @return \Teamapt\Monnify\Api\Data\ReservedAccountConfigInterface
     */
    public function getActiveConfig();
}