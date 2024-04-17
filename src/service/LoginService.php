<?php

namespace service;

use dto\Errors;
use dto\LoginDTO;
use entity\User;
use repository\UserRepository;
use service\authentication\AuthenticationService;
use validation\LoginValidator;
use validation\Validator;

class LoginService implements Service
{

    private AuthenticationService $authService;
    private UserRepository $userRepository;
    private Validator $validator;

    public function __construct(
        AuthenticationService $authenticationService,
        UserRepository $userRepository,
        LoginValidator $validator
    )
    {
        $this->authService = $authenticationService;
        $this->userRepository = $userRepository;
        $this->validator = $validator;
    }

    public function processAuthentication(
        LoginDTO $loginDTO
    ): Errors
    {
        $errors = $this->validator->validate($loginDTO);

        if ($errors->hasAny()) {
            return $errors;
        }

        $user = $this->userRepository->getByEmail($loginDTO->getEmail());

        if (isset($user) && password_verify($loginDTO->getPassword(), $user->getPassword())) {
            $this->loginByUser($user);
            return $errors;
        }

        $errors->add("user", "Invalid email or password");
        return $errors;
    }

    private function loginByUser(User $user): bool
    {
        return $this->authService->loginByUser($user);
    }

    private function loginByCredentials(LoginDTO $loginDTO): bool
    {
        return $this->authService->loginByCredentials($loginDTO);
    }

    public function logout(): void
    {
        $this->authService->logout();
    }
}