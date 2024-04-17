<?php

namespace repository;

use entity\Book;
use repository\hydrator\Hydrator;

class BookRepository extends Repository
{

    public function __construct(Hydrator $hydrator)
    {
        parent::__construct($hydrator);
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