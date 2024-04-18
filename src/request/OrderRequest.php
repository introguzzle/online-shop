<?php

namespace request;

class OrderRequest extends Request
{
    public function __construct(
        array $body
    )
    {
        parent::__construct(
            "POST",
            "/checkout",
            ["Content-Type: application/x-www-form-urlencoded"],
            $body
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
        return $this->getBody()["card-number"];
    }
}