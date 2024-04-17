<?php

namespace controller;

use dto\LoginDTO;
use dto\RegistrationDTO;

use request\LoginRequest;
use request\RegistrationRequest;

use service\LoginService;
use service\RegistrationService;

class UserController extends Controller
{
    private LoginService $loginService;
    private RegistrationService $registrationService;

    public function __construct(
        LoginService $loginService,
        RegistrationService $registrationService
    )
    {
        parent::__construct();
        $this->loginService = $loginService;
        $this->registrationService = $registrationService;
    }

    public function loginView(): void
    {
        require_once $this->renderer->render("login.phtml", "Login");
    }

    public function registrationView(): void
    {
        require_once $this->renderer->render("registration.phtml", "Registration");
    }

    public function login(LoginRequest $loginRequest): void
    {
        $loginDTO = $this->toLoginDTO($loginRequest);
        $errors = $this->loginService->processAuthentication($loginDTO);

        if ($errors->hasNone()) {
            header("Location: /home");

        } else {
            require_once $this->renderer->render("login.phtml", "Login");
        }
    }

    public function logout(): void
    {
        $this->loginService->logout();
        header("Location: /login");
    }

    public function register(RegistrationRequest $registrationRequest): void
    {
        $registrationDTO = $this->toRegistrationDTO($registrationRequest);
        $errors = $this->registrationService->processRegistration($registrationDTO);

        if ($errors->hasNone()) {
            header("Location: /login");

        } else {
            require_once $this->renderer->render("registration.phtml", "Registration");
        }
    }

    private function toLoginDTO(
        LoginRequest $loginRequest
    ): LoginDTO
    {
        return new LoginDTO(
            $loginRequest->getEmail(),
            $loginRequest->getPassword()
        );
    }

    private function toRegistrationDTO(
        RegistrationRequest $registrationRequest
    ): RegistrationDTO
    {
        return new RegistrationDTO(
            $registrationRequest->getName(),
            $registrationRequest->getEmail(),
            $registrationRequest->getPassword(),
            $registrationRequest->getPasswordRepeat()
        );
    }
}