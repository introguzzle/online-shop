<?php

namespace service;

use repository\UserRepository;
use dto\User;

class SessionAuthenticationService implements AuthenticationService {
    private static ?User $user;
    private UserRepository $userRepository;

    public function __construct() {
        $this->userRepository = new UserRepository();
    }

    public function check(): bool {
        session_start();
        return isset($_SESSION["user_id"]);
    }

    public function getCurrentUser(): ?User {
        if (isset(self::$user)) {
            return self::$user;
        }

        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        if (isset($_SESSION["user_id"])) {
            return $this->userRepository->getById($_SESSION["user_id"]);
        } else {
            return null;
        }
    }

    public function login(User $user): bool {
        session_start();
        self::$user = $user;

        $_SESSION["user_id"] = $user->getId();
        return true;
    }

    public function logout(): void {
        session_start();
        self::$user = null;

        session_destroy();
    }
}