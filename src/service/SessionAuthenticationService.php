<?php

namespace service;

use repository\UserRepository;
use dto\User;

class SessionAuthenticationService implements AuthenticationService {
    private ?User $user;
    private UserRepository $userRepository;

    public function __construct() {
        $this->userRepository = new UserRepository();
    }

    public function check(): bool {
        session_start();
        return isset($_SESSION["user_id"]);
    }

    public function getCurrentUser(): ?User {
        if (isset($this->user)) {
            return $this->user;
        }

        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        return $this->userRepository->getById($_SESSION["user_id"]);
    }

    public function login(User $user, bool $setLifeTime): bool {
        $this->user = $user;

        session_start();

        if ($setLifeTime)
            session_set_cookie_params(3000);

        $_SESSION["user_id"] = $user->getId();
        return true;
    }

    public function logout(): void {
        $this->user = null;

        session_start();
        unset($_SESSION["user_id"]);

        session_unset();
        session_destroy();
    }
}