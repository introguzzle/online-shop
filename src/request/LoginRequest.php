<?php

namespace request;

class LoginRequest extends Request {

    public function __construct(
        array $body
    ) {
        parent::__construct(
            "POST",
            "/login",
            ["Content-Type: application/x-www-form-urlencoded"],
            $body
        );
    }

    public function getEmail(): string {
        return $this->getBody()["email"];
    }

    public function getPassword(): string {
        return $this->getBody()["password"];
    }

    public function getRemember(): string {
        if (isset($this->getBody()["remember"]))
            return $this->getBody()["remember"];

        return $this->getBody()["remember"] ?? "0";
    }
}