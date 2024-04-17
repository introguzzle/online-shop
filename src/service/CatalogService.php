<?php

namespace service;

use entity\Book;
use repository\BookRepository;

class CatalogService implements Service
{
    private BookRepository $bookRepository;

    public function __construct(BookRepository $bookRepository)
    {
        $this->bookRepository = $bookRepository;
    }

    public function getAllBooks(): array
    {
        return $this->bookRepository->getAll();
    }

    public function getBookById(int $id): ?Book
    {
        return $this->bookRepository->getById($id);
    }
}