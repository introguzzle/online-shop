<?php

namespace controller;

use dto\OrderDTO;
use entity\Order;
use request\OrderRequest;
use service\OrderService;

class OrderController extends Controller
{
    private OrderService $orderService;

    public function __construct(OrderService $orderService)
    {
        parent::__construct();
        $this->orderService = $orderService;
    }

    public function view(): void
    {
        require_once $this->renderer->render("checkout.phtml");
    }

    public function processOrder(): void
    {
        $request = $this->acquireRequest();

        $errors = $this->orderService->processOrder(new OrderDTO(
            $request->getAddress(),
            $request->getPhone(),
            $request->getCardNumber()
        ));

        if ($errors->hasNone()) {
            header("Location: /catalog");

        } else {
            require_once $this->renderer->render("checkout.phtml", "Checkout");
        }
    }

    public function acquireRequest(): OrderRequest
    {
        return new OrderRequest(
            $_POST["address"],
            $_POST["phone"],
            $_POST["card-number"]
        );
    }
}