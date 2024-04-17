<?php

namespace modelview;

class CartView
{
    private array $cartBookViews;
    private int $totalPrice;

    public function __construct(
        array $cartBookViews,
        int $totalPrice
    )
    {
        $this->cartBookViews = $cartBookViews;
        $this->totalPrice = $totalPrice;
    }

    public function getCartBookViews(): array
    {
        return $this->cartBookViews;
    }

    public function getTotalPrice(): int
    {
        return $this->totalPrice;
    }
}