<?php

namespace service;

use repository\UserRepository;
use dto\User;
use request\RegistrationRequest;

class RegistrationService implements Service {

    private array $errors = [];
    private UserRepository $userRepository;
    private ProfileService $profileService;
    private CartService $cartService;

    public function __construct() {
        $this->userRepository = new UserRepository();
        $this->profileService = new ProfileService();
        $this->cartService = new CartService();
    }

    public function proceed(): array | true {
        $registrationRequest = $this->toRequest();
        $correct = $this->validate($registrationRequest);

        $user = $registrationRequest->toUser();

        if (!$correct) {
            return $this->errors;
        } else {
            $this->saveUser($user);

            $user = $this->userRepository->getByEmail($user->getEmail());

            $this->saveProfile($user);
            $this->saveCart($user);

            return true;
        }
    }

    private function validate(RegistrationRequest $request): bool {
        $errorsArePresent = false;

        if ($this->userRepository->getByEmail($request->getEmail()) !== null) {
            $this->errors["email"] = "Email is already taken";
            $errorsArePresent = true;
        }

        if (!filter_var($request->getEmail(), FILTER_VALIDATE_EMAIL)) {
            $this->errors["email"] = "Invalid email";
            $errorsArePresent = true;
        }

        if ($request->getPassword() !== $request->getPasswordRepeat()) {
            $this->errors["password"] = "Invalid password";
            $errorsArePresent = true;
        }

        $nameLength = strlen($request->getName());

        if ($nameLength <= 4 || $nameLength >= 255) {
            $this->errors["name"] = "Invalid name";
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

    public function saveUser(User $user): void {
        $this->userRepository->save($user);
    }

    public function saveProfile(User $user): void {
        $this->profileService->saveProfile($user);
    }

    public function saveCart(User $user): void {
        $this->cartService->saveCart($user);
    }
}