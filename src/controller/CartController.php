<?php

namespace controller;

class CartController extends Controller {

    public function get() {
        $books = [];

        require_once $this->renderer->render("cart.phtml");
    }

    public function post() {

    }
}