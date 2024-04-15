<?php

namespace service;

use dto\Errors;
use entity\Order;
use repository\CartRepository;
use repository\OrderRepository;
use session\Authentication;

class OrderService implements Service
{
    private OrderRepository $orderRepository;
    private CartRepository $cartRepository;

    public function __construct()
    {
        $this->orderRepository = new OrderRepository();
        $this->cartRepository = new CartRepository();
    }

    public function processOrder(Order $order): Errors
    {
        $errors = $this->validate();

        if

        $user = Authentication::getUser();
        $cart = $this->cartRepository->getByUserId($user->getId());

        $order->setCartId($cart->getId());
        $this->orderRepository->save($order);
    }

    private function validate(): Errors
    {
        $errors = Errors::create();

        return $errors;
    }
}