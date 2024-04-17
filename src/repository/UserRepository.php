<?php

namespace repository;

use entity\Entity;
use entity\User;
use repository\hydrator\Hydrator;

class UserRepository extends Repository {

    public function __construct(Hydrator $hydrator)
    {
        parent::__construct($hydrator);
    }

    public function getByEmail(string $email): User | Entity | null
    {
        return $this->getByColumn("email", $email, true);
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