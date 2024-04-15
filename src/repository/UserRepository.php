<?php

namespace repository;

use entity\Entity;
use entity\User;

class UserRepository extends Repository {

    public function __construct()
    {
        parent::__construct();
    }

    public function getByEmail(string $email): User | Entity | null
    {
        return $this->getByColumn("email", $email);
    }

    public function getTableName(): string
    {
        return "users";
    }

    public function getEntityClass(): string
    {
        return User::class;
    }
}