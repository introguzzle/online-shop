<?php

namespace repository;

use dto\DTO;
use dto\Profile;
use dto\User;
use Logger;
use Throwable;

class ProfileRepository extends Repository {
    private UserRepository $userRepository;

    public function __construct() {
        parent::__construct();
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

    public function getById(int|string $id): ?Profile {
        return $this->getByColumn(Profile::class, "id", $id);
    }

    public function getByUserId(int $userId): ?Profile {
        return $this->getByColumn(Profile::class, "user_id", $userId);
    }

    public function getByColumn(string $dtoClass, string $column, mixed $value): ?Profile {
        $query = "SELECT * FROM profiles WHERE $column=:$column";

        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(":$column", $value);
        $stmt->execute();

        $fetched = $stmt->fetch();

        try {
            return $this->fetchToDTO($dtoClass, $fetched);
        } catch (Throwable $t) {
            $this->logger->error($t);
            return null;
        }
    }

    public function updateDescriptionById(int $id, string $value): bool {
        return $this->updateColumnById("description", $id, $value);
    }

    public function updateAvatarUrlById(int $id, string $value): bool {
        return $this->updateColumnById("avatar_url", $id, $value);
    }

    public function getTableName(): string
    {
        return "profiles";
    }
}