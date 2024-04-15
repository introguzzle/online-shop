<?php

namespace entity;

use DateTime;

class Order extends Entity
{
    private int $id;
    private int $cartId;
    private string $address;
    private string $phone;
    private string $cardNumber;
    private string $createdAt;
    private bool $finished;

    public function __construct(
        string $address,
        string $phone,
        string $cardNumber,
        int $id = 0,
        int $cartId = 0
    )
    {
        $this->id = $id;
        $this->cartId = $cartId;
        $this->address = $address;
        $this->phone = $phone;
        $this->cardNumber = $cardNumber;
        $this->createdAt = (new DateTime())->format('Y-m-d H:i:s');
        $this->finished = false;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getCartId(): int
    {
        return $this->cartId;
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

    public function getCreatedAt(): string
    {
        return $this->createdAt;
    }

    public function isFinished(): bool
    {
        return $this->finished;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function setCartId(int $cartId): void
    {
        $this->cartId = $cartId;
    }

    public function setAddress(string $address): void
    {
        $this->address = $address;
    }

    public function setPhone(string $phone): void
    {
        $this->phone = $phone;
    }

    public function setCardNumber(string $cardNumber): void
    {
        $this->cardNumber = $cardNumber;
    }

    public function setCreatedAt(string $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function setFinished(bool $finished): void
    {
        $this->finished = $finished;
    }

}