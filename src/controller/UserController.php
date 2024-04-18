<?php

namespace controller;

use dto\LoginDTO;
use dto\RegistrationDTO;

use request\LoginRequest;
use request\RegistrationRequest;

use service\authentication\AuthenticationService;
use service\RegistrationService;
use util\Requests;
use validation\LoginValidator;
use validation\RegistrationValidator;

class UserController extends Controller
{
    private AuthenticationService $loginService;
    private RegistrationService $registrationService;
    private LoginValidator $loginValidator;
    private RegistrationValidator $registrationValidator;

    public function __construct(
        AuthenticationService $authenticationService,
        RegistrationService   $registrationService,
        LoginValidator        $loginValidator,
        RegistrationValidator $registrationValidator
    )
    {
        parent::__construct();
        $this->loginService = $authenticationService;
        $this->registrationService = $registrationService;
        $this->loginValidator = $loginValidator;
        $this->registrationValidator = $registrationValidator;
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
        $dto    = Requests::toDTO($loginRequest, LoginDTO::class);
        $errors = $this->loginValidator->validate($dto);

        if ($errors->hasNone() && $this->loginService->loginByCredentials($dto)) {
            header("Location: /home");
            return;
        }

        require_once $this->renderer->render("login.phtml", "Login");
    }

    public function logout(): void
    {
        $this->loginService->logout();
        header("Location: /login");
    }

    public function register(RegistrationRequest $registrationRequest): void
    {
        $dto     = Requests::toDTO($registrationRequest, RegistrationDTO::class);
        $errors  = $this->registrationValidator->validate($dto);

        if ($errors->hasNone() && $this->registrationService->processRegistration($dto)) {
            header("Location: /login");
            return;
        }

        require_once $this->renderer->render("registration.phtml", "Registration");
    }
}