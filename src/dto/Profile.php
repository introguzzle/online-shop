<?php

namespace dto;

class Profile {
    private int $id;
    private int $userId;
    private string $avatarUrl;
    private string $description;

    public function __construct(int $id,
                                int $userId,
                                string $avatarUrl,
                                string $description) {
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