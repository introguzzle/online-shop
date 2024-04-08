<?php

namespace repository;

use dto\Profile;
use dto\User;
use Logger;
use Throwable;

class ProfileRepository {

    private Logger $logger;
    private \PDO $pdo;
    private UserRepository $userRepository;

    public function __construct() {
        $this->pdo = PDOHolder::getPdo();
        $this->logger = new Logger();
        $this->userRepository = new UserRepository();
    }

    public function saveFromUser(User $user): void {
        $user = $this->userRepository->getByEmail($user->getEmail());
        $id = $user->getId();

        $stmt = $this->pdo->prepare("INSERT INTO profiles(user_id) VALUES (:user_id)");
        $stmt->bindParam(":user_id", $id);

        try {
            $stmt->execute();
        } catch (Throwable $t) {
            $this->logger->error($t);
        }
    }

    public function saveAll(array $array): ?array {
        return [];
    }

    public function getById(int $id): ?Profile {
        return $this->getByColumn("id", $id);
    }

    public function getByUserId(int $userId): ?Profile {
        return $this->getByColumn("user_id", $userId);
    }

    public function getAll(): ?array {
        return [];
    }

    public function save(Profile $profile): ?Profile {
        return null;
    }

    private function getByColumn(string $column, mixed $value): ?Profile {
        $query = "SELECT * FROM profiles WHERE $column=:$column";

        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(":$column", $value);
        $stmt->execute();

        $array = $stmt->fetch();

        try {
            return self::fetchedToProfile($array);
        } catch (Throwable $t) {
            $this->logger->error($t);
            return null;
        }
    }

    private static function fetchedToProfile(mixed $array): Profile {
        return new Profile(
            $array["id"],
            $array["user_id"],
            $array["avatar_url"],
            $array["description"]
        );
    }
}