<?php

namespace entity;

class Profile extends Entity
{
    public const string AVATAR_NOT_SET = "-1";

    private int $id;
    private int $userId;
    private string $avatarUrl;
    private string $description;

    public function __construct(
        int $userId,
        int $id = 0,
        string $avatarUrl = self::AVATAR_NOT_SET,
        string $description = ""
    )
    {
        $this->id = $id;
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