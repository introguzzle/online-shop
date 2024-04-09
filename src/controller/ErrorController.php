<?php

namespace controller;

class ErrorController extends Controller {

    public function view(): void {
        require_once $this->renderer->render("404.phtml", "404");
    }
}