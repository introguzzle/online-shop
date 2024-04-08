<?php

namespace dto;

use DateTime;

class User {
    private int $id;
    private string $name;
    private string $email;
    private string $password;
    private string $createdAt;
    private string $updatedAt;

    public function __construct(int $id,
                                string $name,
                                string $email,
                                string $password) {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
        $this->createdAt = (new DateTime())->format('Y-m-d H:i:s');
        $this->updatedAt = $this->createdAt;
    }

    public function getId(): int {
        return $this->id;
    }

    public function getName(): string {
        return $this->name;
    }

    public function getEmail(): string {
        return $this->email;
    }

    public function getPassword(): string {
        return $this->password;
    }

    public function getCreatedAt(): string {
        return $this->createdAt;
    }

    public function getUpdatedAt(): string {
        return $this->updatedAt;
    }
}