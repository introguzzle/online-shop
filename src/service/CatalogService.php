<?php

namespace service;

use repository\BookRepository;

class CatalogService {
    private BookRepository $bookRepository;

    public function __construct() {
        $this->bookRepository = new BookRepository();
    }

    public function getAllBooks(): array {
        return $this->bookRepository->getAll();
    }
}