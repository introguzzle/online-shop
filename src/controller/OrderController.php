<?php

namespace controller;

use entity\Order;
use service\OrderService;

class OrderController extends Controller
{
    private OrderService $orderService;

    public function __construct()
    {
        parent::__construct();
        $this->orderService = new OrderService();
    }

    public function view(): void
    {
        require_once $this->renderer->render("checkout.phtml");
    }

    public function processOrder(): void
    {
        $errors = $this->orderService->processOrder($this->acquireOrder());

        if ($errors->hasNone()) {

        } else {

            require_once $this->renderer->render();
        }
    }

    public function acquireOrder(): Order
    {
        return new Order(
            $_POST["address"],
            $_POST["phone"],
            $_POST["card-number"]
        );
    }
}