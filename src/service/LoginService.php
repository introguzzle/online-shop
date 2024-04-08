<?php

namespace service;

use repository\UserRepository;
use dto\User;
use request\LoginRequest;

class LoginService {

    private array $errors = [];
    private AuthenticationService $authService;
    private UserRepository $userRepository;

    public function __construct() {
        $this->authService = new SessionAuthenticationService();
        $this->userRepository = new UserRepository();
    }

    public function proceed(): true | array {
        $loginRequest = $this->toRequest();

        if (!isset($loginRequest)) {
            $this->registerErrors();
            return $this->errors;
        }

        $user = $this->userRepository->getByEmail($loginRequest->getEmail());

        if (!isset($user) || !password_verify($loginRequest->getPassword(), $user->getPassword())) {
            $this->registerErrors();
            return $this->errors;
        }

        $this->login($user);
        return true;
    }

    private function toRequest(): ?LoginRequest {
        $email = $_REQUEST["email"] ?? null;
        $password = $_REQUEST["psw"] ?? null;

        if (isset($_REQUEST["remember"]))
            $remember = "0";
        else
            $remember = "1";

        return $email === null || $password === null
            ? null
            : new LoginRequest($email, $password, $remember);
    }

    public function login(User $user): void {
        $this->authService->login($user);
    }

    public function logout(): void {
        $this->authService->logout();
    }

    private function registerErrors(): void {
        $this->errors["user"] = "Invalid email or password";
    }
}