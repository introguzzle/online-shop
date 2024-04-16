<?php

namespace request;

use util\Requests;

class LoginRequest extends Request {
    private string $email;
    private string $password;
    private string $remember;

    public function __construct(string $email,
                                string $password,
                                string $remember) {
        parent::__construct(
            "POST",
            "/login",
            ["Content-Type: application/x-www-form-urlencoded"],
            ["email" => $email, "password" => $password, "remember" => $remember]
        );

        $this->email = $email;
        $this->password = $password;
        $this->remember = $remember;
    }

    public function getEmail(): string {
        return $this->email;
    }

    public function getPassword(): string {
        return $this->password;
    }

    public function getRemember(): string {
        return $this->remember;
    }
}