<?php

namespace validation;

use dto\DTO;
use dto\Errors;
use dto\LoginDTO;

class LoginValidator implements Validator
{
    public function __construct()
    {

    }

    public function validate(LoginDTO | DTO $dto): Errors
    {
        $errors = Errors::create();

        if ($dto->getEmail() === null) {
            $errors->add("email", "Empty email");
        }

        if ($dto->getPassword() === null) {
            $errors->add("password", "Empty password");
        }

        if (!filter_var($dto->getEmail(), FILTER_VALIDATE_EMAIL)) {
            $errors->add("email", "Invalid email");
        }

        return $errors;
    }
}