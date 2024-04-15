<?php

namespace entity;

class CartBook extends Entity
{
    private int $id;
    private int $cartId;
    private int $bookId;
    private int $quantity;

    public function __construct(
        int $cartId,
        int $bookId,
        int $quantity = 1,
        int $id = 0
    )
    {
        $this->id = $id;
        $this->cartId = $cartId;
        $this->bookId = $bookId;
        $this->quantity = $quantity;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getCartId(): int
    {
        return $this->cartId;
    }

    public function setCartId(int $cartId): void
    {
        $this->cartId = $cartId;
    }

    public function getBookId(): int
    {
        return $this->bookId;
    }

    public function setBookId(int $bookId): void
    {
        $this->bookId = $bookId;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): void
    {
        $this->quantity = $quantity;
    }
}