<?php

namespace repository;

use dto\Book;
use dto\DTO;
use dto\Profile;
use dto\User;
use Logger;
use PDO;
use Throwable;

class BookRepository implements Repository {
    private Logger $logger;
    private PDO $pdo;

    public function __construct() {
        $this->pdo = PDOHolder::getPdo();
        $this->logger = new Logger();
    }

    public function saveAll(array $array): ?array {
        return [];
    }

    public function getById(int|string $id): ?Book {
        return $this->getByColumn("id", $id);
    }

    public function getAll(): ?array {
        $query = "SELECT * FROM books";

        $stmt = $this->pdo->prepare($query);
        $stmt->execute();

        $all = $stmt->fetchAll();

        try {
            $books = [];

            foreach ($all as $array) {
                $books[] = self::fetchedToBook($array);
            }

            return $books;
        } catch (Throwable $t) {
            $this->logger->error($t);
            return null;
        }
    }

    public function save(Book|DTO $dto): ?Book {
        return null;
    }

    private function getByColumn(string $column, mixed $value): ?Book {
        $query = "SELECT * FROM books WHERE $column=:$column";

        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(":$column", $value);
        $stmt->execute();

        $array = $stmt->fetch();

        try {
            return self::fetchedToBook($array);
        } catch (Throwable $t) {
            $this->logger->error($t);
            return null;
        }
    }

    private static function fetchedToBook(array $array): Book {
        return new Book(
            $array["id"],
            $array["name"],
            $array["author"],
            $array["description"],
            $array["price"],
            $array["year"],
            $array["image_url"]
        );
    }
}