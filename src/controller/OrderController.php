<?php

namespace controller;

class OrderController extends Controller {
    public function view(): void {
        require_once $this->renderer->render("checkout.phtml");
    }
}