<?php

namespace request;

class OrderRequest extends Request
{
    public function __construct(
        string $address,
        string $phone,
        string $cardNumber
    )
    {
        parent::__construct(
            "POST",
            "/checkout",
            ["Content-Type: application/x-www-form-urlencoded"],
            ["address" => $address, "phone" => $phone, "cardNumber" => $cardNumber]
        );
    }

    public function getAddress(): string
    {
        return $this->getBody()["address"];
    }

    public function getPhone(): string
    {
        return $this->getBody()["phone"];
    }

    public function getCardNumber(): string
    {
        return $this->getBody()["cardNumber"];
    }
}