<?php

namespace controller;

class CatalogController extends Controller {

    public function get(): void {
        require_once $this->renderer->render("catalog.phtml", true);
    }

    public function post() {

    }
}