<?php

namespace repository;

use entity\Cart;
use repository\connection\Connection;
use repository\hydrator\Hydrator;

class CartRepository extends Repository
{
    private BookRepository $bookRepository;

    public function __construct(
        Connection $connection,
        Hydrator $hydrator,
        BookRepository $bookRepository,
    )
    {
        parent::__construct($connection, $hydrator);
        $this->bookRepository = $bookRepository;
    }

    public function getByUserId(int $userId): ?Cart
    {
        return $this->getByColumn("user_id", $userId, true);
    }

    public function getTableName(): string
    {
        return "carts";
    }

    public function getEntityClass(): string
    {
        return Cart::class;
    }
}