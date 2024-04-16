<?php

namespace request;

class OrderRequest extends Request
{
    private string $address;
    private string $phone;
    private string $cardNumber;

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

        $this->address = $address;
        $this->phone = $phone;
        $this->cardNumber = $cardNumber;
    }

    public function getAddress(): string
    {
        return $this->address;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }

    public function getCardNumber(): string
    {
        return $this->cardNumber;
    }
}