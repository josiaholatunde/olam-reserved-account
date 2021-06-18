<?php

namespace Teamapt\Monnify\Api;

interface ItemRepositoryInterface
{
    /**
     * @return \Teamapt\Monnify\Api\Data\ItemInterface[]
     */
    public function getList();
}
