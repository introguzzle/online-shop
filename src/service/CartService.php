<?php

namespace service;

use entity\Cart;
use entity\User;
use repository\CartRepository;
use session\Authentication;

class CartService implements Service {

    private CartRepository $cartRepository;

    public function __construct() {
        $this->cartRepository = new CartRepository();
    }
    public function getCartBooks(): array {
        $user = Authentication::getUser();

        $cart = $this->cartRepository->getByUserId($user->getId());

        return $this->cartRepository->getAllBooksById($cart->getId());
    }

    public function saveCart(User $user): void {
        $cart = new Cart(0, $user->getId());
        $this->cartRepository->save($cart);
    }
}