<?php

namespace service;

use dto\Errors;
use dto\LoginForm;
use repository\UserRepository;
use entity\User;

class LoginService implements Service
{

    private AuthenticationService $authService;
    private UserRepository $userRepository;

    public function __construct()
    {
        $this->authService = new SessionAuthenticationService();
        $this->userRepository = new UserRepository();
    }

    public function processAuthentication(
        LoginForm $loginForm
    ): Errors
    {
        $errors = Errors::create();
        $user = $this->userRepository->getByEmail($loginForm->getEmail());

        if (isset($user) && password_verify($loginForm->getPassword(), $user->getPassword())) {
            $this->loginByUser($user);
            return $errors;
        }

        $errors->add("user", "Invalid email or password");
        return $errors;
    }

    public function loginByUser(User $user): void
    {
        $this->authService->loginByUser($user);
    }

    public function loginByCredentials(LoginForm $loginForm): void
    {
        $this->authService->loginByCredentials($loginForm);
    }

    public function logout(): void
    {
        $this->authService->logout();
    }
}