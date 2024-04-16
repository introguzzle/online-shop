<?php

namespace dto;

class RegistrationForm extends DTO
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
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
        $this->passwordRepeat = $passwordRepeat;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function getPasswordRepeat(): string
    {
        return $this->passwordRepeat;
    }

    public function setPasswordRepeat(string $passwordRepeat): void
    {
        $this->passwordRepeat = $passwordRepeat;
    }
}