<?php

namespace repository;

use entity\Book;
use entity\CartBook;
use entity\Entity;
use entity\User;
use repository\connection\Connection;
use repository\hydrator\Hydrator;

class CartBookRepository extends Repository
{
    private CartRepository $cartRepository;
    private BookRepository $bookRepository;

    public function __construct(
        Connection $connection,
        Hydrator $hydrator,
        CartRepository $cartRepository,
        BookRepository $bookRepository
    )
    {
        parent::__construct($connection, $hydrator);

        $this->cartRepository = $cartRepository;
        $this->bookRepository = $bookRepository;
    }

    public function saveBook(User $user, Book $book): Book | Entity | null
    {
        $cartId = $this->cartRepository->getByUserId($user->getId())->getId();
        $bookId = $book->getId();

        $cartBook = $this->getByCartIdAndBookId($cartId, $bookId);

        if ($cartBook === null) {
            return $this->save(new CartBook($cartId, $bookId));
        } else {

            $this->incrementQuantityById($cartBook->getId());
            return $book;
        }
    }

    public function incrementQuantityById(int $id): void
    {
        $this->changeQuantityById($id, 1);
    }

    public function decrementQuantityById(int $id): void
    {
        $this->changeQuantityById($id, -1);
    }

    public function changeQuantityById(int $id, int $value): void
    {
        $currentQuantity = $this->getById($id)->getQuantity();

        if ($currentQuantity + $value <= 0) {
            $this->deleteById($id);
            return;
        }

        $this->updateColumnById("quantity", $id, $currentQuantity + $value);
    }

    public function getAllBooksByCartId(int $cartId): array
    {
        return array_map(function(CartBook $cartBook) {
            return $this->bookRepository->getById($cartBook->getBookId());
        }, $this->getByCartId($cartId));
    }

    public function getByCartIdAndBookId(int $cartId, int $bookId): ?CartBook
    {
        return $this->getByCriteria(["cart_id" => $cartId, "book_id" => $bookId], true);
    }

    public function getByBookId(int $bookId): array
    {
        return $this->getByColumn("book_id", $bookId);
    }

    public function getByCartId(int $cartId): array
    {
        return $this->getByColumn("cart_id", $cartId);
    }

    public function getTableName(): string
    {
        return "cart_book";
    }

    public function getEntityClass(): string
    {
        return CartBook::class;
    }
}