<?php

namespace repository;

use entity\Book;
use repository\connection\Connection;
use repository\hydrator\Hydrator;

class BookRepository extends Repository
{
    public function __construct(
        Connection $connection,
        Hydrator $hydrator
    )
    {
        parent::__construct($connection, $hydrator);
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