<?php

namespace controller;

use service\CatalogService;

class CatalogController extends Controller {

    private CatalogService $catalogService;

    public function __construct() {
        parent::__construct();
        $this->catalogService = new CatalogService();
    }

    public function get(): void {
        $books = $this->catalogService->getAllBooks();

        require_once $this->renderer->render("catalog.phtml");
    }

    public function post() {

    }
}