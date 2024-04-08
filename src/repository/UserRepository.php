<?php

namespace repository;

use dto\User;
use Exception;
use Logger;
use PDO;
use Throwable;

class UserRepository implements Repository {

    private PDO $pdo;
    private Logger $logger;

    public function __construct() {
        $this->pdo = PDOHolder::getPdo();
        $this->logger = new Logger();
    }

    public function save(object $object): ?object {
        $query = "INSERT INTO users(name, email, password, created_at, updated_at) 
                VALUES (:name, :email, :password, :created_at, :updated_at)";

        $stmt = $this->pdo->prepare($query);
        $hash = password_hash($object->getPassword(), PASSWORD_BCRYPT);

        $stmt->bindParam(':name', $object->getName());
        $stmt->bindParam(':email', $object->getEmail());
        $stmt->bindParam(':password', $hash);
        $stmt->bindParam(':created_at', $object->getCreatedAt());
        $stmt->bindParam(':updated_at', $object->getUpdatedAt());

        try {
            $stmt->execute();
        } catch (Exception $e) {
            $this->logger->error($e);
            return null;
        }

        return $object;
    }

    public function saveAll(array $array): ?array {
        $result = [];

        foreach ($array as $item) {
            $result[] = $this->save($item);
        }

        return $result;
    }

    public function getById(mixed $id): ?object {
        return $this->getByColumn("id", $id);
    }

    public function getByEmail(string $email): ?object {
        return $this->getByColumn("email", $email);
    }

    public function getAll(): ?array {
        $query = "SELECT * FROM users";

        $stmt = $this->pdo->prepare($query);
        $stmt->execute();

        $array = $stmt->fetchAll();

        return self::fetchedToUsers($array);
    }

    private function getByColumn(string $column, mixed $value): ?User {
        $query = "SELECT * FROM users WHERE $column=:$column";

        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(":$column", $value);
        $stmt->execute();

        $array = $stmt->fetch();

        try {
            return self::fetchedToUser($array);
        } catch (Throwable $t) {
            $this->logger->error($t);
            return null;
        }
    }

    private static function fetchedToUser(array $array): User {
        return new User(
            $array["id"],
            $array["name"],
            $array["email"],
            $array["password"],
        );
    }

    private static function fetchedToUsers(array $array): array {
        $users = [];

        foreach ($array as $user) {
            $users[] = self::fetchedToUser($user);
        }

        return $users;
    }
}