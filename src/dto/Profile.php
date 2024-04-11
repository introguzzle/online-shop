<?php

namespace dto;

class Profile extends DTO
{
    private int $id;
    private int $userId;
    private string $avatarUrl;
    private string $description;

    public function __construct(
        int $userId,
        string $avatarUrl = "-1",
        string $description = ""
    )
    {
        $this->id = 0;
        $this->userId = $userId;
        $this->avatarUrl = $avatarUrl;
        $this->description = $description;
    }

    public function getId(): int {
        return $this->id;
    }

    public function getUserId(): int {
        return $this->userId;
    }

    public function getAvatarUrl(): string {
        return $this->avatarUrl;
    }

    public function getDescription(): string {
        return $this->description;
    }
}