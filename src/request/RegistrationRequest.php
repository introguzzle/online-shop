<?php

namespace request;

use dto\Errors;

class RegistrationRequest extends Request
{
    public function __construct(
        string $name,
        string $email,
        string $password,
        string $passwordRepeat
    )
    {
        parent::__construct(
            "POST",
            "/registrate",
            ["Content-Type: application/x-www-form-urlencoded"],
            ["name" => $name, "email" => $email, "password" => $password, "passwordRepeat" => $passwordRepeat]
        );
    }

    public function getName(): string
    {
        return $this->getBody()["name"];
    }

    public function getEmail(): string
    {
        return $this->getBody()["email"];
    }

    public function getPassword(): string
    {
        return $this->getBody()["password"];
    }

    public function getPasswordRepeat(): string
    {
        return $this->getBody()["passwordRepeat"];
    }
}
