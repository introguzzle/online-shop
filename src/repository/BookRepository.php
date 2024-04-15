<?php

namespace repository;

use entity\Book;
use entity\Entity;
use entity\Profile;
use entity\User;
use Logger;
use PDO;
use Throwable;

class BookRepository extends Repository
{

    public function __construct()
    {
        parent::__construct();
    }

    public function getTableName(): string
    {
        return "books";
    }

    public function getEntityClass(): string
    {
        return Book::class;
    }
}