<?php

namespace dto;

class OrderDTO extends DTO
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
        $this->address = $address;
        $this->phone = $phone;
        $this->cardNumber = $cardNumber;
    }

    public function getAddress(): string
    {
        return $this->address;
    }

    public function setAddress(string $address): void
    {
        $this->address = $address;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): void
    {
        $this->phone = $phone;
    }

    public function getCardNumber(): string
    {
        return $this->cardNumber;
    }

    public function setCardNumber(string $cardNumber): void
    {
        $this->cardNumber = $cardNumber;
    }


}