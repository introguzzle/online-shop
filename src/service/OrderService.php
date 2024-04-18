<?php

namespace service;

use dto\Errors;
use dto\OrderDTO;
use entity\Order;
use repository\CartRepository;
use repository\OrderRepository;
use service\authentication\Authentication;
use Throwable;

class OrderService implements Service
{
    private OrderRepository $orderRepository;
    private CartRepository $cartRepository;

    public function __construct(
        OrderRepository $orderRepository,
        CartRepository $cartRepository,
    )
    {
        $this->orderRepository = $orderRepository;
        $this->cartRepository = $cartRepository;
    }

    public function processOrder(OrderDTO $orderDTO): Errors
    {
        $errors = Errors::create();

        $order = $this->bindOrder($this->createOrder($orderDTO));

        if (!$this->save($order)) {
            $errors->add("order", "Failed to process order");
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

    private function createOrder(OrderDTO $dto): Order
    {
        return new Order(
            $dto->getAddress(),
            $dto->getPhone(),
            $dto->getCardNumber()
        );
    }

    private function save(Order $order): bool
    {
        try {
            $this->orderRepository->save($order);
        } catch (Throwable) {
            return false;
        }

        return true;
    }
}