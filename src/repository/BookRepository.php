<?php

namespace repository;

use dto\Book;
use dto\DTO;
use dto\Profile;
use dto\User;
use Logger;
use PDO;
use Throwable;

class BookRepository extends Repository
{

    public function __construct()
    {
        parent::__construct();
    }

    public function getById(int|string $id): ?Book
    {
        return $this->getByColumn(Book::class,"id", $id);
    }

    public function getTableName(): string
    {
        return "books";
    }
}