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

    public function viewBook(): void
    {
        $book = $this->catalogService->getBookById($_GET["id"]);
        $reviews = [1, 2, 3];

        if ($book === null) {
            header("Location: /404");
            return;
        }

        require_once $this->renderer->render(
            "book.phtml",
            "Book"
        );
    }
}