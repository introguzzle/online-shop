<?php

namespace dto;

use DateTime;
use dao\DAO;

class User {
    private string $name;
    private string $email;
    private string $password;
    private string $createdAt;
    private string $updatedAt;

    public function __construct(string $name,
                                string $email,
                                string $password) {
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
        $this->createdAt = (new DateTime())->format('Y-m-d H:i:s');
        $this->updatedAt = $this->createdAt;
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

    public function save(): void {
        $pdo = DAO::getPdo();

        $saveQuery = "INSERT INTO users(name, email, password, created_at, updated_at) 
                VALUES (:name, :email, :password, :created_at, :updated_at)";

        $stmt = $pdo->prepare($saveQuery);

        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':email', $this->email);

        $hash = password_hash($this->password, PASSWORD_BCRYPT);

        $stmt->bindParam(':password', $hash);
        $stmt->bindParam(':created_at', $this->createdAt);
        $stmt->bindParam(':updated_at', $this->updatedAt);

        $stmt->execute();
    }

    public static function getById(string $id) {

    }
}