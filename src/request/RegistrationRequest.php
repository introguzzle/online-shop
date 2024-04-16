<?php

namespace request;

class RegistrationRequest extends Request
{

    private string $name;
    private string $email;
    private string $password;
    private string $passwordRepeat;

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

        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
        $this->passwordRepeat = $passwordRepeat;

    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getPasswordRepeat(): string
    {
        return $this->passwordRepeat;
    }

    public function __toString(): string
    {
        return "RegistrationRequest[$this->name, $this->email, $this->password, $this->passwordRepeat]";
    }
}
