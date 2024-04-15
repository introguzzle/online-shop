<?php

namespace service;

use entity\Book;
use repository\BookRepository;
use repository\CartRepository;
use session\Authentication;

class CatalogService implements Service {
    private BookRepository $bookRepository;

    public function __construct() {
        $this->bookRepository = new BookRepository();
    }

    public function getAllBooks(): array {
        return $this->bookRepository->getAll();
    }
}