<?php

namespace controller;

use repository\BookRepository;
use service\CartService;

class CartController extends Controller {

    private CartService $cartService;

    public function __construct() {
        parent::__construct();
        $this->cartService = new CartService();
    }

    public function view(): void {
        $books = $this->cartService->getCartBooks();

        require_once $this->renderer->render("cart.phtml", "Cart");
    }

    public function post(): void {

    }
}