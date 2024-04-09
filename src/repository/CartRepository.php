<?php

namespace repository;

use dto\Book;
use dto\Cart;
use dto\DTO;
use dto\User;
use Logger;
use PDO;
use repository\Repository;
use Throwable;

class CartRepository implements Repository {

    private Logger $logger;
    private PDO $pdo;
    private UserRepository $userRepository;
    private BookRepository $bookRepository;

    public function __construct() {
        $this->pdo = PDOHolder::getPdo();
        $this->logger = new Logger();
        $this->userRepository = new UserRepository();
        $this->bookRepository = new BookRepository();
    }

    public function saveFromUser(User $user): void {
        $user = $this->userRepository->getByEmail($user->getEmail());
        $id = $user->getId();

        $stmt = $this->pdo->prepare("INSERT INTO carts(user_id) VALUES (:user_id)");
        $stmt->bindParam(":user_id", $id);

        try {
            $stmt->execute();
        } catch (Throwable $t) {
            $this->logger->error($t);
        }
    }

    function saveBook(User $user, Book $book): ?Book {
        $stmt = $this->pdo->prepare("INSERT INTO cart_book(cart_id, book_id) VALUES (:cart_id, :book_id)");

        $cartId = $user->getId();
        $bookId = $book->getId();

        $stmt->bindParam(":cart_id", $cartId);
        $stmt->bindParam(":book_id", $bookId);

        try {
            $stmt->execute();
            return $book;
        } catch (Throwable $t) {
            $this->logger->error($t);
            return null;
        }
    }

    public function getByUserId(int $userId): ?Cart {
        $stmt = $this->pdo->prepare("SELECT * FROM carts WHERE user_id=:user_id");

        $stmt->bindParam(":user_id", $userId);

        try {
            $stmt->execute();
            $array = $stmt->fetch();
            return new Cart($array["id"], $array["user_id"]);

        } catch (Throwable $t) {
            $this->logger->error($t);
            return null;
        }
    }

    function saveAll(array $array): ?array {

    }

    function getById(int|string $id): ?object {
    }

    function getAll(): ?array {

    }

    public function save(Cart|DTO $dto): ?Cart {
        $query = "INSERT INTO carts(user_id) VALUES (:user_id)";

        $stmt = $this->pdo->prepare($query);

        $userId = $dto->getUserId();

        $stmt->bindParam(":user_id", $userId);

        try {
            $stmt->execute();
            return $dto;
        } catch (Throwable $t) {
            $this->logger->error($t);
            return null;
        }
    }

    public function getAllBooksById(int $cartId): ?array {
        $stmt = $this->pdo->prepare("SELECT book_id FROM cart_book WHERE cart_id=:cart_id");

        $stmt->bindParam(":cart_id", $cartId);

        try {
            $stmt->execute();
            $fetched = $stmt->fetchAll();

            $books = [];

            foreach ($fetched as $array) {
                $books[] = $this->bookRepository->getById($array["book_id"]);
            }

            return $books;

        } catch (Throwable $t) {
            $this->logger->error($t);
            return null;
        }
    }
}