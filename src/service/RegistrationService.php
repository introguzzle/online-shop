<?php

namespace service;

use repository\UserRepository;
use dto\User;
use request\RegistrationRequest;

class RegistrationService {

    private array $errors = [];
    private UserRepository $userRepository;

    public function __construct() {
        $this->userRepository = new UserRepository();
    }

    public function proceed(): array | true {
        $registrationRequest = $this->toRequest();
        $correct = $this->validate($registrationRequest);

        $user = $registrationRequest->toUser();

        if (!$correct) {
            return $this->errors;
        } else {
            $this->save($user);
            return true;
        }
    }

    private function validate(RegistrationRequest $request): bool {
        $errorsArePresent = false;

        if (!filter_var($request->getEmail(), FILTER_VALIDATE_EMAIL)) {
            $this->errors["email"] = true;
            $errorsArePresent = true;
        }

        if ($request->getPassword() !== $request->getPasswordRepeat()) {
            $this->errors["password"] = true;
            $errorsArePresent = true;
        }

        $nameLength = strlen($request->getName());

        if ($nameLength <= 4 || $nameLength >= 255) {
            $this->errors["name"] = true;
            $errorsArePresent = true;
        }

        return !$errorsArePresent;
    }

    private function toRequest(): RegistrationRequest {
        $name = $_REQUEST["name"];
        $email = $_REQUEST["email"];
        $password = $_REQUEST["psw"];
        $passwordRepeat = $_REQUEST["psw-repeat"];

        return new RegistrationRequest($name, $email, $password, $passwordRepeat);
    }

    public function save(User $user): void {
        $this->userRepository->save($user);
    }
}