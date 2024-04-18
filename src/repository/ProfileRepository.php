<?php

namespace repository;

use entity\Entity;
use entity\Profile;
use repository\connection\Connection;
use repository\hydrator\Hydrator;

class ProfileRepository extends Repository {

    public function __construct(
        Connection $connection,
        Hydrator $hydrator
    )
    {
        parent::__construct($connection, $hydrator);
    }

    public function getByUserId(int $userId): Profile | Entity | null
    {
        return $this->getByColumn("user_id", $userId, true);
    }

    public function updateDescriptionById(int $id, string $value): bool
    {
        return $this->updateColumnById("description", $id, $value);
    }

    public function updateAvatarUrlById(int $id, string $value): bool
    {
        return $this->updateColumnById("avatar_url", $id, $value);
    }

    public function getTableName(): string
    {
        return "profiles";
    }

    public function getEntityClass(): string
    {
        return Profile::class;
    }
}