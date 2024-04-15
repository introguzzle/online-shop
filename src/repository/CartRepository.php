<?php

namespace repository;

use entity\Book;
use entity\Cart;
use entity\User;

class CartRepository extends Repository
{
    private BookRepository $bookRepository;

    public function __construct()
    {
        parent::__construct();

        $this->bookRepository = new BookRepository();
    }

    public function getByUserId(int $userId): ?Cart
    {
        return $this->getByColumn("user_id", $userId)[0];
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