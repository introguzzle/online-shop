<?php

namespace service;

use dto\Errors;
use dto\OrderDTO;
use entity\Order;
use repository\CartRepository;
use repository\OrderRepository;
use service\authentication\Authentication;
use Throwable;
use validation\OrderValidator;
use validation\Validator;

class OrderService implements Service
{
    private OrderRepository $orderRepository;
    private CartRepository $cartRepository;
    private Validator $validator;

    public function __construct(
        OrderRepository $orderRepository,
        CartRepository $cartRepository,
        OrderValidator $validator
    )
    {
        $this->orderRepository = $orderRepository;
        $this->cartRepository = $cartRepository;
        $this->validator = $validator;
    }

    public function processOrder(OrderDTO $orderDTO): Errors
    {
        $errors = $this->validate($orderDTO);

        if ($errors->hasAny()) {
            return $errors;
        }

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

    private function createOrder(OrderDTO $orderForm): Order
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
        } catch (Throwable) {
            return false;
        }

        return true;
    }

    private function validate(OrderDTO $dto): Errors
    {
        return $this->validator->validate($dto);
    }
}