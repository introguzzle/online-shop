<?php

namespace service;

use dto\Errors;
use dto\OrderForm;
use entity\Order;
use repository\CartRepository;
use repository\OrderRepository;
use session\Authentication;
use Throwable;

class OrderService implements Service
{
    private OrderRepository $orderRepository;
    private CartRepository $cartRepository;

    public function __construct()
    {
        $this->orderRepository = new OrderRepository();
        $this->cartRepository = new CartRepository();
    }

    public function processOrder(OrderForm $orderForm): Errors
    {
        $errors = $this->validate();

        if ($errors->hasAny()) {
            return $errors;
        }

        $order = $this->bindOrder($this->createOrder($orderForm));

        if (!$this->save($order)) {
            $errors->add("order", "Failed to save");
        }

        return $errors;
    }

    private function bindOrder(Order $order): Order
    {
        $user = Authentication::getUser();
        $cart = $this->cartRepository->getByUserId($user->getId());
        $order->setCartId($cart->getId());

        return $order;
    }

    private function createOrder(OrderForm $orderForm): Order
    {
        return new Order(
            $orderForm->getAddress(),
            $orderForm->getPhone(),
            $orderForm->getCardNumber()
        );
    }

    private function save(Order $order): bool
    {
        try {
            $this->orderRepository->save($order);
        } catch (Throwable $t) {
            print_r($t);
            return false;
        }

        return true;
    }

    private function validate(): Errors
    {
        $errors = Errors::create();

        return $errors;
    }
}