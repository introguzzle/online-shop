<?php

namespace service;

use dto\Errors;
use dto\RegistrationForm;
use repository\UserRepository;
use entity\User;

class RegistrationService implements Service
{
    private UserRepository $userRepository;
    private ProfileService $profileService;
    private CartService $cartService;

    public function __construct()
    {
        $this->userRepository = new UserRepository();
        $this->profileService = new ProfileService();
        $this->cartService = new CartService();
    }

    public function processRegistration(
        RegistrationForm $registrationForm
    ): Errors
    {
        $errors = $this->validate($registrationForm);

        if ($errors->hasAny()) {
            return $errors;
        }

        $user = $this->toUser($registrationForm);

        $this->saveUser($user);

        $user = $this->userRepository->getByEmail($registrationForm->getEmail());

        $this->saveProfile($user);
        $this->saveCart($user);

        return $errors;
    }

    private function validate(RegistrationForm $form): Errors
    {
        $errors = Errors::create();

        if ($this->userRepository->getByEmail($form->getEmail()) !== null) {
            $errors->add("email", "Email is already taken");
        }

        if (!filter_var($form->getEmail(), FILTER_VALIDATE_EMAIL)) {
            $errors->add("email", "Invalid email");
        }

        if ($form->getPassword() !== $form->getPasswordRepeat()) {
            $errors->add("password", "Invalid password");
        }

        $nameLength = strlen($form->getName());

        if ($nameLength <= 4 || $nameLength >= 255) {
            $errors->add("name", "Invalid name");
        }

        return $errors;
    }

    private function toUser(RegistrationForm $form): User
    {
        return new User(
            $form->getName(),
            $form->getEmail(),
            password_hash($form->getPassword(), PASSWORD_DEFAULT)
        );
    }

    public function saveUser(User $user): void
    {
        $this->userRepository->save($user);
    }

    public function saveProfile(User $user): void
    {
        $this->profileService->saveProfile($user);
    }

    public function saveCart(User $user): void
    {
        $this->cartService->saveCart($user);
    }
}