<?php

namespace controller;

use service\CatalogService;

class CatalogController extends Controller {

    private CatalogService $catalogService;

    public function __construct() {
        parent::__construct();
        $this->catalogService = new CatalogService();
    }

    public function view(): void {
        $books = $this->catalogService->getAllBooks();

        require_once $this->renderer->render("catalog.phtml", "Catalog");
    }

    public function add(): void {
        $this->catalogService->add();
        header("Location: /catalog");
    }
}