<?php

namespace validation;

use dto\DTO;
use dto\Errors;
use dto\RegistrationDTO;
use repository\UserRepository;

class RegistrationValidator implements Validator
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function validate(RegistrationDTO|DTO $dto): Errors
    {
        $errors = Errors::create();

        if ($this->userRepository->getByEmail($dto->getEmail()) !== null) {
            $errors->add("email", "Email is already taken");
        }

        if (!filter_var($dto->getEmail(), FILTER_VALIDATE_EMAIL)) {
            $errors->add("email", "Invalid email");
        }

        if ($dto->getPassword() !== $dto->getPasswordRepeat()) {
            $errors->add("password", "Invalid password");
        }

        $nameLength = strlen($dto->getName());

        if ($nameLength <= 4 || $nameLength >= 255) {
            $errors->add("name", "Invalid name");
        }

        return $errors;
    }
}