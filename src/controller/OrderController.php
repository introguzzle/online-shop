<?php

namespace controller;

use dto\Errors;
use dto\OrderDTO;
use request\OrderRequest;
use service\OrderService;
use util\Requests;
use validation\OrderValidator;
use validation\Validator;

class OrderController extends Controller
{
    private OrderService $orderService;
    private Validator $orderValidator;

    public function __construct(
        OrderService $orderService,
        OrderValidator $orderValidator
    )
    {
        parent::__construct();

        $this->orderService = $orderService;
        $this->orderValidator = $orderValidator;
    }

    public function view(): void
    {
        require_once $this->renderer->render("checkout.phtml");
    }

    public function processOrder(OrderRequest $orderRequest): void
    {
        $dto    = Requests::toDTO($orderRequest, OrderDTO::class);
        $errors = $this->validate($dto);

        if ($errors->hasNone() && $this->orderService->processOrder($dto)->hasNone()) {
            header("Location: /catalog");

        } else {
            require_once $this->renderer->render("checkout.phtml", "Checkout");
        }
    }

    private function validate(OrderDTO $dto): Errors
    {
        return $this->orderValidator->validate($dto);
    }
}