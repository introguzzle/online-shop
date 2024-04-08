<?php

namespace request;

use dto\User;

class RegistrationRequest extends Request {

    private string $name;
    private string $email;
    private string $password;
    private string $passwordRepeat;

    public function __construct(string $name,
                                string $email,
                                string $password,
                                string $passwordRepeat) {
        parent::__construct(
            "POST",
            "/registrate",
            [$name, $email, $password, $passwordRepeat]
        );

        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
        $this->passwordRepeat = $passwordRepeat;

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

    public function getPasswordRepeat(): string {
        return $this->passwordRepeat;
    }

    public function toUser(): User {
        return new User(0, $this->name, $this->email, $this->password);
    }
}
