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

    public function saveBook(User $user, Book $book): ?Book
    {
        $query = "INSERT INTO cart_book(cart_id, book_id) VALUES (:cart_id, :book_id)";
        $stmt = $this->pdo->prepare($query);

        $cartByUser = $this->getByUserId($user->getId());

        $cartId = $cartByUser->getId();
        $bookId = $book->getId();

        $stmt->bindValue(":cart_id", $cartId);
        $stmt->bindValue(":book_id", $bookId);

        $stmt->execute();

        return $book;
    }

    public function getByUserId(int $userId): ?Cart
    {
        return $this->getByColumn("user_id", $userId);
    }

    public function getAllBooksById(int $cartId): ?array
    {
        $query = "SELECT book_id FROM cart_book WHERE cart_id=:cart_id";
        $stmt = $this->pdo->prepare($query);

        $stmt->bindValue(":cart_id", $cartId);

        $stmt->execute();
        $fetched = $stmt->fetchAll();

        $books = [];

        foreach ($fetched as $array) {
            $books[] = $this->bookRepository->getById($array["book_id"]);
        }

        return $books;
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