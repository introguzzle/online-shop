<?php

namespace repository;

use entity\Review;
use repository\connection\Connection;
use repository\hydrator\Hydrator;

class ReviewRepository extends Repository
{
    public function __construct(
        Connection $connection,
        Hydrator $hydrator
    )
    {
        parent::__construct($connection, $hydrator);
    }

    public function getByUserId(int $userId): array
    {
        return $this->getByColumn(
            "user_id",
            $userId
        );
    }

    public function getByBookId(
        int $bookId,
        string $ordering = Repository::DESCENDING
    ): array
    {
        return $this->getByColumn(
            "book_id",
            $bookId,
            false,
            Repository::JOIN_AND,
            ["rating" => $ordering]
        );
    }

    public function getTableName(): string
    {
        return "reviews";
    }

    public function getEntityClass(): string
    {
        return Review::class;
    }
}