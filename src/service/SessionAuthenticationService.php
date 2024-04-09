<?php

namespace service;

use repository\UserRepository;
use dto\User;

class SessionAuthenticationService implements AuthenticationService {
    private UserRepository $userRepository;

    public function __construct() {
        $this->userRepository = new UserRepository();
    }

    public function isAuthenticated(): bool {
        session_start();
        return isset($_SESSION["user_id"]);
    }

    public function getUser(): ?User {
        if (session_status() == PHP_SESSION_NONE)
            session_start();

        if (isset($_SESSION["user_id"]) && $_SESSION != null) {
            return $this->userRepository->getById($_SESSION["user_id"]);
        } else {
            return null;
        }
    }

    public function login(User $user): bool {
        session_start();

        $_SESSION["user_id"] = $user->getId();
        $_SESSION["user_email"] = $user->getEmail();
        $_SESSION["user_name"] = $user->getName();

        return true;
    }

    public function logout(): void {
        session_start();

        unset($_SESSION["user_id"]);
        unset($_SESSION["user_email"]);
        unset($_SESSION["user_name"]);
    }
}