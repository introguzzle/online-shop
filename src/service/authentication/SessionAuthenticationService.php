<?php

namespace service\authentication;

use dto\LoginDTO;
use entity\User;
use repository\UserRepository;

class SessionAuthenticationService implements AuthenticationService
{
    private static User $user;
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function isAuthenticated(): bool
    {
        $this->startSession();

        return isset($_SESSION["user_id"]) || isset(self::$user);
    }

    public function getUser(): ?User
    {
        $this->startSession();

        if (isset(self::$user)) {
            return self::$user;
        }

        if (isset($_SESSION["user_id"])) {
            return $this->userRepository->getById($_SESSION["user_id"]);
        }

        return null;
    }

    public function loginByUser(User $user): bool
    {
        $this->startSession();

        $_SESSION["user_id"] = $user->getId();
        
        if (!isset(self::$user)) {
            self::$user = $user;
        }

        return true;
    }

    public function loginByCredentials(LoginDTO $loginDTO): bool
    {
        $user = $this->userRepository->getByEmail($loginDTO->getEmail());

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