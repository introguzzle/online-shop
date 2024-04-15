<?php

namespace service;

use dto\LoginForm;
use repository\UserRepository;
use entity\User;

class SessionAuthenticationService implements AuthenticationService
{
    private UserRepository $userRepository;

    public function __construct()
    {
        $this->userRepository = new UserRepository();
    }

    public function isAuthenticated(): bool
    {
        $this->startSession();

        return isset($_SESSION["user_id"]);
    }

    public function getUser(): ?User
    {
        $this->startSession();

        if (isset($_SESSION["user_id"]) && $_SESSION != null) {
            return $this->userRepository->getById($_SESSION["user_id"]);
        } else {
            return null;
        }
    }

    public function loginByUser(User $user): bool
    {
        $this->startSession();

        $_SESSION["user_id"] = $user->getId();

        return true;
    }

    public function loginByCredentials(LoginForm $loginForm): bool
    {
        $user = $this->userRepository->getByEmail($loginForm->getEmail());

        return $this->loginByUser($user);
    }

    public function logout(): void
    {
        $this->startSession();

        unset($_SESSION["user_id"]);
    }

    private function startSession(): void
    {
        set_error_handler(function() {}, E_WARNING);

        if (session_status() != PHP_SESSION_ACTIVE)
            session_start();

        restore_error_handler();
    }
}