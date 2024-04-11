<?php

namespace repository;

use dto\DTO;
use dto\User;
use Exception;
use Logger;
use PDO;
use Throwable;

class UserRepository extends Repository {

    public function __construct()
    {
        parent::__construct();
    }

    public function getById(mixed $id): ?User
    {
        return $this->getByColumn(User::class, "id", $id);
    }

    public function getByEmail(string $email): ?User
    {
        return $this->getByColumn(User::class, "email", $email);
    }

    public function getTableName(): string
    {
        return "users";
    }
}