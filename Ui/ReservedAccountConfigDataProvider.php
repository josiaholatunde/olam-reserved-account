<?php

namespace Teamapt\Monnify\Ui;

use Magento\Ui\DataProvider\AbstractDataProvider;

class ReservedAccountConfigDataProvider extends AbstractDataProvider
{
    protected $collection;

    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        $collectionFactory,
        array $meta = [],
        array $data = []
    ) {
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
        $this->collection = $collectionFactory->create();
    }

    public function getData()
    {
        $result = [];
        foreach ($this->collection->getItems() as $config) {
            $result[$config->getId()]['general'] = $config->getData();
        }
        return $result;
    }
}