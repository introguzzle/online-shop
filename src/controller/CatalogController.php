<?php

namespace controller;

use service\CatalogService;

class CatalogController extends Controller
{

    private CatalogService $catalogService;

    public function __construct(CatalogService $catalogService)
    {
        parent::__construct();
        $this->catalogService = $catalogService;
    }

    public function view(): void
    {
        $books = $this->catalogService->getAllBooks();

        require_once $this->renderer->render(
            "catalog.phtml",
            "Catalog"
        );
    }
}