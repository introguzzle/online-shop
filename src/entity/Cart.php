<?php

namespace entity;

class Cart extends Entity
{
    private int $id;
    private int $userId;

    public function __construct(
        int $userId,
        int $id = 0
    )
    {
        $this->id = $id;
        $this->userId = $userId;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function setUserId(int $userId): void
    {
        $this->userId = $userId;
    }


}