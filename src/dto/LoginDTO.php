<?php

namespace dto;

class LoginDTO extends DTO
{
    private string $email;
    private string $password;

    private string $remember;

    public function __construct(
        string $email,
        string $password,
        string $remember
    )
    {
        $this->email = $email;
        $this->password = $password;
        $this->remember = $remember;
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

    public function getRemember(): string
    {
        return $this->remember;
    }

    public function setRemember(string $remember): void
    {
        $this->remember = $remember;
    }
}