<?php

namespace service;

use repository\BookRepository;

class CatalogService implements Service {
    private BookRepository $bookRepository;

    public function __construct(BookRepository $bookRepository) {
        $this->bookRepository = $bookRepository;
    }

    public function getAllBooks(): array {
        return $this->bookRepository->getAll();
    }
}