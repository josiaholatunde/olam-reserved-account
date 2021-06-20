<?php
namespace Teamapt\Monnify\Api\Data\Impl;

use Teamapt\Monnify\Api\Data\ReservedAccountResponse;

class ReservedAccountResponseImpl implements ReservedAccountResponse {

    private $requestSuccessful;
    private $data;
    private $message;

    public function __construct($requestSuccessful, $data, $message) {
        $this->requestSuccessful = $requestSuccessful;
        $this->data = $data;
        $this->message = $message;
    }

    public function getRequestSuccessful() {
        return $this->requestSuccessful;
    }

    public function getData() {
        return $this->data == null ? null : new ReservedAccountDetailsResponseImpl($this->data['bankAccountName'],
        $this->data['bankAccountNumber'], $this->data['accountReference'],$this->data['bankName'],
        $this->data['bankCode'],$this->data['customerName'],$this->data['customerEmail']);
    }

    public function getMessage()
    {
        return $this->message;
    }

}