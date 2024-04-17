<?php

namespace controller;

use service\authentication\Authentication;
use service\CartService;

class CartController extends Controller
{
    private CartService $cartService;

    public function __construct(CartService $cartService)
    {
        parent::__construct();

        $this->cartService = $cartService;
    }

    public function view(): void
    {
        $user = Authentication::getUser();
        $cartView = $this->cartService->getCartView($user->getId());

        require_once $this->renderer->render("cart.phtml", "Cart");
    }

    public function addFromCatalog(): void
    {
        $this->cartService->addFromCatalog($this->acquireBookId());

        header("Location: /catalog");
    }

    public function add(): void
    {
        $this->change(1);
    }

    public function remove(): void
    {
        $this->change(-1);
    }

    public function change(int $value): void
    {
        $this->cartService->change($this->acquireBookId(), $value);
        header("Location: /cart");
    }

    public function acquireBookId(): int
    {
        return $_POST["book_id"];
    }
}