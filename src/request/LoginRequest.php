<?php

namespace request;

class LoginRequest extends Request {

    public function __construct(string $email,
                                string $password,
                                string $remember = "0") {
        parent::__construct(
            "POST",
            "/login",
            ["Content-Type: application/x-www-form-urlencoded"],
            ["email" => $email, "password" => $password, "remember" => $remember]
        );
    }

    public function getEmail(): string {
        return $this->getBody()["email"];
    }

    public function getPassword(): string {
        return $this->getBody()["password"];
    }

    public function getRemember(): string {
        return $this->getBody()["remember"];
    }
}